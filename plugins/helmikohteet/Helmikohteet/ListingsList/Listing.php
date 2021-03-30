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

    public string $city;
    public string $address;
    public string $salesPrice;
    public string $rentAmount;
    public string $rooms;
    public string $area;
    public ?array $attributes;
    public string $status;
    public string $apartmentType;

    public function __construct(array $data)
    {
        $parse = fn($propName) => isset($data[$propName])
            ? (!empty($data[$propName]) ? $data[$propName] : 'ℹ️ EMPTY')
            : '⚠️ *** UNKNOWN ***';

        $this->city       = $parse('City');
        $this->address    = $parse('StreetAddress');
        $this->salesPrice = $parse('SalesPrice');
        $this->rentAmount = $parse('RentPerMonth');
        $this->rooms      = $parse('RoomTypes');
        $this->area       = $parse('LivingArea');
        $this->attributes = $data['@attributes'] ?? ['type' => '⚠️ NO ATTRIBUTES'];
        $this->status     = $parse('Status');

        $this->apartmentType = ApartmentType::get($this->attributes['type'] ?? '');
    }
}
