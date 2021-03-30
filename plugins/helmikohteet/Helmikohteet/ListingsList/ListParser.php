<?php

/**
 * Parses the apartment listings list from the transient listings
 */

namespace Helmikohteet\ListingsList;

/**
 * Parser for a list of apartments.
 */
class ListParser
{
    private array $apartments;

    public function __construct(string $jsonApartments)
    {
        $this->apartments = json_decode($jsonApartments, true)['Apartment'];
    }

    /**
     * Fetches a list of apartments that match given status.
     *
     * @param string $statusToInclude Status to include in the results
     *
     * @return Listing[] Parsed apartment list
     */
    public function getApartments(string $statusToInclude): array
    {
        // determines whether to include the apartment
        $includeApartment = fn($apartmentData) => $statusToInclude == $apartmentData['Status'];

        // parses the apartment data
        $createListing = fn($apartmentData) => new Listing($apartmentData);

        return array_map(
            $createListing,
            array_filter($this->apartments, $includeApartment)
        );
    }
}
