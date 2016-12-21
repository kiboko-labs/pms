<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use Kiboko\Bundle\PricingBundle\Model\Mutable\MutablePriceHistoryInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceHistoryInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Price
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_price_history")
 */
class PriceHistory extends PriceAmount implements MutablePriceHistoryInterface, IdentifiableInterface
{
    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * @var PriceInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\PricingBundle\Entity\Price", inversedBy="priceHistory")
     * @ORM\JoinColumn(name="price_id", referencedColumnName="id")
     */
    private $price;

    /**
     * @return \DateTimeInterface
     */
    public function getDate() : \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     *
     * @return MutablePriceHistoryInterface
     */
    public function setDate(\DateTimeInterface $date) : MutablePriceHistoryInterface
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return PriceInterface
     */
    public function getPrice() : PriceInterface
    {
        return $this->price;
    }

    /**
     * @param PriceInterface $price
     *
     * @return MutablePriceHistoryInterface
     */
    public function setPrice(PriceInterface $price): MutablePriceHistoryInterface
    {
        $this->price = $price;

        return $this;
    }
}
