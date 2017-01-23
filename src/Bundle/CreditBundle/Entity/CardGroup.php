<?php

namespace Kiboko\Bundle\CreditBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\Credit\Model\CardGroupInterface;
use Kiboko\Component\Credit\Model\CardInterface;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Pricing\Model\CustomerSegmentInterface;
use Kiboko\Component\Pricing\Model\CustomerSegmentSubjectInterface;
use Kiboko\Component\Pricing\Model\PriceListInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CardGroup
 *
 * @package Kiboko\Bundle\GiftCardBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_credit_card_group")
 */
class CardGroup implements CardGroupInterface, IdentifiableInterface
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
     * @var Collection|CardInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\CreditBundle\Entity\Card", mappedBy="group")
     */
    private $cards;

    /**
     * @var Collection|PriceListInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingBundle\Entity\PriceList", mappedBy="customerSegment")
     */
    private $priceLists;

    /**
     * @var CustomerSegmentInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\PricingBundle\Entity\CustomerSegment", inversedBy="priceList")
     * @ORM\JoinColumn(name="segment_id", referencedColumnName="id")
     */
    private $customerSegment;

    /**
     * CardGroup constructor.
     */
    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->priceLists = new ArrayCollection();
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
     * @return CardGroup
     */
    public function setId($id) : CardGroup
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return NamedInterface
     */
    public function setName(string $name) : NamedInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCards() : Collection
    {
        return $this->cards;
    }

    /**
     * @param CardInterface $card
     *
     * @return CardGroupInterface
     */
    public function addCard(CardInterface $card) : CardGroupInterface
    {
        $this->cards->add($card);

        return $this;
    }

    /**
     * @param CardInterface $card
     *
     * @return CardGroupInterface
     */
    public function removeCard(CardInterface $card) : CardGroupInterface
    {
        $this->cards->removeElement($card);

        return $this;
    }

    /**
     * @param Collection $cards
     *
     * @return CardGroupInterface
     */
    public function setCards(Collection $cards) : CardGroupInterface
    {
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
     * @return CustomerSegmentSubjectInterface
     */
    public function setCustomerSegment(CustomerSegmentInterface $customerSegment) : CustomerSegmentSubjectInterface
    {
        $this->customerSegment = $customerSegment;

        return $this;
    }
}
