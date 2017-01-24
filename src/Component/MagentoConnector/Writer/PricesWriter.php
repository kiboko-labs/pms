<?php

namespace Kiboko\Component\MagentoConnector\Writer;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Item\InvalidItemException;
use Akeneo\Bundle\BatchBundle\Item\ItemWriterInterface;
use Akeneo\Bundle\BatchBundle\Step\StepExecutionAwareInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;

class PricesWriter implements ItemWriterInterface, StepExecutionAwareInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var StepExecution
     */
    private $stepExecution;

    /**
     * @var Statement
     */
    private $searchProductIdStatement;

    /**
     * @var Statement
     */
    private $searchProductValueDecimal;

    /**
     * @var Statement
     */
    private $searchProductValueDatetime;

    /**
     * @var int
     */
    private $priceAttributeId;

    /**
     * @var int
     */
    private $specialPriceAttributeId;

    /**
     * @var int
     */
    private $specialFromDateAttributeId;

    /**
     * @var int
     */
    private $specialToDateAttributeId;

    /**
     * MagentoPricesWriter constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param StepExecution $stepExecution
     *
     * @return $this
     */
    public function setStepExecution(StepExecution $stepExecution)
    {
        $this->stepExecution = $stepExecution;

        return $this;
    }

    public function initialize()
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select(['attribute_id'])
            ->from('eav_attribute', 'a')
            ->where($qb->expr()->eq('a.attribute_code', '?'))
            ->setMaxResults(1)
        ;

        $searchAttributeIdStatement = $this->connection->prepare($qb);

        $searchAttributeIdStatement->execute(['price']);
        $this->priceAttributeId = $searchAttributeIdStatement->fetchColumn(0);
        $searchAttributeIdStatement->closeCursor();

        $searchAttributeIdStatement->execute(['special_price']);
        $this->specialPriceAttributeId = $searchAttributeIdStatement->fetchColumn(0);
        $searchAttributeIdStatement->closeCursor();

        $searchAttributeIdStatement->execute(['special_from_date']);
        $this->specialFromDateAttributeId = $searchAttributeIdStatement->fetchColumn(0);
        $searchAttributeIdStatement->closeCursor();

        $searchAttributeIdStatement->execute(['special_to_date']);
        $this->specialToDateAttributeId = $searchAttributeIdStatement->fetchColumn(0);
        $searchAttributeIdStatement->closeCursor();

        $searchAttributeIdStatement->execute(['status']);
        $statusAttributeId = $searchAttributeIdStatement->fetchColumn(0);
        $searchAttributeIdStatement->closeCursor();

        $searchAttributeIdStatement->execute(['visibility']);
        $visibilityAttributeId = $searchAttributeIdStatement->fetchColumn(0);
        $searchAttributeIdStatement->closeCursor();

        $qb = $this->connection->createQueryBuilder();
        $qb->select(['e.entity_id'])
            ->from('catalog_product_entity', 'e')
            ->innerJoin('e', 'catalog_product_entity_int', 'status', $qb->expr()->andX(
                $qb->expr()->eq('e.entity_id', 'status.entity_id'),
                $qb->expr()->eq('status.store_id', $qb->expr()->literal(0)),
                $qb->expr()->eq('status.attribute_id', $qb->expr()->literal($statusAttributeId))
            ))
            ->innerJoin('e', 'catalog_product_entity_int', 'visibility', $qb->expr()->andX(
                $qb->expr()->eq('e.entity_id', 'visibility.entity_id'),
                $qb->expr()->eq('visibility.store_id', $qb->expr()->literal(0)),
                $qb->expr()->eq('visibility.attribute_id', $qb->expr()->literal($visibilityAttributeId))
            ))
            ->where($qb->expr()->andX(
                $qb->expr()->eq('e.sku', '?'),
                $qb->expr()->eq('status.value', $qb->expr()->literal(1)),
                $qb->expr()->in('visibility.value',
                    [
                        $qb->expr()->literal(2),
                        $qb->expr()->literal(3),
                        $qb->expr()->literal(4),
                    ]
                )
            ))
            ->setMaxResults(1);

        $this->searchProductIdStatement = $this->connection->prepare($qb);

        $this->searchProductValueDecimal = $this->initializeSearchProductValueStatement(
            'catalog_product_entity_decimal'
        );
        $this->searchProductValueDatetime = $this->initializeSearchProductValueStatement(
            'catalog_product_entity_datetime'
        );
    }

    private function initializeSearchProductValueStatement($table)
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select(['v.value_id'])
            ->from($table, 'v')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('v.entity_id', ':entityId'),
                    $qb->expr()->eq('v.attribute_id', ':attributeId'),
                    $qb->expr()->eq('v.store_id', ':storeId')
                )
            )
            ->setMaxResults(1)
        ;

        return $this->connection->prepare($qb);
    }

    /**
     * @param array $items
     *
     * @throws InvalidItemException
     */
    public function write(array $items)
    {
        $now = new \DateTimeImmutable();

        foreach ($items as $item) {
            $productId = $this->findProductId($item['sku']);
            if (!$productId) {
//                $this->stepExecution->addWarning(
//                    $this->stepExecution->getStepName(),
//                    'The product %sku% was not found',
//                    [
//                        '%sku%' => $item['sku'],
//                    ],
//                    $item
//                );
                continue;
            }

            $this->connection->beginTransaction();
            if (!$this->updateProductDecimalValue($productId, $this->priceAttributeId, $item['price'], $this->stepExecution->getJobParameters()->get('storeId'))) {
                $this->connection->rollBack();
                $this->stepExecution->addWarning(
                    $this->stepExecution->getStepName(),
                    'The price of product %sku% could not be updated, no initial value was found.',
                    [
                        '%sku%' => $item['sku'],
                    ],
                    $item
                );
                continue;
            }

            $this->stepExecution->incrementWriteCount();

            if ($item['discountedPrice'] >= $item['price']) {
                $this->connection->commit();
                continue;
            }
            if (!$item['startDate'] instanceof \DateTimeInterface || $item['startDate'] > $now) {
                $this->connection->commit();
                continue;
            }
            if (!$item['endDate'] instanceof \DateTimeInterface || $item['endDate'] < $now) {
                $this->connection->commit();
                continue;
            }

            if (!$this->updateProductDecimalValue($productId, $this->specialPriceAttributeId, $item['discountedPrice'], $this->stepExecution->getJobParameters()->get('storeId'))) {
                $this->connection->rollBack();
                $this->stepExecution->addWarning(
                    $this->stepExecution->getStepName(),
                    'The special price of product %sku% could not be updated, no initial value was found.',
                    [
                        '%sku%' => $item['sku'],
                    ],
                    $item
                );
                continue;
            }

            if (!$this->updateProductDatetimeValue($productId, $this->specialFromDateAttributeId, $item['startDate'], $this->stepExecution->getJobParameters()->get('storeId'))) {
                $this->connection->rollBack();
                $this->stepExecution->addWarning(
                    $this->stepExecution->getStepName(),
                    'The special price starting date of product %sku% could not be updated, no initial value was found.',
                    [
                        '%sku%' => $item['sku'],
                    ],
                    $item
                );
                continue;
            }

            if (!$this->updateProductDatetimeValue($productId, $this->specialToDateAttributeId, $item['endDate'], $this->stepExecution->getJobParameters()->get('storeId'))) {
                $this->connection->rollBack();
                $this->stepExecution->addWarning(
                    $this->stepExecution->getStepName(),
                    'The special price ending date of product %sku% could not be updated, no initial value was found.',
                    [
                        '%sku%' => $item['sku'],
                    ],
                    $item
                );
                continue;
            }

            $this->connection->commit();
        }
    }

    private function findProductId($sku)
    {
        $this->searchProductIdStatement->execute([$sku]);
        $result = $this->searchProductIdStatement->fetchColumn(0);
        $this->searchProductIdStatement->closeCursor();

        return $result;
    }

    private function updateProductDecimalValue($productId, $attributeId, $value, $storeId)
    {
        if (!$this->searchProductValueDecimal->execute(
            [
                'attributeId' => $attributeId,
                'entityId' => $productId,
                'storeId' => 0
            ]
        )) {
            return false;
        }

        $valueId = $this->searchProductValueDecimal->fetchColumn();
        $this->searchProductValueDecimal->closeCursor();
        if (!$valueId) {
            if (!$this->searchProductValueDecimal->execute(
                [
                    ':attributeId' => $attributeId,
                    ':entityId' => $productId,
                    ':storeId' => $storeId
                ]
            )) {
                return false;
            }

            $valueId = $this->searchProductValueDecimal->fetchColumn();
            $this->searchProductValueDecimal->closeCursor();
            if (!$valueId) {
                $this->connection->insert(
                    'catalog_product_entity_decimal',
                    [
                        'entity_id' => $productId,
                        'attribute_id' => $attributeId,
                        'entity_type_id' => 4,
                        'store_id' => 0,
                        'value' => $value,
                    ]
                );
                return true;
            }
        }

        $this->connection->update(
            'catalog_product_entity_decimal',
            [
                'value' => $value,
            ],
            [
                'value_id' => $valueId,
            ]
        );

        return true;
    }

    private function updateProductDatetimeValue($productId, $attributeId, \DateTimeInterface $value, $storeId)
    {
        if (!$this->searchProductValueDatetime->execute(
            [
                ':attributeId' => $attributeId,
                ':entityId' => $productId,
                ':storeId' => 0
            ]
        )) {
            return false;
        }

        $valueId = $this->searchProductValueDatetime->fetchColumn();
        $this->searchProductValueDatetime->closeCursor();
        if (!$valueId) {
            if (!$this->searchProductValueDatetime->execute(
                [
                    ':attributeId' => $attributeId,
                    ':entityId' => $productId,
                    ':storeId' => $storeId
                ]
            )) {
                return false;
            }

            $valueId = $this->searchProductValueDatetime->fetchColumn();
            $this->searchProductValueDatetime->closeCursor();
            if (!$valueId) {
                $this->connection->insert(
                    'catalog_product_entity_datetime',
                    [
                        'entity_id' => $productId,
                        'attribute_id' => $attributeId,
                        'entity_type_id' => 4,
                        'store_id' => 0,
                        'value' => $value->format('Y-m-d H:i:s'),
                    ]
                );
                return true;
            }
        }

        $this->connection->update(
            'catalog_product_entity_datetime',
            [
                'value' => $value->format('Y-m-d H:i:s'),
            ],
            [
                'value_id' => $valueId,
            ]
        );

        return true;
    }
}
