<?php

namespace Kiboko\Bundle\PricingManagementBundle\XmlStream;

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
