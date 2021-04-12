<?php

require_once 'Helmikohteet/ListingDetails/Finder.php';

use Helmikohteet\ListingDetails\Finder;
use PHPUnit\Framework\TestCase;

/**
 * Tests finding a listing from a list based on a key value.
 */
class FinderTest extends TestCase
{
    private const XML = <<<EOF
        <Apartments>
            <Apartment>
                <Key>foo</Key>
                <Name>Not this</Name>
            </Apartment>
            <Apartment>
                <Key>bar</Key>
                <Name>Choose this</Name>
            </Apartment>
        </Apartments>
        EOF;

    /**
     * Returns the listing with matching key.
     */
    function testFindListing()
    {
        $finder = new Finder(simplexml_load_string(self::XML));
        $result = $finder->getListingData('bar');

        $this->assertInstanceOf(SimpleXMLElement::class, $result);
        $this->assertEquals('Choose this', $result->Name);
    }

    /**
     * Returns null when match for given key not found.
     */
    function testListingNotFound()
    {
        $finder = new Finder(simplexml_load_string(self::XML));

        $this->assertNull($finder->getListingData('baz'), 'Should not match key baz.foo');
    }
}
