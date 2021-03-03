<?php
/**
 * Admin settings functionality.
 */

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Outputs info text for the API settings section.
 */
function helmikohteet_callback_section_api()
{
    echo '<p>Asetukset kohteiden hakemiseksi Helmi-järjestelmästä</p>';
}

/**
 * Outputs an admin setting text input field.
 *
 * @param array $args Field attributes
 */
function helmikohteet_callback_field_text(array $args)
{
    $options = get_option(
        'helmikohteet_options', // option name given in register_setting
        helmikohteet_options_default()
    );

    $id    = $args['id'] ?? '';
    $label = $args['label'] ?? '';

    $value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';

    echo <<<FIELD
        <input id="helmikohteet_options_{$id}" name="helmikohteet_options[{$id}]" type="text" size="40" value="{$value}"><br />
        <label for="helmikohteet_options_{$id}">{$label}</label>
        FIELD;
}
