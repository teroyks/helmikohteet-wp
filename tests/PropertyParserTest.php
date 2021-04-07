<?php

require_once('Helmikohteet/Utilities/PropertyParser.php');

use Helmikohteet\Utilities\PropertyParser;
use PHPUnit\Framework\TestCase;

/**
 * Tests parsing a property from a multi-dimensional array.
 */
class PropertyParserTest extends TestCase
{
    /**
     * @var PropertyParser
     */
    private PropertyParser $parser;

    private const TEST_DATA = [
        'foo'   => 'Foo',
        'bar'   => 'Bar',
        'baz'   => [
            'key' => 'Baz',
        ],
        'multi' => [
            'first' => [
                'second' => 'value',
            ],
        ],
    ];

    /**
     * @before
     */
    function instantiateParser()
    {
        $this->parser = new PropertyParser();
    }

    function testPropertyNotFound()
    {
        $this->assertEmpty(
            $this->parser->parseProperty('str', []),
            'Should handle string prop not found.'
        );
        $this->assertEmpty(
            $this->parser->parseProperty(['foo', 'bar'], []),
            'Should handle array prop not found.'
        );
        $this->assertEmpty(
            $this->parser->parseProperty(
                ['multi', 'second'],
                self::TEST_DATA
            ),
            'Should be ok with sublevel not found.'
        );
    }

    function testStringProperty()
    {
        $this->assertEquals(
            'Bar',
            $this->parser->parseProperty('bar', self::TEST_DATA),
            'Should parse string property value.'
        );
    }

    function testArrayProperty()
    {
        $this->assertEquals(
            'Baz',
            $this->parser->parseProperty(
                ['baz', 'key'],
                self::TEST_DATA
            ),
            'Should parse array property value.'
        );
    }

    function testComplexArrayProperty()
    {
        $this->assertEquals(
            'value',
            $this->parser->parseProperty(
                ['multi', 'first', 'second'],
                self::TEST_DATA
            ),
            'Should find value several levels down.'
        );
    }
}
