<?php

namespace Kiboko\Bundle\PricingManagementBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Inventory\Model\InventoryUnitInterface;
use Kiboko\Component\Inventory\Model\WarehouseInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @package Kiboko\Bundle\PricingManagementBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_warehouse")
 */
class Warehouse implements WarehouseInterface, IdentifiableInterface, NamedInterface
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
     * @var Collection|InventoryUnitInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingManagementBundle\Entity\WarehouseInventoryUnit", mappedBy="warehouse")
     */
    private $inventoryUnits;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return WarehouseInterface
     */
    public function setId(int $id) : WarehouseInterface
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
     * @return Warehouse
     */
    public function setName(string $name) : Warehouse
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|InventoryUnitInterface[]
     */
    public function getInventoryUnits() : array
    {
        return $this->inventoryUnits->toArray();
    }

    /**
     * @param InventoryUnitInterface $inventoryUnit
     *
     * @return WarehouseInterface
     */
    public function addInventoryUnit(InventoryUnitInterface $inventoryUnit) : WarehouseInterface
    {
        $this->inventoryUnits->add($inventoryUnit);

        return $this;
    }

    /**
     * @param InventoryUnitInterface $inventoryUnit
     *
     * @return WarehouseInterface
     */
    public function removeInventoryUnit(InventoryUnitInterface $inventoryUnit) : WarehouseInterface
    {
        $this->inventoryUnits->removeElement($inventoryUnit);

        return $this;
    }

    /**
     * @param Collection|InventoryUnitInterface[] $inventoryUnits
     *
     * @return WarehouseInterface
     */
    public function setInventoryUnits(array $inventoryUnits) : WarehouseInterface
    {
        $this->inventoryUnits = new ArrayCollection($inventoryUnits);

        return $this;
    }
}
