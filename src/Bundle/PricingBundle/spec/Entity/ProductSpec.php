<?php

namespace spec\Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use Kiboko\Bundle\PricingBundle\Model\ProductInterface;
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
