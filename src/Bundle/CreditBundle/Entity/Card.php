<?php

namespace Kiboko\Bundle\CreditBundle\Entity;

use Kiboko\Component\Credit\Model\CardInterface;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnitInterface;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationInterface;

/**
 * Class Card
 *
 * @package Kiboko\Bundle\GiftCardBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_credit_card")
 */
class Card implements CardInterface, IdentifiableInterface
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
     * @ORM\Column(name="code", type="string")
     */
    private $code;

    /**
     * @var CardGroup
     *
     * @ORM\ManyToOne(targetEntity="Kiboko\Bundle\CreditBundle\Entity\CardGroup", inversedBy="cards")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    /**
     * @var OrganizationInterface
     *
     * @ORM\OneToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     */
    private $organization;

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
     * @return Card
     */
    public function setId($id) : Card
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return OrganizationInterface
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param OrganizationInterface $organization
     *
     * @return CardInterface
     */
    public function setOrganization(OrganizationInterface $organization) : CardInterface
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return OrganizationInterface|BusinessUnitInterface|null $owner
     */
    public function getOwner()
    {
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
