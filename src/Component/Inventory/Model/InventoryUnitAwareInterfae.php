<?php

namespace Kiboko\Component\Inventory\Model;

interface InventoryUnitAwareInterfae
{
    /**
     * @return InventoryUnitInterface
     */
    public function getInventoryUnit() : InventoryUnitInterface;
}
