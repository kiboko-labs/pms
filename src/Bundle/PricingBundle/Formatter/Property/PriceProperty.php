<?php

namespace Kiboko\Bundle\PricingBundle\Formatter\Property;

use Kiboko\Bundle\PricingBundle\Formatter\PriceValueTypeFormatter;
use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;
use Oro\Bundle\DataGridBundle\Extension\Formatter\Property\AbstractProperty;
use Psr\Log\LoggerInterface;

class PriceProperty extends AbstractProperty
{
    /**
     * @var PriceValueTypeFormatter
     */
    protected $formatter;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MoneyValueProperty constructor.
     *
     * @param PriceValueTypeFormatter $formatter
     * @param LoggerInterface         $logger
     */
    public function __construct(
        PriceValueTypeFormatter $formatter,
        LoggerInterface $logger
    ) {
        $this->formatter = $formatter;
        $this->logger = $logger;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    protected function format($value)
    {
        return $this->formatter->format($value);
    }

    /**
     * @param ResultRecordInterface $record
     *
     * @return string
     */
    protected function getRawValue(ResultRecordInterface $record)
    {
        try {
            $value = $record->getValue($this->get(self::NAME_KEY));
        } catch (\LogicException $e) {
            // default value
            $value = null;
            $this->logger->error(
                'Can\'t get value by name key.',
                ['exception'=> $e]
            );
        }

        return $value;
    }
}
