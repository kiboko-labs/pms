<?php

namespace Kiboko\Component\TFTConnector\Writer;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Item\InvalidItemException;
use Akeneo\Bundle\BatchBundle\Item\ItemWriterInterface;
use Akeneo\Bundle\BatchBundle\Step\StepExecutionAwareInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;

class MagentoStocksWriter implements ItemWriterInterface, StepExecutionAwareInterface
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
    private $searchProductStockIdStatement;

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

        $searchAttributeIdStatement->execute(['status']);
        $statusAttributeId = $searchAttributeIdStatement->fetchColumn(0);
        $searchAttributeIdStatement->closeCursor();

        $qb = $this->connection->createQueryBuilder();
        $qb->select(['e.entity_id'])
            ->from('catalog_product_entity', 'e')
            ->innerJoin('e', 'catalog_product_entity_int', 'status', $qb->expr()->andX(
                $qb->expr()->eq('e.entity_id', 'status.entity_id'),
                $qb->expr()->eq('status.store_id', $qb->expr()->literal(0)),
                $qb->expr()->eq('status.attribute_id', $qb->expr()->literal($statusAttributeId))
            ))
            ->where($qb->expr()->andX(
                $qb->expr()->eq('e.sku', '?'),
                $qb->expr()->eq('status.value', $qb->expr()->literal(1))
            ))
            ->setMaxResults(1);

        $this->searchProductIdStatement = $this->connection->prepare($qb);

        $qb = $this->connection->createQueryBuilder();
        $qb->select(['s.item_id'])
            ->from('cataloginventory_stock_item', 's')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('s.product_id', ':productId')),
                $qb->expr()->eq('s.stock_id', $qb->expr()->literal(1))
            )
            ->setMaxResults(1);

        $this->searchProductStockIdStatement = $this->connection->prepare($qb);
    }

    public function write(array $items)
    {
        foreach ($items as $item) {
            $productId = $this->findProductId($item['sku']);
            if (!$productId) {
//                $this->stepExecution->addWarning(
//                    'The product %sku% was not found',
//                    [
//                        '%sku%' => $item['sku'],
//                    ],
//                    new DataInvalidItem($item)
//                );
                continue;
            }

            $this->connection->beginTransaction();
            if (!$this->updateProductInventoryStock($productId, $item['stock'])) {
                $this->connection->rollBack();
                $this->stepExecution->addWarning(
                    'The inventory stock of product %sku% could not be updated, no initial value was found.',
                    [
                        '%sku%' => $item['sku'],
                    ],
                    new DataInvalidItem($item)
                );
                continue;
            }
            $this->stepExecution->incrementWriteCount();
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

    private function updateProductInventoryStock($productId, $value)
    {
        if (!$this->searchProductStockIdStatement->execute(
            [
                ':productId' => $productId,
            ]
        )) {
            return false;
        }

        $itemId = $this->searchProductStockIdStatement->fetchColumn();
        $this->searchProductStockIdStatement->closeCursor();
        if (!$itemId) {
            return false;
        }

        $this->connection->update(
            'cataloginventory_stock_item',
            [
                'qty' => $value,
            ],
            [
                'item_id' => $itemId,
            ]
        );

        return true;
    }
}
