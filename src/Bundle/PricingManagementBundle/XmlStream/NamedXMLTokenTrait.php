<?php

namespace Kiboko\Bundle\PricingManagementBundle\XmlStream;

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
