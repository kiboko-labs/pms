<?php

namespace Kiboko\Bundle\InventoryBundle\Entity;

use Kiboko\Component\Inventory\Model\WarehouseAwareInterface;
use Kiboko\Component\Inventory\Model\WarehouseInterface;
use Kiboko\Component\Product\Model\ProductInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class WarehouseInventoryUnit
 *
 * @package Kiboko\Bundle\InventoryBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_inventory_warehouse_inventory_unit")
 */
class WarehouseInventoryUnit extends BaseInventoryUnit implements WarehouseAwareInterface
{
    /**
     * @var WarehouseInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\InventoryBundle\Entity\Warehouse", inversedBy="inventoryUnits")
     * @ORM\JoinColumn(name="warehouse_id", referencedColumnName="id")
     */
    private $warehouse;

    /**
     * @var ProductInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\CatalogBundle\Entity\Product", inversedBy="inventoryUnits")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var ProductInventoryUnit
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\InventoryBundle\Entity\ProductInventoryUnit", inversedBy="warehouseInventoryUnits")
     * @ORM\JoinColumn(name="product_inventory_unit_id", referencedColumnName="id")
     */
    private $productInventoryUnit;

    /**
     * @return WarehouseInterface
     */
    public function getWarehouse() : WarehouseInterface
    {
        return $this->warehouse;
    }

    /**
     * @param WarehouseInterface $warehouse
     *
     * @return WarehouseInventoryUnit
     */
    public function setWarehouse(WarehouseInterface $warehouse) : WarehouseInventoryUnit
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct() : ProductInterface
    {
        return $this->product;
    }

    /**
     * @param ProductInterface $product
     *
     * @return BaseInventoryUnit
     */
    public function setProduct(ProductInterface $product) : BaseInventoryUnit
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return ProductInventoryUnit
     */
    public function getProductInventoryUnit() : ProductInventoryUnit
    {
        return $this->productInventoryUnit;
    }

    /**
     * @param ProductInventoryUnit $productInventoryUnit
     *
     * @return WarehouseInventoryUnit
     */
    public function setProductInventoryUnit(ProductInventoryUnit $productInventoryUnit): WarehouseInventoryUnit
    {
        $this->productInventoryUnit = $productInventoryUnit;

        return $this;
    }
}
