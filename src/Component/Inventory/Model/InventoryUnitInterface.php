<?php

namespace Kiboko\Component\Inventory\Model;

use Brick\Math\BigNumber;

interface InventoryUnitInterface
{
    /**
     * @return BigNumber
     */
    public function getOnHandAmount() : BigNumber;

    /**
     * @return BigNumber
     */
    public function getReservedAmount() : BigNumber;

    /**
     * @return BigNumber
     */
    public function getIncomingAmount() : BigNumber;

    /**
     * @return BigNumber
     */
    public function getForecastedAmount() : BigNumber;
}
