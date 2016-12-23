<?php

namespace Kiboko\Component\DataModel\Model;

interface ActivableInterface
{
    /**
     * @return bool
     */
    public function isActive() : bool;
}
