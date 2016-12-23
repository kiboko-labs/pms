<?php


namespace Kiboko\Component\Inventory\Model;

interface WarehouseAwareInterface
{
    /**
     * @return WarehouseInterface
     */
    public function getWarehouse() : WarehouseInterface;
}
