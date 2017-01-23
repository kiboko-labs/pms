<?php

namespace spec\Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Pricing\Model\PriceInterface;
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
