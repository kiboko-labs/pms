<?php

namespace Kiboko\Bundle\InventoryBundle\Entity;

use Kiboko\Component\Inventory\Model\WarehouseInterface;
use Oro\Bundle\AddressBundle\Model\ExtendAddress;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnitInterface;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class WarehouseAddress
 *
 * @package Kiboko\Bundle\InventoryBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_inventory_warehouse_address")
 */
class WarehouseAddress extends ExtendAddress
{
    /**
     * @var WarehouseInterface
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\InventoryBundle\Entity\Warehouse", inversedBy="addresses")
     * @ORM\JoinColumn(name="warehouse_id", referencedColumnName="id")
     */
    private $warehouse;

    /**
     * @var OrganizationInterface
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     */
    private $ownerOrganization;

    /**
     * @var BusinessUnitInterface
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\BusinessUnit")
     */
    private $ownerBusinessUnit;

    /**
     * @return WarehouseInterface
     */
    public function getWarehouse() : WarehouseInterface
    {
        return $this->warehouse;
    }

    /**
     * @param WarehouseInterface $warehouse
     *
     * @return WarehouseAddress
     */
    public function setWarehouse(WarehouseInterface $warehouse) : WarehouseAddress
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * @return OrganizationInterface
     */
    public function getOwnerOrganization()
    {
        return $this->ownerOrganization;
    }

    /**
     * @param OrganizationInterface $organization
     *
     * @return $this
     */
    public function setOwnerOrganization(OrganizationInterface $organization)
    {
        $this->ownerOrganization = $organization;

        return $this;
    }

    /**
     * @return BusinessUnitInterface
     */
    public function getOwnerBusinessUnit() : BusinessUnitInterface
    {
        return $this->ownerBusinessUnit;
    }

    /**
     * @param BusinessUnitInterface $businessUnit
     *
     * @return WarehouseAddress
     */
    public function setOwnerBusinessUnit(BusinessUnitInterface $businessUnit) : WarehouseAddress
    {
        $this->ownerBusinessUnit = $businessUnit;

        return $this;
    }

    /**
     * @return OrganizationInterface|BusinessUnitInterface|null $owner
     */
    public function getOwner()
    {
        if (null !== $this->ownerBusinessUnit) {
            return $this->ownerBusinessUnit;
        }

        if (null !== $this->ownerOrganization) {
            return $this->ownerOrganization;
        }

        return null;
    }
}
