<?php

/**
 * Helmi API client with WP caching.
 */

namespace Helmikohteet\HelmiApi;

use Helmikohteet\PluginConfig;

/**
 * Fetches and caches data from the Helmi API.
 */
class Client
{
    /**
     * Fetches the raw listings data cached in transients.
     *
     * Updates the cached value if it has expired.
     *
     * @return string All listings (JSON)
     */
    public static function getListingsJson(): string
    {
        if (false === ($listings = get_transient('helmikohteet_listings'))) {
            // cached values have expired
            error_log('Helmikohteet listing has expired; fetching from API...');

            // fetch new listings, and save as JSON data
            $api_url            = PluginConfig::apiUrl();
            $args               = ['user-agent' => 'Helmikohteet Plugin; ' . home_url()];
            $response           = wp_safe_remote_get($api_url, $args);
            $listing_values_raw = wp_remote_retrieve_body($response);
            $listing_values_xml = simplexml_load_string($listing_values_raw);
            $listings           = json_encode($listing_values_xml);

            set_transient('helmikohteet_listings', $listings, PluginConfig::listingsExpirationInternal());
        }

        return $listings;
    }
}
