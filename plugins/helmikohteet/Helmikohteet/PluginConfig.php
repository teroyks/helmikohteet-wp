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
}
