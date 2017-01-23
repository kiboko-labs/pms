<?php

namespace Kiboko\Component\Pricing\Model;

interface CustomerSegmentSubjectInterface
{
    /**
     * @return CustomerSegmentInterface
     */
    public function getCustomerSegment() : CustomerSegmentInterface;

    /**
     * @param CustomerSegmentInterface $customerSegment
     *
     * @return CustomerSegmentSubjectInterface
     */
    public function setCustomerSegment(CustomerSegmentInterface $customerSegment) : CustomerSegmentSubjectInterface;
}
