<?php

namespace Kiboko\Component\MagentoConnector\Writer;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Item\InvalidItemException;
use Akeneo\Bundle\BatchBundle\Item\ItemWriterInterface;
use Akeneo\Bundle\BatchBundle\Step\StepExecutionAwareInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;

class PromotionCategoryWriter implements ItemWriterInterface, StepExecutionAwareInterface
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
    private $searchCategoryAssociationStatement;

    /**
     * @var int
     */
    private $promotionCategoryId;

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

        $qb = $this->connection->createQueryBuilder();
        $qb->select(['COUNT(*)'])
            ->from('catalog_category_product', 'cp')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('cp.category_id', ':categoryId'),
                $qb->expr()->eq('cp.product_id', ':productId')
            ))
            ->setMaxResults(1);

        $this->searchCategoryAssociationStatement = $this->connection->prepare($qb);

        $this->promotionCategoryId = $this->stepExecution->getExecutionContext()->get('promotionCategory');
    }

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

            $hasAssociation = $this->hasCategoryAssociation($productId, $this->promotionCategoryId);

            if (isset($item['parent']) && !empty($item['parent'])) {
                if ($hasAssociation) {
                    $this->connection->beginTransaction();
                    $this->removeCategoryAssociation($productId, $this->promotionCategoryId);
                    $this->connection->commit();
                    $this->stepExecution->incrementWriteCount();
                }
                continue;
            }

            if ($item['discountedPrice'] >= $item['price'] ||
                $item['startDate'] > $now ||
                $item['endDate'] < $now
            ) {
                if ($hasAssociation) {
                    $this->connection->beginTransaction();
                    $this->removeCategoryAssociation($productId, $this->promotionCategoryId);
                    $this->connection->commit();
                    $this->stepExecution->incrementWriteCount();
                }
                continue;
            } else {
                if (!$hasAssociation) {
                    $this->connection->beginTransaction();
                    $this->enforceCategoryAssociation($productId, $this->promotionCategoryId);
                    $this->connection->commit();
                    $this->stepExecution->incrementWriteCount();
                }
            }
        }
    }

    private function findProductId($sku)
    {
        $this->searchProductIdStatement->execute([$sku]);
        $result = $this->searchProductIdStatement->fetchColumn(0);
        $this->searchProductIdStatement->closeCursor();

        return $result;
    }

    private function hasCategoryAssociation($productId, $categoryId)
    {
        $this->searchCategoryAssociationStatement->execute([
            'productId' => $productId,
            'categoryId' => $categoryId,
        ]);

        $result = $this->searchCategoryAssociationStatement->fetchColumn(0);
        $this->searchCategoryAssociationStatement->closeCursor();

        return $result > 0;
    }

    private function enforceCategoryAssociation($productId, $categoryId)
    {
        $this->connection->insert('catalog_category_product',
            [
                'category_id' => $categoryId,
                'product_id' => $productId,
                'position' => 1000,
            ]
        );
    }

    private function removeCategoryAssociation($productId, $categoryId)
    {
        $this->connection->delete('catalog_category_product',
            [
                'category_id' => $categoryId,
                'product_id' => $productId,
            ]
        );
    }
}
