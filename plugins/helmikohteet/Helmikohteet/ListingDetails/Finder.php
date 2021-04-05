<?php

/**
 * Finds a listing based on a key.
 */

namespace Helmikohteet\ListingDetails;

/**
 * Listing finder.
 */
class Finder
{
    /** @var array All listings */
    private array $apartments;

    private const DECODE_ASSOC = true;

    public function __construct(string $jsonApartments)
    {
        $this->apartments = json_decode($jsonApartments, self::DECODE_ASSOC)['Apartment'];
    }

    /**
     * Filters the list to a single listing that matches given key.
     *
     * @param string $listingKey
     *
     * @return array Listing data, or empty array if not found.
     */
    public function getListingData(string $listingKey): array
    {
        // if found, array_filter returns exactly one element, i.e. the listing data
        return
            array_values(
                array_filter(
                    $this->apartments,
                    fn($listing) => $listingKey == $listing['Key']
                )
            )[0] ?? [];
    }
}
