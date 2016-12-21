<?php

namespace spec\Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Bundle\PricingBundle\Model\ActivableInterface;
use Kiboko\Bundle\PricingBundle\Model\DateIntervalInterface;
use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use Kiboko\Bundle\PricingBundle\Model\NamedInterface;
use Kiboko\Bundle\PricingBundle\Model\PriceListInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriceListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement(IdentifiableInterface::class);
        $this->shouldImplement(NamedInterface::class);
        $this->shouldImplement(ActivableInterface::class);
        $this->shouldImplement(DateIntervalInterface::class);
        $this->shouldImplement(PriceListInterface::class);
    }
}
