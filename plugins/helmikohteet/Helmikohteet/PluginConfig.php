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

    /** @var int Amount of time until fetched listings data expires */
    public const LISTINGS_EXPIRATION_HOURS = 12;

    /**
     * Listings API URL.
     *
     * @return string
     */
    public static function apiUrl(): string
    {
        $options = get_option(self::OPTIONS_GROUP);

        return !empty($options['api_url']) ? esc_url_raw($options['api_url']) : '';
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
