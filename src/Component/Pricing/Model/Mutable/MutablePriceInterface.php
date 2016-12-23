<?php

namespace Kiboko\Component\Pricing\Model\Mutable;

use Kiboko\Component\Pricing\Model\PriceHistoryInterface;
use Kiboko\Component\Pricing\Model\PriceInterface;
use Kiboko\Component\Pricing\Model\PriceListInterface;

interface MutablePriceInterface extends PriceInterface, MutablePriceAmountInterface
{
    /**
     * @param PriceListInterface $priceList
     *
     * @return MutablePriceInterface
     */
    public function setPriceList(PriceListInterface $priceList): MutablePriceInterface;

    /**
     * @param PriceHistoryInterface[] $priceHistory
     *
     * @return MutablePriceInterface
     */
    public function setPriceHistory(array $priceHistory) : MutablePriceInterface;
}
