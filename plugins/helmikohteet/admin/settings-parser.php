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
        $input['api_url'] = esc_url($input['api_url']);
    }

    // Google Maps API key
    if (isset($input['google_api_key'])) {
        $input['google_api_key'] = sanitize_text_field($input['google_api_key']);
    }

    return $input;
}
