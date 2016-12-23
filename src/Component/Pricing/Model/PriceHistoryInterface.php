<?php

namespace Kiboko\Component\Pricing\Model;

/**
 * Class Price
 *
 * @package Kiboko\Component\Pricing\Entity
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
