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
        'api_url', // db setting id
        'API URL', // field title
        'helmikohteet_callback_field_text', // callback function for setting markup
        'helmikohteet', // page slug
        'helmikohteet_section_api', // settings section
        ['id' => 'api_url', 'label' => 'API-osoite'] // callback parameters
    );
}

add_action('admin_init', 'helmikohteet_register_settings');
