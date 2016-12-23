<?php

namespace Kiboko\Bundle\PricingBundle\Entity;
use Brick\Math\BigNumber;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Inventory\Model\InventoryUnitInterface;
use Kiboko\Component\Product\Model\ProductInterface;

/**
 * Class BaseInventoryUnit
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\MappedSuperclass
 */
class BaseInventoryUnit implements InventoryUnitInterface, IdentifiableInterface, ProductAwareInterface
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
     * @ORM\Column(name="on_hand", type="big_number", scale=8, precision=24)
     */
    private $onHandAmount;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="reserved", type="big_number", scale=8, precision=24)
     */
    private $reservedAmount;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="incoming", type="big_number", scale=8, precision=24)
     */
    private $incomingAmount;

    /**
     * @var BigNumber
     *
     * @ORM\Column(name="forecasted", type="big_number", scale=8, precision=24)
     */
    private $forecastedAmount;

    /**
     * @var ProductInterface
     */
    private $product;

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
     * @return ProductInterface
     */
    public function getProduct() : ProductInterface
    {
        return $this->product;
    }

    /**
     * @param ProductInterface $product
     *
     * @return BaseInventoryUnit
     */
    public function setProduct(ProductInterface $product) : BaseInventoryUnit
    {
        $this->product = $product;

        return $this;
    }
}
