<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\DataModel\Model\ActivableInterface;
use Kiboko\Component\DataModel\Model\DateIntervalInterface;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Pricing\Model\CustomerSegmentInterface;
use Kiboko\Component\Pricing\Model\PriceInterface;
use Kiboko\Component\Pricing\Model\PriceListInterface;
use Kiboko\Component\Product\Model\ProductInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PriceList
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_price_list")
 */
class PriceList implements PriceListInterface, IdentifiableInterface, NamedInterface, ActivableInterface, DateIntervalInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingBundle\Entity\Price", mappedBy="priceList")
     */
    private $prices;

    /**
     * @var ProductInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\PricingBundle\Entity\Product", inversedBy="priceList")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var CustomerSegmentInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\PricingBundle\Entity\CustomerSegment", inversedBy="priceList")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $customerSegment;

    /**
     * PriceList constructor.
     *
     * @param string $name
     * @param PriceInterface[] $prices
     */
    public function __construct(string $name = null, array $prices = [])
    {
        $this->prices = new ArrayCollection($prices);
    }

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return PriceListInterface
     */
    public function setId($id) : PriceListInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PriceListInterface
     */
    public function setName(string $name) : PriceListInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return PriceListInterface
     */
    public function setActive(bool $active) : PriceListInterface
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStart() : \DateTimeInterface
    {
        return $this->start;
    }

    /**
     * @param \DateTimeInterface $start
     *
     * @return PriceListInterface
     */
    public function setStart(\DateTimeInterface $start) : PriceListInterface
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd() : \DateTimeInterface
    {
        return $this->end;
    }

    /**
     * @param \DateTimeInterface $end
     *
     * @return PriceListInterface
     */
    public function setEnd(\DateTimeInterface $end) : PriceListInterface
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @param PriceInterface $price
     *
     * @return PriceListInterface
     */
    public function addPrice(PriceInterface $price) : PriceListInterface
    {
        $this->prices->add($price);

        return $this;
    }

    /**
     * @param PriceInterface $price
     *
     * @return PriceListInterface
     */
    public function removePrice(PriceInterface $price) : PriceListInterface
    {
        $this->prices->removeElement($price);

        return $this;
    }

    /**
     * @param array $prices
     *
     * @return PriceListInterface
     */
    public function setPrices(array $prices) : PriceListInterface
    {
        $this->prices = new ArrayCollection($prices);

        return $this;
    }

    /**
     * @return array
     */
    public function getPrices() : array
    {
        return $this->prices->toArray();
    }

    /**
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param ProductInterface $product
     *
     * @return PriceListInterface
     */
    public function setProduct(ProductInterface $product) : PriceListInterface
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return CustomerSegmentInterface
     */
    public function getCustomerSegment() : CustomerSegmentInterface
    {
        return $this->customerSegment;
    }

    /**
     * @param CustomerSegmentInterface $customerSegment
     *
     * @return PriceListInterface
     */
    public function setCustomerSegment(CustomerSegmentInterface $customerSegment) : PriceListInterface
    {
        $this->customerSegment = $customerSegment;

        return $this;
    }
}
