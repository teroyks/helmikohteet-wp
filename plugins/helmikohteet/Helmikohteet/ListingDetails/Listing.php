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
    public string $description;
    public string $apartmentType;
    public string $becomesAvailable;
    public float  $salesPrice;
    public string $streetAddress;
    public string $postalCode;
    public string $region;
    public string $city;
    public string $realEstateId;
    public float  $siteArea;
    public string $siteCode;
    public string $siteRentContractEndDate;
    public string $buildingPlanSituation;
    public string $buildingPlanInformation;
    public float  $buildingRights;
    public string $estateNameAndNumber;
    public string $propertyAdditionalInfo;
    public string $municipalDevelopment;
    public string $shore;
    public string $shoreDescription;

    public string $yearOfBuilding;
    public string $buildingMaterial;
    public string $roofType;
    public string $roomTypes;
    public string $heating;
    public string $ventilationSystem;
    public float  $livingArea;
    public float  $totalArea;
    public string $totalAreaDescription;
    public string $generalConditionLevel;
    public string $generalCondition;
    public string $energyClass;
    public string $supplementaryInformation;
    public string $basicRenovations;
    public string $floorLocation;
    public string $asbestosMapping;

    public string $kitchenAppliances;
    public string $kitchenWall;
    public string $kitchenFloor;
    public string $bedroomAppliances;
    public string $bedroomWall;
    public string $bedroomFloor;
    public string $livingRoomAppliances;
    public string $livingRoomFloor;
    public string $livingRoomWall;
    public string $bathroomAppliances;
    public string $bathroomWall;
    public string $bathroomFloor;
    public string $floor;
    public string $sauna;
    public string $storageSpace;
    public string $parkingSpace;

    public string $connections;
    public string $services;

    public string $electricityConsumption;
    public string $estateTax;
    public string $otherFees;

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

        // removes a '0' as indicator for a missing year value
        $year = fn($d) => $d != 0 ? $d : '';

        $this->description             = $str($ap->Description);
        $this->apartmentType           = ApartmentType::get($ap['type']);
        $this->becomesAvailable        = $str($ap->BecomesAvailable);
        $this->salesPrice              = $float($ap->SalesPrice);
        $this->streetAddress           = $str($ap->StreetAddress);
        $this->postalCode              = $str($ap->PostalCode);
        $this->region                  = $str($ap->pdx_region);
        $this->city                    = $str($ap->City);
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
    }
}
