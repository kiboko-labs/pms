<?php

namespace spec\Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\Pricing\Model\PriceAmountInterface;
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
