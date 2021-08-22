<?php

/**
 * Listing data to show in the list.
 */

namespace Helmikohteet\ListingsList;

use SimpleXMLElement;

/**
 * Listing data parser for listings list.
 */
class Listing
{
    public const STATUS_FOR_SALE    = 'Myynnissä';
    public const STATUS_WANT_TO_BUY = 'Hankinnassa';

    public const TYPE_SALE   = 'Myydään';
    public const TYPE_RENTAL = 'Vuokrataan';

    public const HABITATION_MODE_RENTAL = 'VU';

    public string $key;
    public string $city;
    public string $address;
    public string $salesPrice;
    public string $unencumberedSalesPrice;
    public string $rentAmount;
    public string $rooms;
    public string $area;
    public ?array $attributes;
    public string $status;
    public string $apartmentType;
    public string $listingType;
    public ?int   $yearOfBuilding;
    public string $imgUrl;
    public string $moreInfoUrl;

    public function __construct(SimpleXMLElement $data)
    {
        // determine whether this is a sale or rental listing
        $parseListingType = fn($habitationType) => self::HABITATION_MODE_RENTAL == $habitationType
            ? self::TYPE_RENTAL : self::TYPE_SALE;

        // determine a year value: invalid value can be 0
        $parseYear = fn($val): ?int => is_numeric($val) && $val > 0 ? (int)$val : null;

        $this->key                      = sanitize_key($data->Key);
        $this->city                     = $data->City;
        $this->address                  = $data->StreetAddress;
        $this->salesPrice               = $data->SalesPrice;
        $this->unencumberedSalesPrice   = $data->UnencumberedSalesPrice;
        $this->rentAmount               = $data->RentPerMonth;
        $this->rooms                    = $data->RoomTypes;
        $this->area                     = $data->LivingArea;
        $this->status                   = $data->Status;
        $this->imgUrl                   = str_replace('/images/', '/images/thumbs/', $data->Picture1);
        $this->moreInfoUrl              = $data->MoreInfoUrl;
        $this->realEstateType           = $data['realEstateType'];

        $apartmentTypeCode   = $data['type'];
        $this->apartmentType = ApartmentType::get($apartmentTypeCode);

        $habitationType    = $data->ModeOfHabitation['type'];
        $this->listingType = $parseListingType($habitationType);

        $this->yearOfBuilding = $parseYear($data->YearOfBuilding['original']);
    }
}
