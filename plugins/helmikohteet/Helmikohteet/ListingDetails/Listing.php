<?php

/**
 * All the details for a listing
 */

namespace Helmikohteet\ListingDetails;

use Helmikohteet\ListingsList\ApartmentType;
use SimpleXMLElement;

/**
 * Apartment listing.
 */
class Listing
{
    public string $id; // kohdenumero
    public string $description; // kuvaus
    public string $apartmentType; // kohdetyyppi
    public string $becomesAvailable; // vapautuminen
    public float  $salesPrice; // myyntihinta
    public string $streetAddress; // osoite
    public string $postalCode; // postinumero
    public string $region; // kaupunginosa
    public string $city; // kaupunki
    public string $pdxRegion; // maakunta
    public string $realEstateId; // kiinteistötunnus
    public float  $siteArea; // tontin pinta-ala
    public string $siteCode; // tontin omistus (koodi)
    public string $siteRentContractEndDate; // tontin vuokrasopimus päättyy
    public string $buildingPlanSituation; // kaavoitustilanne
    public string $buildingPlanInformation; // lisätietoja kaavoituksesta
    public float  $buildingRights; // rakennusoikeus
    public string $estateNameAndNumber; // tilan nimi
    public string $propertyAdditionalInfo; // kiinteistön lisätiedot
    public string $municipalDevelopment; // liittymät
    public string $shore; // ranta
    public string $shoreDescription; // ranta-alueiden kuvaus

    public string $yearOfBuilding; // rakennusvuosi
    public string $buildingMaterial; // rakennusmateriaali
    public string $roofType; // kattotyyppi
    public string $roomTypes; // huonekuvaus
    public string $heating; // lämmitys
    public string $ventilationSystem; // ilmanvaihto
    public float  $livingArea; // pinta-ala
    public float  $totalArea; // kokonaispinta-ala
    public string $totalAreaDescription; // lisätietoja pinta-alasta
    public string $generalConditionLevel; // kunto
    public string $generalCondition; // kunnon lisätiedot
    public string $energyClass; // energialuokka
    public string $supplementaryInformation; // rakennuksen lisätiedot
    public string $basicRenovations; // tehdyt korjaukset
    public string $floorLocation; // kerrosmäärä
    public string $balcony; // parveke
    public string $balconyDescription; // parvekkeen lisätiedot
    public string $asbestosMapping; // asbestikartoitus tehty

    public string $kitchenAppliances; // keittiö
    public string $kitchenWall; // keittiön seinät
    public string $kitchenFloor; // keittiön lattia
    public string $bedroomAppliances; // makuuhuoneet
    public string $bedroomWall; // makuuhuoneiden seinät
    public string $bedroomFloor; // makuuhuoneiden lattiat
    public string $livingRoomAppliances; // olohuone
    public string $livingRoomFloor; // olohuoneen lattia
    public string $livingRoomWall; // olohuoneen seinät
    public string $bathroomAppliances; // kylpyhuone
    public string $bathroomWall; // kylpyhuoneen seinät
    public string $bathroomFloor; // kylpyhuoneen lattia
    public string $floor; // muiden tilojen lattiat
    public string $sauna; // sauna (tyyppi & kuvaus)
    public string $storageSpace; // säilytystilat
    public string $parkingSpace; // auton säilytys

    public string $connections; // liikenneyhteydet
    public string $services; // palvelut

    public string $electricityConsumption; // energiankulutus
    public string $estateTax; // kiinteistövero
    public string $otherFees; // muut maksut
    public string $latitude; // sijainti latitude
    public string $longitude; // sijainti longitude

    public array $pictureUrls = []; // asunnon kuvat

    public function __construct(SimpleXMLElement $data)
    {
        $this->parseData($data);
    }

