<?php

namespace Kiboko\Component\Product\Model;

interface ProductAwareInterface
{
    public function getProduct() : ProductInterface;
}
