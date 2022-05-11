<?php

/**
 * Helmi API client with WP caching.
 */

namespace Helmikohteet\HelmiApi;

use Exception;
use Helmikohteet\PluginConfig;
use SimpleXMLElement;

/**
 * Fetches and caches data from the Helmi API.
 */
class Client
{
    /** @var string Settings key for the cached listings XML data */
    private const LISTINGS_KEY = 'helmikohteet_listings';

    /**
     * Fetches the raw listings data cached in transients.
     *
     * Updates the cached value if it has expired.
     *
     * @return string All listings (JSON)
     * @deprecated use XML listing instead
     */
    public static function getListingsJson(): string
    {
        if (false === ($listings = get_transient('helmikohteet_listings'))) {
            // cached values have expired
            error_log('Helmikohteet listing has expired; fetching from API...');

            // fetch new listings, and save as JSON data
            $api_url = PluginConfig::apiUrl();
            $args = ['user-agent' => 'Helmikohteet Plugin; ' . home_url()];
            $response = wp_safe_remote_get($api_url, $args);
            $listing_values_raw = wp_remote_retrieve_body($response);
            $listing_values_xml = simplexml_load_string($listing_values_raw);
            $listings = json_encode($listing_values_xml);

            set_transient('helmikohteet_listings', $listings, PluginConfig::listingsExpirationInternal());
        }

        return $listings;
    }

    /**
     * Fetches the apartments data cached in transients.
     *
     * Updates the cached value if it has expired.
     * Updates the sitemap if new listings data is fetched.
     *
     * @return SimpleXMLElement All listings Apartments->[Apartment, ...]
     * @throws Exception if the API query doesn't return a valid XML file.
     */
    public static function getListingsXml(): SimpleXMLElement
    {
        /**
         * Parsed XML data -- prevents parsing the same data twice when refreshing the cache.
         *
         * @var SimpleXMLElement|bool $parsed_listings parsed XML data
         */
        $parsed_listings = false;

        if (false === ($listings = get_transient(self::LISTINGS_KEY))) {
            // cached values have expired
            error_log('Helmikohteet listings XML expired; fetching from API...');

            // fetch new listings and save the raw XML data
            $api_url = PluginConfig::apiUrl();
            $args = ['user-agent' => 'Helmikohteet Plugin; ' . home_url(), 'timeout' => 45];
            $response = wp_safe_remote_get($api_url, $args);
            $listings = wp_remote_retrieve_body($response);

            // check that valid XML data was returned by the API
            $parsed_listings = simplexml_load_string($listings);
            if (!($parsed_listings)) {
                error_log('ERROR: query did not return a valid result');
                error_log(var_export($listings, true));
                throw new Exception('Query did not return a valid result');
            }

            // only cache a valid result
            set_transient(
                self::LISTINGS_KEY,
                $listings,
                PluginConfig::listingsExpirationInternal()
            );

            // create a sitemap for updated listing

            $sitemap = (new Sitemap($parsed_listings))
                ->build();
            file_put_contents(
                ABSPATH . '/sitemap_helmi.xml',
                $sitemap->asXML()
            );

            // TODO ping Google with sitemap
            // TODO ping Google only if sitemap contents have changed
            // TODO only ping if enabled in settings
        }

        return $parsed_listings ?: simplexml_load_string($listings);
    }
}
