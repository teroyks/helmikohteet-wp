<?php
/**
 * Parser rules for the admin options.
 */

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Parses the set up options.
 *
 * @param $input
 *
 * @return mixed
 */
function helmikohteet_callback_parse_options($input)
{
    // listings API URL
    if (isset($input['api_key'])) {
        $input['api_key'] = esc_attr($input['api_key']);
    }

    // Google Maps API key
    if (isset($input['google_api_key'])) {
        $input['google_api_key'] = esc_attr($input['google_api_key']);
    }

    // Leaflet maps API key
    if (isset($input['leaflet_api_key'])) {
        $input['leaflet_api_key'] = esc_attr($input['leaflet_api_key']);
    }

    return $input;
}
