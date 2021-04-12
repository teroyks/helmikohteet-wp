<?php

use PHPUnit\Framework\TestCase;

/**
 * Tests parsing values from an XML Apartments file
 */
class XmlParseTest extends TestCase
{
    /**
     * Reads the XML apartments list from a file.
     *
     * @return SimpleXMLElement Apartments list
     */
    function testReadXml(): SimpleXMLElement
    {
        $file = __DIR__ . '/fixtures/Apartments.xml';

        $xml = simplexml_load_file($file);
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);

        return $xml;
    }

    /**
     * Picks the first apartment from the XML list.
     *
     * @param SimpleXMLElement $xml Apartments list from previous test
     *
     * @depends  testReadXml
     *
     * @return SimpleXMLElement First apartment
     */
    function testReadFirstApartment(SimpleXMLElement $xml): SimpleXMLElement
    {
        $apartmentXml = $xml->Apartment[0];
        $this->assertInstanceOf(SimpleXMLElement::class, $apartmentXml);

        return $apartmentXml;
    }

    /**
     * Parses apartment attribute.
     *
     * @param SimpleXMLElement $a Apartment data
     *
     * @depends testReadFirstApartment
     */
    function testAttribute(SimpleXMLElement $a)
    {
        $this->assertEquals('KT', $a['type'], 'Should parse root attribute.');
    }

    /**
     * Parses content from a tag.
     *
     * @param SimpleXMLElement $a Apartment data
     *
     * @depends testReadFirstApartment
     */
    function testTagContent(SimpleXMLElement $a)
    {
        $this->assertEquals('12345', $a->Key, 'Should parse child content.');
    }

    /**
     * Parses content and attribute value from the same tag.
     *
     * @param SimpleXMLElement $a Apartment data
     *
     * @depends testReadFirstApartment
     */
    function testTagContentAndAttribute(SimpleXMLElement $a)
    {
        $this->assertEquals('Hyvä', $a->GeneralCondition, 'Should parse content of a tag with attribute.');
        $this->assertEquals('3', $a->GeneralCondition['level'], 'Should parse attribute value of a tag with content.');
    }
}
