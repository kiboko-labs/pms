<?php

namespace Kiboko\Component\Pricing\Model;

interface CustomerSegmentInterface
{
    /**
     * @return CustomerSegmentSubjectInterface
     */
    public function getSubject() : CustomerSegmentSubjectInterface;

    /**
     * @param CustomerSegmentSubjectInterface $subject
     *
     * @return CustomerSegmentInterface
     */
    public function setSubject(CustomerSegmentSubjectInterface $subject) : CustomerSegmentInterface;
}
