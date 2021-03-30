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
    public string $price;
    public string $rooms;
    public string $area;
    public ?array $attributes;
    public string $status;
    public string $type;

    public function __construct(array $data)
    {
        $parse = fn($propName) => isset($data[$propName])
            ? (!empty($data[$propName]) ? $data[$propName] : 'ℹ️ EMPTY')
            : '⚠️ *** UNKNOWN ***';

        $this->city       = $parse('City');
        $this->address    = $parse('StreetAddress');
        $this->price      = $parse('SalesPrice');
        $this->rooms      = $parse('RoomTypes');
        $this->area       = $parse('LivingArea');
        $this->attributes = $data['@attributes'] ?? ['type' => '⚠️ NO ATTRIBUTES'];
        $this->status     = $parse('Status');

        $this->type = ApartmentType::get($this->attributes['type'] ?? '');
    }
}
