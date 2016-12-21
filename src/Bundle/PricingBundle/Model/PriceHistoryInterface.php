<?php

namespace Kiboko\Bundle\PricingBundle\Model;

/**
 * Class Price
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_price_history")
 */
interface PriceHistoryInterface extends PriceAmountInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getDate() : \DateTimeInterface;

    /**
     * @return PriceInterface
     */
    public function getPrice() : PriceInterface;
}
