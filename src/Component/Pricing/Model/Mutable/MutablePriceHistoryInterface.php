<?php

namespace Kiboko\Component\Pricing\Model\Mutable;

use Kiboko\Component\Pricing\Model\PriceHistoryInterface;
use Kiboko\Component\Pricing\Model\PriceInterface;

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
