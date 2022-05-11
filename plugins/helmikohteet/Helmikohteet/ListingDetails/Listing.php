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
    public string $onlineOffer; // tarjouskauppa
    public string $onlineOfferUrl; // tarjouskaupan seurannan url
    public float  $onlineOfferHighestBid; // korkein tarjous
    public string $oikotieID; // kohdenumero
    public string $modeOfHabitation; // myynti vai vuokra
    public string $description; // kuvaus
    public string $apartmentType; // kohdetyyppi
    public string $realEstateType; // kiinteistötyyppi
    public string $becomesAvailable; // vapautuminen
    public float  $salesPrice; // myyntihinta
    public float  $debtPart; // velkaosuus
    public float  $unencumberedSalesPrice; // velaton myyntihinta
    public float  $rentAmount; // kuukausivuokra
    public float  $rentDeposit; // vuokravakuus
    public string $rentDepositText; // vuokravakuus
    public string $rentingTerms; // vuokravakuus
    public string $streetAddress; // osoite
    public string $flatNumber; // huoneistotarkenne
    public string $postalCode; // postinumero
    public string $region; // kaupunginosa
    public string $city; // kaupunki
    public string $pdxRegion; // maakunta
    public string $realEstateId; // kiinteistötunnus
    public float  $siteArea; // tontin pinta-ala
    public string $siteCode; // tontin omistus (koodi)
    public string $leaseHolder; // tontin vuokranantaja
    public string $siteRentContractEndDate; // tontin vuokrasopimus päättyy
    public string $siteRent;
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
    public string $realEstateManagement; // kiinteistönhoito
    public string $roofType; // kattotyyppi
    public string $roomTypes; // huonekuvaus
    public string $antennaSystem; // tv-järjestelmä
    public string $commonAreas; // yhteiset tilat
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
    public string $futureRenovations; // tulevat korjaukse
    public string $honoringClause; // lunastuslauseke
    public string $floorLocation; // asunnon kerros
    public string $floorCount; // kerrosmäärä
    public string $lift; // hissi
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
    public string $housingCompanyName; // Taloyhtiön nimi
    public string $housingCompanyFee; // Yhtiövastike
    public string $financingFee; // Rahoitusvastike
    public string $maintenanceFee; // Hoitovastike
    public float $carParkingCharge; // Autopaikka / kk
    public string $waterFee; // Vesimaksu
    public string $waterFeeExplanation; // Vesimaksun lisätiedot
    public string $electricityConsumption; // energiankulutus
    public string $estateTax; // kiinteistövero
    public string $otherFees; // muut maksut

    public string $latitude; // sijainti latitude
    public string $longitude; // sijainti longitude
    public array  $pictureUrls = []; // asunnon kuvat

    public string $agentName; // esittelijän nimi
    public string $agentEmail; // esittelijän email
    public string $agentPhone; // esittelijän puhelinnumero
    public string $agentPictureUrl; // esittelijän kuva

    public string $showingExplanation; // näytön lisäteksti
    public string $showingDate; // näyttöpvm dd.mm.yyyy
    public string $showingStartTime; // näytön alkuaika HH:MM
    public string $showingEndTime; // näytön päättymisaika HH:MM

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
        $this->oikotieID               = $str($ap->OikotieID);
        $this->modeOfHabitation        = $str($ap->ModeOfHabitation['type']);
        
        $this->onlineOffer             = $str($ap->OnlineOffer);
        $this->onlineOfferHighestBid   = $float($ap->OnlineOfferHighestBid);
        $this->onlineOfferUrl          = $str($ap->OnlineOfferUrl);
        $this->description             = $str($ap->Description);
        $this->apartmentType           = ApartmentType::get($ap['type']);
        $this->realEstateType          = $str($ap['realEstateType']);
        $this->becomesAvailable        = $str($ap->BecomesAvailable);
        $this->salesPrice              = $float($ap->SalesPrice);
        $this->unencumberedSalesPrice  = $float($ap->UnencumberedSalesPrice);
        $this->rentAmount              = $float($ap->RentPerMonth);
        $this->rentDeposit             = $float($ap->RentSecurityDeposit2);
        $this->rentDepositText         = $str($ap->RentSecurityDeposit);
        $this->rentingTerms            = $str($ap->RentingTerms);
        $this->debtPart                = $float($ap->DebtPart);
        $this->streetAddress           = $str($ap->StreetAddress);
        $this->flatNumber              = $str($ap->FlatNumber);
        $this->postalCode              = $str($ap->PostalCode);
        $this->region                  = $str($ap->Region);
        $this->city                    = $str($ap->City);
        $this->pdxRegion               = $str($ap->pdx_region);
        $this->realEstateId            = $str($ap->RealEstateID);
        $this->siteArea                = $float($ap->SiteArea);
        $this->siteCode                = $str($ap->Site['type']);
        $this->leaseHolder             = $str($ap->LeaseHolder);
        $this->siteRent                = $str($ap->SiteRent);
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
        $this->realEstateManagement     = $str($ap->RealEstateManagement);
        $this->roofType                 = $str($ap->RoofType);
        $this->roomTypes                = $str($ap->RoomTypes);
        $this->antennaSystem            = $str($ap->AntennaSystem);
        $this->commonAreas              = $str($ap->CommonAreas);
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
        $this->futureRenovations        = $str($ap->FutureRenovations);
        $this->honoringClause           = $str($ap->HonoringClause);
        $this->floorLocation            = $str($ap->FloorLocation);
        $this->floorCount               = $str($ap->FloorLocation['count']);
        $this->lift                     = $yesOrNo($ap->Lift['value']);
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

        $this->housingCompanyFee      = $str($ap->HousingCompanyFee);
        $this->housingCompanyName      = $str($ap->HousingCompanyName);
        $this->financingFee           = $str($ap->FinancingFee);
        $this->maintenanceFee         = $str($ap->MaintenanceFee);
        $this->carParkingCharge       = $float($ap->CarParkingCharge);
        $this->waterFee               = $str($ap->WaterFee);
        $this->waterFeeExplanation    = $str($ap->WaterFeeExplanation);
        $this->electricityConsumption = $str($ap->ElectricityConsumption);
        $this->estateTax              = $str($ap->EstateTax);
        $this->otherFees              = $str($ap->OtherFees);
        $this->latitude               = $str($ap->Latitude);
        $this->longitude              = $str($ap->Longitude);

        $this->agentName       = $str($ap->EstateAgentContactPerson);
        $this->agentEmail      = $str($ap->EstateAgentContactPersonEmail);
        $this->agentPhone      = $str($ap->EstateAgentTelephone);
        $this->agentPictureUrl = $str($ap->EstateAgentContactPersonPictureUrl);

        $this->showingExplanation = $str($ap->ShowingDateExplanation1);
        $this->showingDate        = $str($ap->ShowingDate1);
        $this->showingStartTime   = $str($ap->ShowingStartTime1);
        $this->showingEndTime     = $str($ap->ShowingEndTime1);

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
