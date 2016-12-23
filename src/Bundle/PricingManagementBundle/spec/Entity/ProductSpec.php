<?php

namespace spec\Kiboko\Bundle\PricingManagementBundle\Entity;

use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Product\Model\ProductInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement(IdentifiableInterface::class);
        $this->shouldImplement(ProductInterface::class);
    }
}
