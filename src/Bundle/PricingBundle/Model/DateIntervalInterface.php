<?php


namespace Kiboko\Bundle\PricingBundle\Model;

interface DateIntervalInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getStart() : \DateTimeInterface;

    /**
     * @return \DateTimeInterface
     */
    public function getEnd() : \DateTimeInterface;
}
