<?php


namespace Kiboko\Bundle\PricingManagementBundle\XmlStream;

interface ValuedXMLTokenInterface
{
    /**
     * @return string
     */
    public function getValue() : string;
}
