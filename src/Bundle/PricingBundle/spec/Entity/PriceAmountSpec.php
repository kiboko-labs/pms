<?php

namespace spec\Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceAmountInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriceAmountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement(IdentifiableInterface::class);
        $this->shouldImplement(PriceAmountInterface::class);
    }
}
