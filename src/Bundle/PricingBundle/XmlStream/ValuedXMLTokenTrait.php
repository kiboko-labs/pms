<?php

namespace Kiboko\Bundle\PricingBundle\XmlStream;

trait ValuedXMLTokenTrait
{
    private $value;

    /**
     * @return mixed
     */
    public function getValue() : string
    {
        return $this->name;
    }
}
