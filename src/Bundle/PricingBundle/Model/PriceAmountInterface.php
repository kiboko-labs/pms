<?php

namespace Kiboko\Bundle\PricingBundle\Model;

use Brick\Math\BigNumber;

interface PriceAmountInterface
{
    /**
     * @return BigNumber
     */
    public function getAmount() : BigNumber;

    /**
     * @return string
     */
    public function getCurrencyCode() : string;
}
