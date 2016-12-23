<?php

namespace Kiboko\Bundle\PricingManagementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Inventory\Model\InventoryUnitAwareInterfae;
use Kiboko\Component\Inventory\Model\InventoryUnitInterface;
use Kiboko\Component\Inventory\Model\WarehouseInventoryUnitInterface;
use Kiboko\Component\Pricing\Model\PriceListInterface;
use Kiboko\Component\Product\Model\IdentifiableBySkuInterface;
use Kiboko\Component\Product\Model\ProductInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @package Kiboko\Bundle\PricingManagementBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_product", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="uniqueSku", columns={"sku"})
 * })
 */
class Product implements
    ProductInterface,
    IdentifiableInterface,
    IdentifiableBySkuInterface,
    NamedInterface,
    InventoryUnitAwareInterfae
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
     * @var string
     *
     * @ORM\Column(name="sku", type="string")
     */
    private $sku;

    /**
     * @var Collection|PriceListInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingManagementBundle\Entity\PriceList", mappedBy="product")
     */
    private $priceLists;

    /**
     * @var InventoryUnitInterface
     *
     * @ORM\OneToOne(targetEntity="Kiboko\Bundle\PricingManagementBundle\Entity\ProductInventoryUnit", mappedBy="product")
     * @ORM\JoinColumn(name="global_inventory_unit_id", referencedColumnName="id")
     */
    private $inventoryUnit;

    /**
     * @var Collection|WarehouseInventoryUnitInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingManagementBundle\Entity\WarehouseInventoryUnit", mappedBy="product")
     */
    private $warehouseInventoryUnits;

    public function __construct()
    {
        $this->priceLists = new ArrayCollection();
        $this->warehouseInventoryUnits = new ArrayCollection();
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
     * @return ProductInterface
     */
    public function setId($id) : ProductInterface
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
     * @return ProductInterface
     */
    public function setName(string $name) : ProductInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     *
     * @return ProductInterface
     */
    public function setSku(string $sku) : ProductInterface
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @param PriceListInterface $priceList
     *
     * @return ProductInterface
     */
    public function addPriceList(PriceListInterface $priceList) : ProductInterface
    {
        $this->priceLists->add($priceList);

        return $this;
    }

    /**
     * @param PriceListInterface $priceList
     *
     * @return ProductInterface
     */
    public function removePriceList(PriceListInterface $priceList) : ProductInterface
    {
        $this->priceLists->removeElement($priceList);

        return $this;
    }

    /**
     * @return Collection|PriceListInterface[]
     */
    public function getPriceLists() : array
    {
        return $this->priceLists->toArray();
    }

    /**
     * @param Collection|PriceListInterface[] $priceLists
     *
     * @return ProductInterface
     */
    public function setPriceLists(array $priceLists) : ProductInterface
    {
        $this->priceLists = $priceLists;

        return $this;
    }

    /**
     * @return InventoryUnitInterface
     */
    public function getInventoryUnit() : InventoryUnitInterface
    {
        return $this->inventoryUnit;
    }

    /**
     * @param InventoryUnitInterface $inventoryUnit
     *
     * @return ProductInterface
     */
    public function setInventoryUnit(InventoryUnitInterface $inventoryUnit) : ProductInterface
    {
        $this->inventoryUnit = $inventoryUnit;

        return $this;
    }

    /**
     * @return PriceListInterface[]
     */
    public function getWarehouseInventoryUnits() : array
    {
        return $this->warehouseInventoryUnits->toArray();
    }

    /**
     * @param WarehouseInventoryUnitInterface $warehouseInventoryUnit
     *
     * @return ProductInterface
     */
    public function addWarehouseInventoryUnit(WarehouseInventoryUnitInterface $warehouseInventoryUnit) : ProductInterface
    {
        $this->warehouseInventoryUnits->add($warehouseInventoryUnit);

        return $this;
    }

    /**
     * @param WarehouseInventoryUnitInterface $warehouseInventoryUnit
     *
     * @return ProductInterface
     */
    public function removeWarehouseInventoryUnit(WarehouseInventoryUnitInterface $warehouseInventoryUnit) : ProductInterface
    {
        $this->warehouseInventoryUnits->removeElement($warehouseInventoryUnit);

        return $this;
    }

    /**
     * @param Collection|PriceListInterface[] $warehouseInventoryUnits
     *
     * @return ProductInterface
     */
    public function setWarehouseInventoryUnits(array $warehouseInventoryUnits) : ProductInterface
    {
        $this->warehouseInventoryUnits = new ArrayCollection($warehouseInventoryUnits);

        return $this;
    }
}
