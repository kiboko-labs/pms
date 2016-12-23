<?php

namespace Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Product\Model\ProductAwareInterface;
use Kiboko\Component\Product\Model\ProductInterface;

/**
 * Class ProductInventory
 *
 * @package Kiboko\Bundle\PricingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="kiboko_pricing_product_inventory_unit")
 */
class ProductInventory extends BaseInventoryUnit
{
}
