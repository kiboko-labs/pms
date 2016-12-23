<?php

namespace Kiboko\Bundle\PricingManagementBundle\Controller;

use Kiboko\Component\Pricing\Model\CustomerSegmentInterface;
use Kiboko\Component\Product\Model\ProductInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/price-history")
 */
class PriceHistoryController extends Controller
{
    /**
     * @param ProductInterface $product
     *
     * @return array
     *
     * @Route("/{productId}",
     *     name="kiboko_pms_pricing_price_history",
     *     requirements={"productId": "\d+"}
     * )
     * @ParamConverter("product", class="KibokoPricingManagementBundle:Product", options={"mapping": {"productId": "id"}})
     * @Template()
     */
    public function indexAction(ProductInterface $product)
    {
        return [
            'product' => $product
        ];
    }

    /**
     * @param ProductInterface $product
     * @param CustomerSegmentInterface $customerSegment
     *
     * @return array
     *
     * @Route("/{productId}/{customerSegmentId}",
     *     name="kiboko_pms_pricing_customer_segment_price_history",
     *     requirements={"productId": "\d+", "customerSegmentId": "\d+"}
     * )
     * @ParamConverter("product", class="KibokoPricingManagementBundle:Product", options={"mapping": {"productId": "id"}})
     * @ParamConverter("customerSegment", class="KibokoPricingManagementBundle:CustomerSegment", options={"mapping": {"customerSegmentId": "id"}})
     * @Template()
     */
    public function segmentAction(ProductInterface $product, CustomerSegmentInterface $customerSegment = null)
    {
        return [
            'product' => $product,
            'customerSegment' => $customerSegment
        ];
    }
}
