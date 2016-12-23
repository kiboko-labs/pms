<?php

namespace Kiboko\Component\DataModel\Model;

interface DateIntervalInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getStart() : \DateTimeInterface;

    /**
     * @return \DateTimeInterface
     */
    public function getEnd() : \DateTimeInterface;
}
