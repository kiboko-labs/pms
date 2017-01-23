<?php

namespace Kiboko\Bundle\InventoryBundle\Formatter\Property;

use Kiboko\Bundle\InventoryBundle\Formatter\QuantityValueTypeFormatter;
use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;
use Oro\Bundle\DataGridBundle\Extension\Formatter\Property\AbstractProperty;
use Psr\Log\LoggerInterface;

class QuantityProperty extends AbstractProperty
{
    /**
     * @var QuantityValueTypeFormatter
     */
    protected $formatter;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MoneyValueProperty constructor.
     *
     * @param QuantityValueTypeFormatter $formatter
     * @param LoggerInterface            $logger
     */
    public function __construct(QuantityValueTypeFormatter $formatter, LoggerInterface $logger)
    {
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
     * @return float
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
