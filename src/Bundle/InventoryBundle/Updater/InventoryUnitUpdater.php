<?php

namespace Kiboko\Bundle\InventoryBundle\Updater;

use Brick\Math\BigNumber;
use Kiboko\Bundle\PricingBundle\Entity\PriceHistory;
use Kiboko\Component\Pricing\Model\Mutable\MutablePriceInterface;
use Kiboko\Component\Pricing\Model\PriceHistoryInterface;

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
