<?php

namespace Kiboko\Component\Product\Model;

interface IdentifiableBySkuInterface
{
    public function getSku() : string;
}
