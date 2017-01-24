<?php

namespace Kiboko\Bundle\PricingBundle\Formatter;

use Brick\Math\BigNumber as BrickBigNumber;
use Brick\Math\RoundingMode as BrickRoundingMode;
use Oro\Bundle\LocaleBundle\Formatter\CurrencyFormatter;

class PriceValueTypeFormatter extends CurrencyFormatter
{
    /**
     * {@inheritdoc}
     */
    public function formatType($value, $type)
    {
        return $this->format($value);
    }

    /**
     * @param $parameter
     * @param array $formatterArguments
     *
     * @return string
     */
    public function format($parameter, array $formatterArguments = [])
    {
        var_dump($formatterArguments);
        if ($parameter instanceof BrickBigNumber) {
            return parent::format(
                (string) $parameter->toScale(0, BrickRoundingMode::HALF_DOWN),
                $formatterArguments
            );
        }

        return parent::format(
            (string) $parameter,
            $formatterArguments
        );
    }
}
