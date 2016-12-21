<?php

namespace spec\Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement(IdentifiableInterface::class);
        $this->shouldImplement(PriceInterface::class);
    }
}
