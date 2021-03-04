<?php
/*
Plugin Name: Helmikohteet
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Helmi-kohteiden haku ja selailu
Version: 1.0
Author: Tero Ykspetäjä
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this
program. If not, visit: https://www.gnu.org/licenses/
*/

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initializes the plugin on activation.
 *
 * - TODO: create the database table if it doesn’t exist
 * - TODO: update database content
 */
function helmikohteet_on_activation()
{
    if (!current_user_can('activate_plugins')) {
        return;
    }

    error_log('DEBUG: Helmikohteet plugin activated');
}

register_activation_hook(__FILE__, 'helmikohteet_on_activation');

/**
 * Cleans up when the plugin is deleted.
 *
 * - TODO: delete the database table.
 */
function helmikohteet_on_uninstall()
{
    if (!current_user_can('activate_plugins')) {
        return;
    }

    // clean up plugin options
    delete_option('helmikohteet_options');

    error_log('DEBUG: Helmikohteet plugin uninstalled');
}

/**
 * Builds the page listings component.
 *
 * @return string Listings HTML
 */
function helmikohteet_loop_shortcode_get_listings(): string
{
    // DEBUG: use global posts variable until there are listings to fetch
    $listings_list = get_posts();

    $output = '<div>Filtering here</div>';
    foreach ($listings_list as $listing) {
        setup_postdata($listing); // DEBUG, not needed for listings
        $property_name        = get_the_title($listing);
        $property_description = get_the_content($listing);

        $output .= <<<END
            <div class="helmik-listing">
              <div class="helmik-listing-title">{$property_name}</div>
              <div class="helmik-listing-description">{$property_description}</div>
            </div>
            END;
    }

    wp_reset_postdata(); // DEBUG

    return $output;
}

add_shortcode('helmikohteet', 'helmikohteet_loop_shortcode_get_listings');

register_uninstall_hook(__FILE__, 'helmikohteet_on_uninstall');

// include stuff only needed for the admin interface here
if (is_admin()) {
    // admin dependencies
    require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php'; // add plugin settings to the admin menu
    require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php'; // settings page template
    require_once plugin_dir_path(__FILE__) . 'admin/settings-register.php'; // register settings
    require_once plugin_dir_path(__FILE__) . 'admin/settings-callbacks.php'; // implement settings functionality
    require_once plugin_dir_path(__FILE__) . 'admin/settings-parser.php'; // parse submitted settings values
}

// dependencies for both admin and public site
require_once plugin_dir_path(__FILE__) . 'includes/core-functions.php'; // common core functionality

/**
 * Defines default options for the plugin.
 */
function helmikohteet_options_default(): array
{
    return [
        'api_url' => 'https://raumalkv.fi/oikotie.php',
    ];
}

// if (is_page()) {
//     // ignore plugin stuff on posts
// }
