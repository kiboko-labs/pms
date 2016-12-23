<?php

namespace Kiboko\Bundle\PricingBundle\Connector\Reader;

use Akeneo\Bundle\BatchBundle\Item\InvalidItemException;
use Kiboko\Bundle\PricingBundle\XmlStream\Parser;
use Kiboko\Bundle\PricingBundle\XmlStream\XMLCloseToken;
use Kiboko\Bundle\PricingBundle\XmlStream\XMLOpenToken;
use Oro\Bundle\ImportExportBundle\Context\ContextRegistry;
use Oro\Bundle\ImportExportBundle\Reader\AbstractReader;

class OfferReader extends AbstractReader
{
    /**
     * @var string
     */
    private static $apiRoot = 'http://api.thefrenchtalents.com/tftapi.svc/partner/offer';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var \Iterator
     */
    private $parser;

    /**
     * OfferReader constructor.
     *
     * @param string $apiKey
     */
    public function __construct(ContextRegistry $context, string $apiKey = null)
    {
        $this->apiKey = $apiKey ?: '48003038-9bd3-4fb6-afc6-38a7ee0b60eb';

        parent::__construct($context);
    }

    /**
     * Reads a piece of input data and advance to the next one. Implementations
     * <strong>must</strong> return <code>null</code> at the end of the input
     * data set.
     *
     * @throws InvalidItemException if there is a problem reading the current record
     *                              (but the next one may still be valid)
     * @throws \Exception           if an there is a non-specific error. (step execution will
     *                              be stopped in that case)
     *
     * @return null|mixed
     */
    public function read()
    {
        if ($this->parser === null) {
            //$api = fopen(self::$apiRoot . '?api_key=' . $this->apiKey, 'r');
            $api = fopen('/Users/gplanchat/Kiboko/projects/pms-application/prices.cache', 'r');
            $stream = fopen('php://temp', 'w+');

            stream_copy_to_stream($api, $stream);

            fclose($api);
            fseek($stream, 0, SEEK_SET);
            $this->parser = new Parser($stream);

            foreach ($this->parser as $token) {
                if ($token instanceof XMLOpenToken && $token->getName() === 'offer') {
                    break;
                }
            }
        }

        return $this->consumeOffer();
    }

    private function consumeOffer()
    {
        $item = [];
        while ($this->parser->valid()) {
            $token = $this->parser->current();
            if ($token instanceof XMLCloseToken && $token->getName() === 'offer') {
                break;
            }

            if (!$token instanceof XMLOpenToken) {
                throw new InvalidItemException('Something wrong happened on data parsing.', $item);
            }

            $key = $token->getName();

            $this->parser->next();
            if (!$this->parser->valid()) {
                throw new InvalidItemException('Something wrong happened on data parsing.', $item);
            }

            $value = $token->getName();

            $item[$key] = $value;

            $this->parser->next();
        }

        return $item;
    }
}
