<?php

/**
 * Finds a listing based on a key.
 */

namespace Helmikohteet\ListingDetails;

use SimpleXMLElement;

/**
 * Listing finder.
 */
class Finder
{
    private SimpleXMLElement $apartments;

    public function __construct(SimpleXMLElement $apartments)
    {
        $this->apartments = $apartments->Apartment;
    }

    /**
     * Filters the list to the first listing that matches given key.
     *
     * @param string $listingKey
     *
     * @return SimpleXMLElement|null Listing data, or null if not found.
     */
    public function getListingData(string $listingKey): ?SimpleXMLElement
    {
        foreach ($this->apartments as $apartment) {
            if ($listingKey == $apartment->Key) {
                return $apartment;
            }
        }

        return null;
    }
}
