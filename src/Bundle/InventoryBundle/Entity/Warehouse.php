<?php

namespace Kiboko\Bundle\InventoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Inventory\Model\InventoryUnitInterface;
use Kiboko\Component\Inventory\Model\WarehouseAwareInterface;
use Kiboko\Component\Inventory\Model\WarehouseInterface;
use Oro\Bundle\LocaleBundle\Model\AddressInterface;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnitInterface;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @package Kiboko\Bundle\InventoryBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_inventory_warehouse")
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
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\InventoryBundle\Entity\WarehouseInventoryUnit", mappedBy="warehouse")
     */
    private $inventoryUnits;

    /**
     * @var WarehouseAddress
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\InventoryBundle\Entity\WarehouseAddress", mappedBy="warehouse")
     */
    private $address;

    /**
     * @var OrganizationInterface
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     */
    private $organization;

    /**
     * @var BusinessUnitInterface
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\BusinessUnit")
     */
    private $businessUnit;

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

    /**
     * @return WarehouseAddress
     */
    public function getAddress(): WarehouseAddress
    {
        return $this->address;
    }

    /**
     * @param WarehouseAddress $address
     *
     * @return WarehouseInterface
     */
    public function setAddress(WarehouseAddress $address) : WarehouseInterface
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return OrganizationInterface
     */
    public function getOrganization() : OrganizationInterface
    {
        return $this->organization;
    }

    /**
     * @param OrganizationInterface $organization
     *
     * @return WarehouseInterface
     */
    public function setOrganization(OrganizationInterface $organization) : WarehouseInterface
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return BusinessUnitInterface
     */
    public function getBusinessUnit() : BusinessUnitInterface
    {
        return $this->businessUnit;
    }

    /**
     * @param BusinessUnitInterface $businessUnit
     *
     * @return WarehouseInterface
     */
    public function setBusinessUnit(BusinessUnitInterface $businessUnit) : WarehouseInterface
    {
        $this->businessUnit = $businessUnit;

        return $this;
    }

    /**
     * @return OrganizationInterface|BusinessUnitInterface|null $owner
     */
    public function getOwner()
    {
        if (null !== $this->businessUnit) {
            return $this->businessUnit;
        }

        if (null !== $this->organization) {
            return $this->organization;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getOwnerName()
    {
        if (($owner = $this->getOwner()) !== null) {
            return $owner->getName();
        }

        return null;
    }
}
