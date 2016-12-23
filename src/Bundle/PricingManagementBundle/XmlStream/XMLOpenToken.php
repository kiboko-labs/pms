<?php

namespace Kiboko\Bundle\PricingManagementBundle\XmlStream;

class XMLOpenToken implements NamedXMLTokenInterface
{
    use NamedXMLTokenTrait;

    /**
     * XMLOpenToken constructor.
     *
     * @param $name
     */
    public function __construct(string $name)
    {
        $this->name = strtolower($name);
    }
}