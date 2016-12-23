<?php

namespace Kiboko\Component\Pricing\Model;

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
