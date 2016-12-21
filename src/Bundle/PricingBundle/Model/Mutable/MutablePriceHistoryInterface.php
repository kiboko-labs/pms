<?php

namespace Kiboko\Bundle\PricingBundle\Model\Mutable;

use Kiboko\Bundle\PricingBundle\Model\PriceHistoryInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceInterface;

interface MutablePriceHistoryInterface extends PriceHistoryInterface, MutablePriceAmountInterface
{
    /**
     * @param \DateTimeInterface $date
     *
     * @return MutablePriceHistoryInterface
     */
    public function setDate(\DateTimeInterface $date) : MutablePriceHistoryInterface;

    /**
     * @param PriceInterface $price
     *
     * @return MutablePriceHistoryInterface
     */
    public function setPrice(PriceInterface $price): MutablePriceHistoryInterface;
}
