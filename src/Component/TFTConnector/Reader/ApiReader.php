<?php

namespace Kiboko\Component\TFTConnector\Reader;

use Oro\Bundle\ImportExportBundle\Reader\AbstractReader;

class ApiReader extends AbstractReader
{
    /**
     * @var \Iterator
     */
    private $xmlIterator;

    public function initialize()
    {
        $xml = simplexml_load_file($this->getContext()->getOption('filePath'));

        $this->xmlIterator = new \ArrayIterator(
            $xml->xpath('//tft_offers/offers/offer')
        );

        $this->xmlIterator->rewind();
    }

    public function read()
    {
        $this->xmlIterator->next();
        if (!$this->xmlIterator->valid()) {
            return null;
        }

        $this->stepExecution->incrementReadCount();

        return $this->xmlIterator->current();
    }
}
