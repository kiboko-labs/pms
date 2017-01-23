<?php

namespace Kiboko\Bundle\CatalogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * @Route("/", name="kiboko_mms_catalog_product_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
