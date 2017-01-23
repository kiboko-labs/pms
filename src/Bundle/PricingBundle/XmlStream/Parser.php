<?php

namespace Kiboko\Bundle\PricingBundle\XmlStream;

class Parser
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @var resource
     */
    private $parser;

    /**
     * @var int
     */
    private $blockSize;

    /**
     * @var \SplQueue
     */
    private $tokenQueue;

    /**
     * Parser constructor.
     *
     * @param resource $stream
     * @param int $blockSize
     */
    public function __construct($stream, $blockSize = 4096)
    {
        $this->stream = $stream;
        $this->blockSize = $blockSize;

        $this->parser = xml_parser_create('UTF-8');
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'startTag', 'endTag');
        xml_set_character_data_handler($this->parser, "stringTag");

        $this->tokenQueue = new \SplQueue();
        $this->tokenQueue->setIteratorMode(\SplQueue::IT_MODE_FIFO | \SplQueue::IT_MODE_DELETE);
    }

    public function parse()
    {
        if (!is_resource($this->stream)) {
            throw new \RuntimeException('No stream was provided.');
        }

        while (!feof($this->stream)) {
            if (!xml_parse($this->parser, fread($this->stream, 4096), feof($this->stream))) {
                $errorMessage = xml_error_string(xml_get_error_code($this->parser));
                $currentLine = xml_get_current_line_number($this->parser);
                $currentColumn = xml_get_current_column_number($this->parser);

                xml_parser_free($this->parser);

                throw new \RuntimeException(sprintf(
                    'XML parsing failed on %d:%d: %s.',
                    $currentLine,
                    $currentColumn,
                    $errorMessage
                ));
            }

            foreach ($this->tokenQueue as $token) {
                yield $token;
            }
        }

        xml_parser_free($this->parser);
    }

    public function startTag($parser, $name, $attributes)
    {
        $this->tokenQueue->enqueue(new XMLOpenToken($name));

        foreach ($attributes as $attributeName => $attributeValue) {
            $this->tokenQueue->enqueue(new XMLAttributeToken($attributeName, $attributeValue));
        }
    }

    public function endTag($parser, $name)
    {
        $this->tokenQueue->enqueue(new XMLCloseToken($name));
    }

    public function stringTag($parser, $value)
    {
        $value = trim($value);
        if (empty($value)) {
            return;
        }
        $this->tokenQueue->enqueue(new XMLTextToken($value));
    }
}
