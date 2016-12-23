<?php

namespace spec\Kiboko\Bundle\PricingManagementBundle\XmlStream;

use Kiboko\Bundle\PricingManagementBundle\XmlStream\Parser;
use Kiboko\Bundle\PricingManagementBundle\XmlStream\XMLAttributeToken;
use Kiboko\Bundle\PricingManagementBundle\XmlStream\XMLCloseToken;
use Kiboko\Bundle\PricingManagementBundle\XmlStream\XMLOpenToken;
use Kiboko\Bundle\PricingManagementBundle\XmlStream\XMLTextToken;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Matcher\Iterate\SubjectHasMoreElementsException;
use PhpSpec\Matcher\Iterate\SubjectHasFewerElementsException;

class ParserSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        $isIterable = function ($variable) {
            return is_array($variable) || $variable instanceof \Traversable;
        };

        $createIteratorFromIterable = function ($iterable) {
            if (is_array($iterable)) {
                return new \ArrayIterator($iterable);
            }
            $iterator = new \IteratorIterator($iterable);
            $iterator->rewind();
            return $iterator;
        };

        return [
            'iterateLike' => function ($subject, $expected) use($isIterable, $createIteratorFromIterable) {
                if (!$isIterable($subject)) {
                    throw new \InvalidArgumentException('Subject value should be an array or implement \Traversable.');
                }
                if (!$isIterable($expected)) {
                    throw new \InvalidArgumentException('Expected value should be an array or implement \Traversable.');
                }
                $expectedIterator = $createIteratorFromIterable($expected);
                $count = 0;
                foreach ($subject as $subjectKey => $subjectValue) {
                    if (!$expectedIterator->valid()) {
                        throw new SubjectHasMoreElementsException();
                    }
                    if ($subjectKey !== $expectedIterator->key() || $subjectValue != $expectedIterator->current()) {
                        throw new \RuntimeException(sprintf('Objects at key %s does not match.', $subjectKey));
                    }
                    $expectedIterator->next();
                    ++$count;
                }
                if ($expectedIterator->valid()) {
                    throw new SubjectHasFewerElementsException();
                }

                return true;
            }
        ];
    }

    function it_is_initializable()
    {
        $this->beConstructedWith(fopen('php://memory', 'w'));
        $this->shouldHaveType(Parser::class);
    }

    function it_can_parse_xml_with_empty_node()
    {
        $xmlData =<<<XML_EOF
<tft_offers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <offers>
        <offer>
            <Parent_ID />
        </offer>
    </offers>
</tft_offers>
XML_EOF;

        $fp = fopen('php://temp', 'w');
        fwrite($fp, $xmlData);
        fseek($fp, 0, SEEK_SET);

        $this->beConstructedWith($fp);
        $this->parse()->shouldIterateLike(new \ArrayIterator([
            new XMLOpenToken('tft_offers'),
                new XMLAttributeToken('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance'),
                new XMLAttributeToken('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema'),
                new XMLOpenToken('offers'),
                    new XMLOpenToken('offer'),
                        new XMLOpenToken('Parent_ID'),
                        new XMLCloseToken('Parent_ID'),
                    new XMLCloseToken('offer'),
                new XMLCloseToken('offers'),
            new XMLCloseToken('tft_offers'),
        ]));
    }

    function it_can_parse_xml_with_text_node()
    {
        $xmlData =<<<XML_EOF
<tft_offers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <offers>
        <offer>
            <Unique_ID>12385T9565</Unique_ID>
        </offer>
        <offer>
            <Unique_ID>12383T9573</Unique_ID>
        </offer>
    </offers>
</tft_offers>
XML_EOF;

        $fp = fopen('php://temp', 'w');
        fwrite($fp, $xmlData);
        fseek($fp, 0, SEEK_SET);

        $this->beConstructedWith($fp);
        $this->parse()->shouldIterateLike(new \ArrayIterator([
            new XMLOpenToken('tft_offers'),
                new XMLAttributeToken('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance'),
                new XMLAttributeToken('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema'),
                new XMLOpenToken('offers'),
                    new XMLOpenToken('offer'),
                        new XMLOpenToken('Unique_ID'),
                            new XMLTextToken('12385T9565'),
                        new XMLCloseToken('Unique_ID'),
                    new XMLCloseToken('offer'),
                    new XMLOpenToken('offer'),
                        new XMLOpenToken('Unique_ID'),
                            new XMLTextToken('12383T9573'),
                        new XMLCloseToken('Unique_ID'),
                    new XMLCloseToken('offer'),
                new XMLCloseToken('offers'),
            new XMLCloseToken('tft_offers'),
        ]));
    }
}
