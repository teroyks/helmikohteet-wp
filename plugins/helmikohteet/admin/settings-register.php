<?php
/**
 * Plugin settings definitions.
 */

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registers the plugin settings.
 */
function helmikohteet_register_settings()
{
    register_setting(
        'helmikohteet_options', // option group - see settings_fields in settings-page.php
        'helmikohteet_options', // option name in db
        'helmikohteet_callback_parse_options' // sanitizer callback function
    );

    add_settings_section(
        'helmikohteet_section_api', // section id
        'API-asetukset', // section title
        'helmikohteet_callback_section_api', // section description callback
        'helmikohteet' // page to display the section in - see menu_slug in admin-menu.php
    );

    add_settings_field(
        'api_key', // db setting id
        'Helmi-tunnus', // field title
        'helmikohteet_callback_field_text', // callback function for setting markup
        'helmikohteet', // page slug
        'helmikohteet_section_api', // settings section
        ['id' => 'api_key', 'label' => 'Kohteiden haun tunnus'] // callback parameters
    );

    add_settings_field(
        'google_api_key', // db setting id
        'Google Maps API Key', // field title
        'helmikohteet_callback_field_text', // callback function for setting markup
        'helmikohteet', // page slug
        'helmikohteet_section_api', // settings section
        ['id' => 'google_api_key', 'label' => 'Google Maps API-tunnus'] // callback parameters
    );
}

add_action('admin_init', 'helmikohteet_register_settings');
