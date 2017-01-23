<?php

namespace Kiboko\Bundle\PricingBundle\XmlStream;

class XMLCloseToken implements NamedXMLTokenInterface
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