    /**
     * Parses the apartment properties from the XML data.
     *
     * @param SimpleXMLElement $ap Apartment data
     */
    private function parseData(SimpleXMLElement $ap)
    {
        // parses a string value
        $str = fn($s): string => trim($s);

        // sanitizes a float-like string with unknown decimal separator and possible thousands separator formatting
        $float = fn($str): float => round((float)preg_replace('/[^\d.]/', '', str_replace(',', '.', $str)), 2);

        // assumes the balcony value is valid, either 'K' or 'E'
        $yesOrNo = fn($s): string => 'K' == trim($s) ? 'Kyllä' : 'Ei';


        // removes a '0' as indicator for a missing year value
        $year = fn($d) => $d != 0 ? $d : '';

        $this->id                      = $str($ap->Key);
        $this->description             = $str($ap->Description);
        $this->apartmentType           = ApartmentType::get($ap['type']);
        $this->becomesAvailable        = $str($ap->BecomesAvailable);
        $this->salesPrice              = $float($ap->SalesPrice);
        $this->streetAddress           = $str($ap->StreetAddress);
        $this->postalCode              = $str($ap->PostalCode);
        $this->region                  = $str($ap->Region);
        $this->city                    = $str($ap->City);
        $this->pdxRegion               = $str($ap->pdx_region);
        $this->realEstateId            = $str($ap->RealEstateID);
        $this->siteArea                = $float($ap->SiteArea);
        $this->siteCode                = $str($ap->Site['type']);
        $this->siteRentContractEndDate = $ap->SiteRentContractEndDate;
        $this->buildingPlanSituation   = $str($ap->BuildingPlanSituation);
        $this->buildingPlanInformation = $str($ap->BuildingPlanInformation);
        $this->buildingRights          = $float($ap->BuildingRights);
        $this->estateNameAndNumber     = $str($ap->EstateNameAndNumber);
        $this->propertyAdditionalInfo  = $str($ap->pdx_property_extra);
        $this->municipalDevelopment    = $str($ap->MunicipalDevelopment);
        $this->shore                   = $str($ap->Shore);
        $this->shoreDescription        = $str($ap->ShoresDescription);

        $this->yearOfBuilding           = $year($ap->YearOfBuilding['original']);
        $this->buildingMaterial         = $str($ap->BuildingMaterial);
        $this->roofType                 = $str($ap->RoofType);
        $this->roomTypes                = $str($ap->RoomTypes);
        $this->heating                  = $str($ap->Heating);
        $this->ventilationSystem        = $str($ap->VentilationSystem);
        $this->livingArea               = $float($ap->LivingArea);
        $this->totalArea                = $float($ap->TotalArea);
        $this->totalAreaDescription     = $str($ap->TotalAreaDescription);
        $this->generalConditionLevel    = $str($ap->GeneralCondition['level']);
        $this->generalCondition         = $str($ap->GeneralCondition);
        $this->energyClass              = $str($ap->{'rc-energyclass'});
        $this->supplementaryInformation = $str($ap->SupplementaryInformation);
        $this->basicRenovations         = $str($ap->BasicRenovations);
        $this->floorLocation            = $str($ap->FloorLocation);
        $this->balcony                  = $yesOrNo($ap->Balcony['value']);
        $this->balconyDescription       = $str($ap->Balcony);
        $this->asbestosMapping          = $str($ap->asbestos_mapping);

        $this->kitchenAppliances    = $str($ap->KitchenAppliances);
        $this->kitchenWall          = $str($ap->KitchenWall);
        $this->kitchenFloor         = $str($ap->KitchenFloor);
        $this->bedroomAppliances    = $str($ap->BedroomAppliances);
        $this->bedroomWall          = $str($ap->BedroomWall);
        $this->bedroomFloor         = $str($ap->BedroomFloor);
        $this->livingRoomAppliances = $str($ap->LivingRoomAppliances);
        $this->livingRoomFloor      = $str($ap->LivingRoomFloor);
        $this->livingRoomWall       = $str($ap->LivingRoomWall);
        $this->bathroomAppliances   = $str($ap->BathroomAppliances);
        $this->bathroomWall         = $str($ap->BathroomWall);
        $this->bathroomFloor        = $str($ap->BathroomFloor);
        $this->floor                = $str($ap->Floor);
        $this->sauna                = 'K' == $ap->Sauna['own'] ? $str($ap->Sauna) : '';
        $this->storageSpace         = $str($ap->StorageSpace);
        $this->parkingSpace         = $str($ap->ParkingSpace);

        $this->connections = $str($ap->Connections);
        $this->services    = $str($ap->Services);

        $this->electricityConsumption = $str($ap->ElectricityConsumption);
        $this->estateTax              = $str($ap->EstateTax);
        $this->otherFees              = $str($ap->OtherFees);
        $this->latitude              = $str($ap->Latitude);
        $this->longitude              = $str($ap->Longitude);

        $this->pictureUrls = $this->parsePictureUrls($ap);
    }

    /**
     * Parses all the tags in the form of 'PictureNN' where 'NN' is an integer
     *
     * @param SimpleXMLElement $ap
     *
     * @return string[] List of image URLs
     */
    private function parsePictureUrls(SimpleXMLElement $ap): array
    {
        $urls = [];
        // loop through all the apartment properties to find the pictures
        foreach ($ap->children() as $name => $node) {
            // add value of children that match given tag name pattern
            if (preg_match('/^Picture\d+$/', $name)) {
                // convert node value to a string
                $urls[] = trim((string)$node);
            }
        }

        return $urls;
    }
}
