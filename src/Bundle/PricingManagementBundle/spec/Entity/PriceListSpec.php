<?php

namespace spec\Kiboko\Bundle\PricingManagementBundle\Entity;

use Kiboko\Component\DataModel\Model\ActivableInterface;
use Kiboko\Component\DataModel\Model\DateIntervalInterface;
use Kiboko\Component\DataModel\Model\IdentifiableInterface;
use Kiboko\Component\DataModel\Model\NamedInterface;
use Kiboko\Component\Pricing\Model\PriceListInterface;
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
