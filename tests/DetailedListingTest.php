<?php

/**
 * Read and parse example apartment values from XML.
 *
 * @noinspection PhpIncludeInspection
 */

require_once 'Helmikohteet/ListingDetails/Listing.php';
require_once 'Helmikohteet/ListingsList/ApartmentType.php';

use Helmikohteet\ListingDetails\Listing;
use PHPUnit\Framework\TestCase;

/**
 * Tests parsing a detailed listing with example values for properties.
 */
class DetailedListingTest extends TestCase
{
    /**
     * Reads an XML file into an Apartments data structure.
     *
     * @return SimpleXMLElement
     */
    function testReadFile(): SimpleXMLElement
    {
        $fixture = __DIR__ . '/fixtures/Apartments.xml';
        $xml     = simplexml_load_file($fixture);

        $this->assertInstanceOf(SimpleXMLElement::class, $xml);

        return $xml;
    }

    /**
     * Reads the first apartment contents.
     *
     * @depends testReadFile
     *
     * @param SimpleXMLElement $apartments
     *
     * @return SimpleXMLElement
     */
    function testReadFirstApartment(SimpleXMLElement $apartments): SimpleXMLElement
    {
        $apartmentXml = $apartments->Apartment[0];

        $this->assertInstanceOf(SimpleXMLElement::class, $apartmentXml);

        return $apartmentXml;
    }

