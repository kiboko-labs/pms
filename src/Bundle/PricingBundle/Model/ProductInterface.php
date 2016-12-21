<?php

namespace Kiboko\Bundle\PricingBundle\Model;

use Doctrine\Common\Collections\Collection;

interface ProductInterface
{
    /**
     * @param PriceListInterface $priceList
     *
     * @return ProductInterface
     */
    public function addPriceList(PriceListInterface $priceList) : ProductInterface;

    /**
     * @param PriceListInterface $priceList
     *
     * @return ProductInterface
     */
    public function removePriceList(PriceListInterface $priceList) : ProductInterface;

    /**
     * @return Collection|PriceListInterface[]
     */
    public function getPriceLists() : array;

    /**
     * @param Collection|PriceListInterface[] $priceLists
     *
     * @return ProductInterface
     */
    public function setPriceLists(array $priceLists) : ProductInterface;
}
