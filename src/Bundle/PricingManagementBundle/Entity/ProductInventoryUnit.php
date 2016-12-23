<?php

namespace Kiboko\Bundle\PricingManagementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\Inventory\Model\WarehouseInventoryUnitInterface;
use Kiboko\Component\Product\Model\ProductInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductInventory
 *
 * @package Kiboko\Bundle\PricingManagementBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_product_inventory_unit")
 */
class ProductInventoryUnit extends BaseInventoryUnit
{
    /**
     * @var ProductInterface
     *
     * @ORM\OneToOne(targetEntity="Kiboko\Bundle\PricingManagementBundle\Entity\Product", mappedBy="inventoryUnit")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var Collection|WarehouseInventoryUnitInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingManagementBundle\Entity\WarehouseInventoryUnit", mappedBy="productInventoryUnit")
     */
    private $warehouseInventoryUnits;

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

    /**
     * @return Collection|WarehouseInventoryUnitInterface[]
     */
    public function getWarehouseInventoryUnits() : array
    {
        return $this->warehouseInventoryUnits->toArray();
    }

    /**
     * @param WarehouseInventoryUnitInterface $warehouseInventoryUnit
     *
     * @return ProductInventoryUnit
     */
    public function addWarehouseInventoryUnit(WarehouseInventoryUnitInterface $warehouseInventoryUnit) : ProductInventoryUnit
    {
        $this->warehouseInventoryUnits->add($warehouseInventoryUnit);

        return $this;
    }

    /**
     * @param WarehouseInventoryUnitInterface $warehouseInventoryUnit
     *
     * @return ProductInventoryUnit
     */
    public function removeWarehouseInventoryUnit(WarehouseInventoryUnitInterface $warehouseInventoryUnit) : ProductInventoryUnit
    {
        $this->warehouseInventoryUnits->removeElement($warehouseInventoryUnit);

        return $this;
    }

    /**
     * @param Collection|WarehouseInventoryUnitInterface[] $warehouseInventoryUnits
     *
     * @return ProductInventoryUnit
     */
    public function setWarehouseInventoryUnits(array $warehouseInventoryUnits) : ProductInventoryUnit
    {
        $this->warehouseInventoryUnits = new ArrayCollection($warehouseInventoryUnits);

        return $this;
    }
}
