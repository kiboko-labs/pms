<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Component\Inventory\Model\WarehouseAwareInterface;
use Kiboko\Component\Inventory\Model\WarehouseInterface;
use Kiboko\Component\Product\Model\ProductInterface;

/**
 * Class WarehouseInventoryUnit
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_warehouse_inventory_unit")
 */
class WarehouseInventoryUnit extends BaseInventoryUnit implements WarehouseAwareInterface
{
    /**
     * @var WarehouseInterface
     */
    private $warehouse;

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
}
