<?php

namespace Kiboko\Bundle\PricingManagementBundle\Updater;

use Brick\Math\BigNumber;

class InventoryUnitUpdater
{
    /**
     * @param MutablePriceInterface $price
     * @param BigNumber $value
     * @param string $currency
     * @param \DateTimeInterface|null $date
     *
     * @return PriceHistoryInterface
     */
    public function applyPriceUpdate(
        MutablePriceInterface $price,
        BigNumber $value,
        string $currency = null,
        \DateTimeInterface $date = null
    ) : PriceHistoryInterface {
        if ($date === null) {
            $date = new \DateTimeImmutable();
        }

        $price
            ->setAmount($value)
            ->setCurrencyCode($currency)
        ;

        $history = new PriceHistory();
        $history
            ->setDate($date)
            ->setPrice($price)
            ->setAmount($value)
            ->setCurrencyCode($currency ?: $price->getCurrencyCode())
        ;

        return $history;
    }
}
