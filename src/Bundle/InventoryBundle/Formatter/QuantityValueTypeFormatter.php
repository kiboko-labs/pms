<?php

namespace Kiboko\Bundle\InventoryBundle\Formatter;

use Brick\Math\BigNumber as BrickBigNumber;
use Brick\Math\RoundingMode as BrickRoundingMode;
use Oro\Bundle\ImportExportBundle\Formatter\TypeFormatterInterface;

class QuantityValueTypeFormatter implements TypeFormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function formatType($value, $type)
    {
        return $this->format($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function format($value)
    {
        if ($value instanceof BrickBigNumber) {
            return (string) $value->toScale(0, BrickRoundingMode::HALF_DOWN);
        }

        return (string) $value;
    }
}
