<?php

namespace Kiboko\Bundle\PricingBundle\Model\Mutable;

use Kiboko\Bundle\PricingBundle\Model\PriceHistoryInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceListInterface;

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
