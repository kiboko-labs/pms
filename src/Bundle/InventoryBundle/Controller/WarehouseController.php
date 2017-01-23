<?php

namespace Kiboko\Bundle\InventoryBundle\Controller;

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
     * @return array
     *
     * @Route("/", name="kiboko_mms_inventory_warehouse_index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @param WarehouseInterface $warehouse
     *
     * @return array
     *
     * @Route("/{id}", name="kiboko_mms_inventory_warehouse_view", requirements={"id": "\d+"})
     * @ParamConverter("warehouse", class="KibokoInventoryBundle:Warehouse")
     * @Template()
     */
    public function viewAction(WarehouseInterface $warehouse)
    {
        return [
            'warehouse' => $warehouse
        ];
    }
}