    /**
     * Checks parsing all the apartment properties.
     *
     * @depends  testReadFirstApartment
     *
     * @param SimpleXMLElement $apartment
     */
    function testCreateListing(SimpleXMLElement $apartment)
    {
        $ls = new Listing($apartment);

        $this->assertEquals('12345', $ls->id);
        $this->assertStringStartsWith('Tilava', $ls->description);
        $this->assertEquals('Kerrostalo', $ls->apartmentType);
        $this->assertEquals('OSAKE', $ls->realEstateType);
        $this->assertEquals('Sopimuksen mukaan', $ls->becomesAvailable);
        $this->assertEquals(65_000.00, $ls->salesPrice);
        $this->assertEquals(65_000.00, $ls->unencumberedSalesPrice);
        $this->assertEquals(0, $ls->debtPart);
        $this->assertEquals('Katuosoite 1', $ls->streetAddress);
        $this->assertEquals('A 3', $ls->flatNumber);
        $this->assertEquals('26100', $ls->postalCode);
        $this->assertEquals('Lajo', $ls->region);
        $this->assertEquals('Rauma', $ls->city);
        $this->assertEquals('Satakunta', $ls->pdxRegion);
        $this->assertEquals('123-123-4-123', $ls->realEstateId);
        $this->assertEquals(3_450.50, $ls->siteArea);
        $this->assertEquals('V', $ls->siteCode);
        $this->assertEquals('Rauman kaupunki', $ls->leaseHolder);
        $this->assertEquals('0,00 € / v', $ls->siteRent);
        $this->assertEquals('31.03.2035', $ls->siteRentContractEndDate);
        $this->assertEquals('Asemakaava', $ls->buildingPlanSituation);
        $this->assertEquals(318.00, $ls->buildingRights);
        $this->assertEquals('Heikkilä', $ls->estateNameAndNumber);
        $this->assertStringStartsWith('Pohjoisranta', $ls->propertyAdditionalInfo);
        $this->assertStringStartsWith('Vesi-', $ls->municipalDevelopment);
        $this->assertEquals('', $ls->shore); // TODO
        $this->assertEquals('Meri', $ls->shoreDescription);

        $this->assertEquals('1981', $ls->yearOfBuilding);
        $this->assertEquals('Betonielementti', $ls->buildingMaterial);
        $this->assertEquals('Kiinteistöt Oy', $ls->realEstateManagement);
        $this->assertEquals('Harja, huopa', $ls->roofType);
        $this->assertEquals('2h+k', $ls->roomTypes);
        $this->assertEquals('Kaukolämpö', $ls->heating);
        $this->assertEquals('Painovoimainen', $ls->ventilationSystem);
        $this->assertEquals(58.50, $ls->livingArea);
        $this->assertEquals(275.00, $ls->totalArea);
        $this->assertEquals('varasto', $ls->totalAreaDescription);
        $this->assertEquals('3', $ls->generalConditionLevel);
        $this->assertEquals('Hyvä', $ls->generalCondition);
        $this->assertEquals('Energialuokka: F', $ls->energyClass);
        $this->assertStringStartsWith('Ostaja on', $ls->supplementaryInformation);
        $this->assertStringStartsWith('TALOYHTIÖ:', $ls->basicRenovations);
        $this->assertStringStartsWith('Elementtien kunnostus', $ls->futureRenovations);
        $this->assertEquals('1', $ls->floorLocation);
        $this->assertEquals('Kyllä', $ls->balcony);
        $this->assertEquals('Lasitettu parveke', $ls->balconyDescription);
        $this->assertEquals('Ei', $ls->asbestosMapping);

        $this->assertStringStartsWith('jääkaappi', $ls->kitchenAppliances);
        $this->assertEquals('maalattu', $ls->kitchenWall);
        $this->assertEquals('laminaatti', $ls->kitchenFloor);
        $this->assertEquals('Kaksi makuuhuonetta', $ls->bedroomAppliances);
        $this->assertEquals('tapetti', $ls->bedroomWall);
        $this->assertEquals('parketti', $ls->bedroomFloor);
        $this->assertEquals('Valoisa tilava olohuone', $ls->livingRoomAppliances);
        $this->assertEquals('laminaatti', $ls->livingRoomFloor);
        $this->assertEquals('tapetti', $ls->livingRoomWall);
        $this->assertStringStartsWith('suihku', $ls->bathroomAppliances);
        $this->assertEquals('laatta', $ls->bathroomWall);
        $this->assertEquals('laatta', $ls->bathroomFloor);
        $this->assertStringStartsWith('Keittiö', $ls->floor);
        $this->assertEquals('kaksi saunaa', $ls->sauna);
        $this->assertEquals('Vaatehuone, kaapistot', $ls->storageSpace);
        $this->assertEquals('Autokatos', $ls->parkingSpace);

        $this->assertEquals('Linja-autoasema 0,3 km', $ls->connections);
        $this->assertEquals('Kauppa lähellä', $ls->services);

        $this->assertEquals('234.56', $ls->housingCompanyFee);
        $this->assertEquals('10.00', $ls->financingFee);
        $this->assertEquals('234.56', $ls->maintenanceFee);
        $this->assertEquals('17.00', $ls->waterFee);
        $this->assertEquals('Hyvää vettä on', $ls->waterFeeExplanation);
        $this->assertEquals('1480€/vuosi', $ls->electricityConsumption);
        $this->assertEquals('186.00 EUR/v', $ls->estateTax);
        $this->assertEquals('Taloussähkö', $ls->otherFees);
        $this->assertEquals('61.1340271463', $ls->latitude);
        $this->assertEquals('22.160233', $ls->longitude);

        $this->assertEquals('Erkki Edustaja', $ls->agentName);
        $this->assertEquals('erkki.edustaja@example.com', $ls->agentEmail);
        $this->assertEquals('040 123 4567', $ls->agentPhone);
        $this->assertEquals('https://example.com/upload/valittajat/123erkki.jpg', $ls->agentPictureUrl);

        $this->assertStringStartsWith('Tulethan', $ls->showingExplanation);
        $this->assertEquals('15.05.2021', $ls->showingDate);
        $this->assertEquals('12:00', $ls->showingStartTime);
        $this->assertEquals('12:30', $ls->showingEndTime);

        $this->assertCount(5, $ls->pictureUrls, 'Should have added all the pictures');
        foreach ($ls->pictureUrls as $url) {
            $this->assertStringStartsWith('https', $url);
        }
    }
}
