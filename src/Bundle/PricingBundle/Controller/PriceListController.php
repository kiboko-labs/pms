<?php

namespace Kiboko\Bundle\PricingBundle\Controller;

use Kiboko\Bundle\PricingBundle\Model\ProductInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/price-list")
 */
class PriceListController extends Controller
{
    /**
     * @param ProductInterface $product
     *
     * @return array
     *
     * @Route("/{id}", name="kiboko_pms_pricing_price_list", requirements={"productId": "\d+"})
     * @ParamConverter("product", class="KibokoPricingBundle:Product")
     * @Template()
     */
    public function indexAction(ProductInterface $product)
    {
        return [
            'product' => $product
        ];
    }
}
