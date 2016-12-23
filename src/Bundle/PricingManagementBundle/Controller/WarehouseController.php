<?php

namespace Kiboko\Bundle\PricingManagementBundle\Controller;

use Kiboko\Component\Inventory\Model\WarehouseInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/warehouse")
 */
class WarehouseController extends Controller
{
    /**
     * @param WarehouseInterface $warehouse
     *
     * @return array
     *
     * @Route("/{id}", name="kiboko_pms_pricing_warehouse", requirements={"warehouseId": "\d+"})
     * @ParamConverter("warehouse", class="KibokoPricingManagementBundle:Warehouse")
     * @Template()
     */
    public function indexAction(WarehouseInterface $warehouse)
    {
        return [
            'warehouse' => $warehouse
        ];
    }
}
