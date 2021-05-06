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
    if (isset($input['api_url'])) {
        $input['api_url'] = esc_attr($input['api_url']);
    }

    // Google Maps API key
    if (isset($input['google_api_key'])) {
        $input['google_api_key'] = esc_attr($input['google_api_key']);
    }

    return $input;
}
