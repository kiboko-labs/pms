<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use Kiboko\Bundle\PricingBundle\Model\Mutable\MutablePriceInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceHistoryInterface;

use Doctrine\ORM\Mapping as ORM;
use Kiboko\Bundle\PricingBundle\Model\PriceListInterface;

/**
 * Class Price
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_price")
 */
class Price extends PriceAmount implements MutablePriceInterface, IdentifiableInterface
{
    /**
     * @var PriceListInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\PricingBundle\Entity\PriceList", inversedBy="prices")
     * @ORM\JoinColumn(name="price_list_id", referencedColumnName="id")
     */
    private $priceList;

    /**
     * @var Collection|PriceHistoryInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingBundle\Entity\PriceHistory", mappedBy="price")
     */
    private $priceHistory;

    /**
     * Price constructor.
     */
    public function __construct()
    {
        $this->priceHistory = new ArrayCollection();
    }

    /**
     * @return PriceListInterface
     */
    public function getPriceList(): PriceListInterface
    {
        return $this->priceList;
    }

    /**
     * @param PriceListInterface $priceList
     *
     * @return MutablePriceInterface
     */
    public function setPriceList(PriceListInterface $priceList) : MutablePriceInterface
    {
        $this->priceList = $priceList;

        return $this;
    }

    /**
     * @return PriceHistoryInterface[]
     */
    public function getPriceHistory() : array
    {
        return $this->priceHistory->toArray();
    }

    /**
     * @param PriceHistoryInterface[] $priceHistory
     *
     * @return MutablePriceInterface
     */
    public function setPriceHistory(array $priceHistory) : MutablePriceInterface
    {
        $this->priceHistory = $priceHistory;

        return $this;
    }
}
