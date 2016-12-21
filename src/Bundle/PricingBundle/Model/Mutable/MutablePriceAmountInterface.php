<?php

namespace Kiboko\Bundle\PricingBundle\Model\Mutable;

use Brick\Math\BigNumber;
use Kiboko\Bundle\PricingBundle\Model\PriceAmountInterface;

interface MutablePriceAmountInterface extends PriceAmountInterface
{
    /**
     * @param mixed $id
     *
     * @return MutablePriceAmountInterface
     */
    public function setId($id) : MutablePriceAmountInterface;

    /**
     * @param BigNumber $amount
     *
     * @return MutablePriceAmountInterface
     */
    public function setAmount(BigNumber $amount) : MutablePriceAmountInterface;

    /**
     * @param string $currencyCode
     *
     * @return MutablePriceAmountInterface
     */
    public function setCurrencyCode(string $currencyCode) : MutablePriceAmountInterface;
}
