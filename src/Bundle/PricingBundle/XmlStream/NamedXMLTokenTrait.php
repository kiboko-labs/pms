<?php

namespace Kiboko\Bundle\PricingBundle\XmlStream;

trait NamedXMLTokenTrait
{
    private $name;

    /**
     * @return mixed
     */
    public function getName() :string
    {
        return $this->name;
    }
}
