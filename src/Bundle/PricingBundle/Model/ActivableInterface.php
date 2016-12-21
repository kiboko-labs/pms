<?php


namespace Kiboko\Bundle\PricingBundle\Model;

interface ActivableInterface
{
    /**
     * @return bool
     */
    public function isActive() : bool;
}
