<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Pricing\Model\CustomerSegmentInterface;
use Kiboko\Component\Pricing\Model\CustomerSegmentSubjectInterface;
use Kiboko\Component\Pricing\Model\PriceListInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CustomerSegment
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_customer_segment")
 */
class CustomerSegment implements CustomerSegmentInterface, IdentifiableInterface, NamedInterface
{
    /**
     * @var int
     *
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
     * @var Collection|PriceListInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingBundle\Entity\PriceList", mappedBy="customerSegment")
     */
    private $priceLists;

    /**
     * @var CustomerSegmentSubjectInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\PricingBundle\Entity\CustomerSegment")
     */
    private $subject;

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
     * @return CustomerSegmentInterface
     */
    public function setId($id) : CustomerSegmentInterface
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
     * @return CustomerSegmentInterface
     */
    public function setName(string $name) : CustomerSegmentInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return PriceListInterface[]
     */
    public function getPriceLists() : array
    {
        return $this->priceLists->toArray();
    }

    /**
     * @param PriceListInterface $priceList
     *
     * @return CustomerSegmentInterface
     */
    public function addPriceList(PriceListInterface $priceList) : CustomerSegmentInterface
    {
        $this->priceLists->add($priceList);

        return $this;
    }

    /**
     * @param PriceListInterface $priceList
     *
     * @return CustomerSegmentInterface
     */
    public function removePriceList(PriceListInterface $priceList) : CustomerSegmentInterface
    {
        $this->priceLists->removeElement($priceList);

        return $this;
    }

    /**
     * @param PriceListInterface[] $priceLists
     *
     * @return CustomerSegmentInterface
     */
    public function setPriceLists(array $priceLists) : CustomerSegmentInterface
    {
        $this->priceLists = new ArrayCollection($priceLists);

        return $this;
    }

    /**
     * @return CustomerSegmentSubjectInterface
     */
    public function getSubject() : CustomerSegmentSubjectInterface
    {
        return $this->subject;
    }

    /**
     * @param CustomerSegmentSubjectInterface $subject
     *
     * @return CustomerSegmentInterface
     */
    public function setSubject(CustomerSegmentSubjectInterface $subject) : CustomerSegmentInterface
    {
        $this->subject = $subject;
    }
}
