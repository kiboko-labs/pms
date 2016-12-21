<?php

namespace spec\Kiboko\Bundle\PricingBundle\Entity;

use Kiboko\Bundle\PricingBundle\Model\CustomerSegmentInterface;
use Kiboko\Bundle\PricingBundle\Model\IdentifiableInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomerSegmentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement(IdentifiableInterface::class);
        $this->shouldImplement(CustomerSegmentInterface::class);
    }
}
