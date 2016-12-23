<?php

namespace Kiboko\Component\Pricing\Model;

use Kiboko\Bundle\PricingBundle\Model\ProductInterface;

interface PriceListInterface
{
    /**
     * @param PriceInterface $price
     *
     * @return PriceListInterface
     */
    public function addPrice(PriceInterface $price) : PriceListInterface;

    /**
     * @param PriceInterface $price
     *
     * @return PriceListInterface
     */
    public function removePrice(PriceInterface $price) : PriceListInterface;

    /**
     * @param PriceInterface[] $prices
     *
     * @return PriceListInterface
     */
    public function setPrices(array $prices) : PriceListInterface;

    /**
     * @return PriceInterface[]
     */
    public function getPrices() : array;

    /**
     * @return ProductInterface
     */
    public function getProduct();

    /**
     * @return CustomerSegmentInterface
     */
    public function getCustomerSegment();
}
