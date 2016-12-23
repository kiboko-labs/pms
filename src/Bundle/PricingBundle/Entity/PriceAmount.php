<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Brick\Math\BigNumber;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Pricing\Model\Mutable\MutablePriceAmountInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PriceAmount
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\MappedSuperclass
 */
class PriceAmount implements MutablePriceAmountInterface, IdentifiableInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="amount", type="big_number", scale=8, precision=24)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_code", type="string")
     */
    private $currencyCode;

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
     * @return MutablePriceAmountInterface
     */
    public function setId($id) : MutablePriceAmountInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return BigNumber
     */
    public function getAmount() : BigNumber
    {
        return $this->amount;
    }

    /**
     * @param BigNumber $amount
     *
     * @return MutablePriceAmountInterface
     */
    public function setAmount(BigNumber $amount) : MutablePriceAmountInterface
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode() : string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     *
     * @return MutablePriceAmountInterface
     */
    public function setCurrencyCode(string $currencyCode) : MutablePriceAmountInterface
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }
}
