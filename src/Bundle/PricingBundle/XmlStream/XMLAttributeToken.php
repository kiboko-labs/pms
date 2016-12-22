<?php

namespace Kiboko\Bundle\PricingBundle\XmlStream;

class XMLAttributeToken implements NamedXMLTokenInterface, ValuedXMLTokenInterface
{
    use NamedXMLTokenTrait;
    use ValuedXMLTokenTrait;

    /**
     * @var string
     */
    private $value;

    /**
     * XMLOpenToken constructor.
     *
     * @param string $name
     * @param string $name
     */
    public function __construct(string $name, string $value)
    {
        $this->name = strtolower($name);
        $this->value = strtolower($value);
    }
}
