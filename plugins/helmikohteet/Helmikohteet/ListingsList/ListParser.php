<?php

/**
 * Parses the apartment listings list from the transient listings
 */

namespace Helmikohteet\ListingsList;

use SimpleXMLElement;

/**
 * Parser for a list of apartments.
 */
class ListParser
{
    /** @var SimpleXMLElement Traversable container for all apartment data */
    private SimpleXMLElement $apartments;

    public function __construct(SimpleXMLElement $listings)
    {
        $this->apartments = $listings->Apartment;
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
        $listings = [];
        foreach ($this->apartments as $apartment) {
            // only include listings of the requested type
            if ($statusToInclude != $apartment->Status) {
                continue; // ignore this one
            }
            $listings[] = new Listing($apartment);
        }

        // sort the listings in reverse order by ID key -- newest to oldest
        $keyToInt = fn (Listing $l): int => (int)$l->key;
        usort($listings, fn($a, $b) => $keyToInt($b) <=> $keyToInt($a));

        return $listings;
    }
}
