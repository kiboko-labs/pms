<?php

namespace Kiboko\Bundle\PricingManagementBundle\XmlStream;

class XMLTextToken implements ValuedXMLTokenInterface
{
    use ValuedXMLTokenTrait;

    /**
     * XMLTextToken constructor.
     *
     * @param string|null $value
     */
    public function __construct(string $value = null)
    {
        if ($value !== null) {
            $this->value = strtolower($value);
        }
    }
}
