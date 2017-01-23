<?php

namespace Kiboko\Bundle\InventoryBundle\Entity;

use Brick\Math\BigNumber;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Inventory\Model\InventoryUnitInterface;
use Kiboko\Component\Product\Model\ProductAwareInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseInventoryUnit
 *
 * @package Kiboko\Bundle\InventoryBundle\Entity
 *
 * @ORM\MappedSuperclass
 */
abstract class BaseInventoryUnit implements InventoryUnitInterface, IdentifiableInterface, ProductAwareInterface
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
     * @var BigNumber
     *
     * @ORM\Column(name="on_hand", type="quantity", scale=8, precision=24)
     */
    private $onHandAmount;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="reserved", type="quantity", scale=8, precision=24)
     */
    private $reservedAmount;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="incoming", type="quantity", scale=8, precision=24)
     */
    private $incomingAmount;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="forecasted", type="quantity", scale=8, precision=24)
     */
    private $forecastedAmount;

    /**
     * @var Packaging
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\InventoryBundle\Entity\Packaging")
     * @ORM\JoinColumn(name="packaging_id", referencedColumnName="id")
     */
    private $packaging;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="unit_quantity", type="quantity", scale=8, precision=24)
     */
    private $unitQuantity;

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
     * @return BaseInventoryUnit
     */
    public function setId($id) : BaseInventoryUnit
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param BigNumber $onHandAmount
     *
     * @return BaseInventoryUnit
     */
    public function setOnHandAmount(BigNumber $onHandAmount) : BaseInventoryUnit
    {
        $this->onHandAmount = $onHandAmount;

        return $this;
    }

    /**
     * @return BigNumber
     */
    public function getOnHandAmount() : BigNumber
    {
        return $this->onHandAmount;
    }

    /**
     * @param BigNumber $reservedAmount
     *
     * @return BaseInventoryUnit
     */
    public function setReservedAmount(BigNumber $reservedAmount) : BaseInventoryUnit
    {
        $this->reservedAmount = $reservedAmount;

        return $this;
    }

    /**
     * @return BigNumber
     */
    public function getReservedAmount() : BigNumber
    {
        return $this->reservedAmount;
    }

    /**
     * @param BigNumber $incomingAmount
     *
     * @return BaseInventoryUnit
     */
    public function setIncomingAmount(BigNumber $incomingAmount) : BaseInventoryUnit
    {
        $this->incomingAmount = $incomingAmount;

        return $this;
    }

    /**
     * @return BigNumber
     */
    public function getIncomingAmount() : BigNumber
    {
        return $this->incomingAmount;
    }

    /**
     * @param BigNumber $forecastedAmount
     *
     * @return BaseInventoryUnit
     */
    public function setForecastedAmount(BigNumber $forecastedAmount) : BaseInventoryUnit
    {
        $this->forecastedAmount = $forecastedAmount;

        return $this;
    }

    /**
     * @return BigNumber
     */
    public function getForecastedAmount() : BigNumber
    {
        return $this->forecastedAmount;
    }

    /**
     * @return Packaging
     */
    public function getPackaging() : Packaging
    {
        return $this->packaging;
    }

    /**
     * @param Packaging $packaging
     *
     * @return InventoryUnitInterface
     */
    public function setPackaging(Packaging $packaging) : InventoryUnitInterface
    {
        $this->packaging = $packaging;

        return $this;
    }

    /**
     * @return BigNumber
     */
    public function getUnitQuantity() : BigNumber
    {
        return $this->unitQuantity;
    }

    /**
     * @param BigNumber $unitQuantity
     *
     * @return Packaging
     */
    public function setUnitQuantity(BigNumber $unitQuantity) : Packaging
    {
        $this->unitQuantity = $unitQuantity;

        return $this;
    }
}
