<?php

namespace Kiboko\Bundle\PricingManagementBundle\Entity;

use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Pricing\Model\Mutable\MutablePriceHistoryInterface;
use Kiboko\Component\Pricing\Model\PriceInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Price
 *
 * @package Kiboko\Bundle\PricingManagementBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_price_history")
 */
class PriceHistory extends PriceAmount implements MutablePriceHistoryInterface, IdentifiableInterface
{
    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var PriceInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\PricingManagementBundle\Entity\Price", inversedBy="priceHistory")
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
