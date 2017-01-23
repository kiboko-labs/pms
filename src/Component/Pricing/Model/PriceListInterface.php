<?php

namespace Kiboko\Component\Pricing\Model;

use Kiboko\Component\Product\Model\ProductInterface;

interface PriceListInterface extends CustomerSegmentSubjectInterface
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
    public function getCustomerSegment() : CustomerSegmentInterface;
}
