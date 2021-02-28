<?php
/**
 * Plugin settings submenu item.
 */

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds an admin menu item under the main options menu
 */
function helmikohteet_add_sublevel_menu()
{
    add_submenu_page(
        'options-general.php', // parent slug
        'Helmikohteet: asetukset', // page title
        'Helmikohteet', // menu title
        'manage_options', // required privilege
        'helmikohteet', // menu slug
        'helmikohteet_display_settings_page' // settings function
    );
}

add_action('admin_menu', 'helmikohteet_add_sublevel_menu');
