<?php

namespace Kiboko\Component\TFTConnector\Processor;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Oro\Bundle\ImportExportBundle\Converter\DataConverterInterface;

class PricesStocksProcessor implements DataConverterInterface
{
    public function convertToExportFormat(array $exportedRecord, $skipNullValues = true)
    {
        // TODO: Implement convertToExportFormat() method.
    }

    public function convertToImportFormat(array $importedRecord, $skipNullValues = true)
    {
        // TODO: Implement convertToImportFormat() method.
    }

    public function process($item)
    {
        return [
            'sku' => sprintf('TFT%s', $item->Unique_ID),
            'parent' => (string) $item->Parent_ID,
            'price' => (float) (string) $item->Min_Retailing_Price_VAT_excl,
            'discountedPrice' => (float) (string) $item->Discounted_Price,
            'startDate' => \DateTimeImmutable::createFromFormat('d-m-Y H:i:s', (string) $item->Discount_start_date),
            'endDate' => \DateTimeImmutable::createFromFormat('d-m-Y H:i:s', (string) $item->Discount_end_date),
            'stock' => (int) (string) $item->Quantity_in_Stock,
        ];
    }
}
