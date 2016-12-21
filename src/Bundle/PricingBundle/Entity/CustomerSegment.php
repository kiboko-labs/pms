<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Kiboko\Bundle\PricingBundle\Model\CustomerSegmentInterface;
use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceListInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CustomerSegment
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_customer_segment")
 */
class CustomerSegment implements CustomerSegmentInterface, IdentifiableInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Collection|PriceListInterface[]
     *
     * @ORM\OneToMany(targetEntity="Kiboko\Bundle\PricingBundle\Entity\PriceList", mappedBy="customerSegment")
     */
    private $priceLists;

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
     * @return CustomerSegmentInterface
     */
    public function setId($id) : CustomerSegmentInterface
    {
        $this->id = $id;

        return $this;
    }
}
