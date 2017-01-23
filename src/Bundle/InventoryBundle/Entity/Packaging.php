<?php

namespace Kiboko\Bundle\InventoryBundle\Entity;

use Brick\Math\BigNumber;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\DataModel\Model\IdentifiableByCodeInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @package Kiboko\Bundle\InventoryBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_inventory_packaging", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UNQ_CODE", columns={"code"})
 * })
 */
class Packaging implements NamedInterface, IdentifiableInterface, IdentifiableByCodeInterface
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
     * @ORM\Column(name="code", type="string")
     */
    private $code;

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return IdentifiableInterface
     */
    public function setId(int $id) : IdentifiableInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName() : string
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
     * @return mixed
     */
    public function getCode() : string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return IdentifiableByCodeInterface
     */
    public function setCode(string $code) : IdentifiableByCodeInterface
    {
        $this->code = $code;

        return $this;
    }
}
