<?php

/**
 * Listing data to show in the list.
 */

namespace Helmikohteet\ListingsList;

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

    public string $city;
    public string $address;
    public string $salesPrice;
    public string $rentAmount;
    public string $rooms;
    public string $area;
    public ?array $attributes;
    public string $status;
    public string $apartmentType;
    public string $listingType;
    public ?int   $yearOfBuilding;
    public string $imgUrl;

    public function __construct(array $data)
    {
        // parse the array property value into a string
        $parse = fn($propName, $allowNoValue = false) => isset($data[$propName])
            ? (!empty($data[$propName]) ? $data[$propName] : '')
            : ($allowNoValue ? '' : '⚠️ *** UNKNOWN ***');

        // determine whether this is a sale or rental listing
        $parseListingType = fn($habitationType) => self::HABITATION_MODE_RENTAL == $habitationType
            ? self::TYPE_RENTAL : self::TYPE_SALE;

        // determine a year value: invalid value can be 0
        $parseYear = fn($val): ?int => is_numeric($val) && $val > 0 ? (int)$val : null;

        $this->city       = $parse('City');
        $this->address    = $parse('StreetAddress');
        $this->salesPrice = $parse('SalesPrice', true);
        $this->rentAmount = $parse('RentPerMonth', true);
        $this->rooms      = $parse('RoomTypes');
        $this->area       = $parse('LivingArea');
        $this->attributes = $data['@attributes'] ?? ['type' => '⚠️ NO ATTRIBUTES'];
        $this->status     = $parse('Status');
        $this->imgUrl     = $parse('Picture1');

        $this->apartmentType = ApartmentType::get($this->attributes['type'] ?? '');

        $habitationType    = $data['ModeOfHabitation']['@attributes']['type'] ?? '';
        $this->listingType = $parseListingType($habitationType);

        $this->yearOfBuilding = $parseYear($data['YearOfBuilding']['@attributes']['original'] ?? null);
    }
}
