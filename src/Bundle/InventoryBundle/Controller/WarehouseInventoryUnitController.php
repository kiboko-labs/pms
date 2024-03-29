<?php

namespace Kiboko\Bundle\InventoryBundle\Controller;

use Kiboko\Component\Product\Model\ProductInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/warehouse-inventory-unit")
 */
class WarehouseInventoryUnitController extends Controller
{
    /**
     * @param ProductInterface $product
     *
     * @return array
     *
     * @Route("/{id}", name="kiboko_mms_pricing_warehouse_inventory_unit", requirements={"productId": "\d+"})
     * @ParamConverter("product", class="KibokoCatalogBundle:Product")
     * @Template()
     */
    public function indexAction(ProductInterface $product)
    {
        return [
            'product' => $product
        ];
    }
}
