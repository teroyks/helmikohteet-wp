<?php
/**
 * Admin settings functionality.
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
    // TODO add parser functionality
    return $input;
}

/**
 * Outputs info text for the API settings section.
 */
function helmikohteet_callback_section_api()
{
    echo '<p>TODO: set up listings API</p>';
}

/**
 * Outputs an admin setting text input field.
 *
 * @param array $args Field attributes
 */
function helmikohteet_callback_field_text(array $args)
{
    echo '<p>TODO: put a text field here</p>';
}
