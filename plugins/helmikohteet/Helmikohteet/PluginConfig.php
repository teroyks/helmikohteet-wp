<?php

/**
 * Helmikohteet plugin settings.
 */

namespace Helmikohteet;

/**
 * Defines the plugin configuration.
 */
class PluginConfig
{
    /** @var string Options table key for plygin settings */
    public const OPTIONS_GROUP = 'helmikohteet_options';

    /** @var string URL parameter for displaying the listing details */
    public const DETAILS_KEY_PARAM = 'hmk_lid';

    /** @var int Amount of time until fetched listings data expires */
    public const LISTINGS_EXPIRATION_HOURS = 1;

    /**
     * Listings API URL.
     *
     * @return string
     */
    public static function apiUrl(): string
    {
        $options = get_option(self::OPTIONS_GROUP);

        $apiKey = esc_attr($options['api_key']);
        return "https://rmr.fi/public/$apiKey/oikotie.php?all";
    }

    /**
     * @return string Google Maps URL with API key from settings
     */
    public static function googleApiUrl(): string
    {
        $options = get_option(self::OPTIONS_GROUP);
        $apiKey  = !empty($options['google_api_key']) ? esc_attr($options['google_api_key']) : '';

        return $apiKey ? "https://maps.googleapis.com/maps/api/js?key=$apiKey&callback=initMap&libraries=&v=weekly" : '';
    }

    /**
     * @return string Leaflet maps API key
     */
    public static function leafletMapsApiKey(): string
    {
        $options = get_option(self::OPTIONS_GROUP);
        $apiKey  = !empty($options['leaflet_api_key']) ? esc_attr($options['leaflet_api_key']) : '';

        return $apiKey;
    }

    /**
     * @return int Internal representation of the listings expiration time.
     */
    public static function listingsExpirationInternal(): int
    {
        // expiration time is set to transients in seconds
        return self::LISTINGS_EXPIRATION_HOURS * 3600;
    }
}
