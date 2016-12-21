<?php

namespace Kiboko\Bundle\PricingBundle\Model;

interface PriceInterface extends PriceAmountInterface
{
    /**
     * @return PriceListInterface
     */
    public function getPriceList(): PriceListInterface;

    /**
     * @return PriceHistoryInterface[]
     */
    public function getPriceHistory() : array;
}
