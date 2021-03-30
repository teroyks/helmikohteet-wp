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

/** @noinspection PhpIncludeInspection Ignore plugin_dir not found warnings */

// exit if file is called directly
use Helmikohteet\ListingsList\Listing;
use Helmikohteet\ListingsList\ListParser;

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
    // use cached values if available
    if (false === ($listings = get_transient('helmikohteet_listings'))) {
        // cached values have expired

        // fetch new listings, and save as JSON data
        $listing_values_raw = file_get_contents(plugin_dir_path(__FILE__) . '/oikotie.php.xml');
        $listing_values_xml = simplexml_load_string($listing_values_raw);
        $listings           = json_encode($listing_values_xml);

        // $args           = ['listing_content' => $listing_values_json, 'updated_at' => new DateTime()];
        set_transient('helmikohteet_listings', $listings, 30);
    }

    // convert JSON to an associative array
    $all_listings = (new ListParser($listings))->getApartments(Listing::STATUS_FOR_SALE);
    // echo '<pre>';
    // var_dump($all_listings[0]); // first apartment
    // echo '</pre>';

    // format decimal numbers
    $format_number = fn($nr) => is_numeric($nr) ? number_format($nr, 2, ',', ' ') : '';

    $output = <<<END
        <div>Filtering here</div>
        <div class="helmik-listing-container">
        END;

    // list all the properties
    foreach ($all_listings as $listing) {
        $output .= <<<END
            <section class="helmik-listing">
              <div class="helmik-listing-bg-img"></div>
              <div class="helmik-listing-content">
                  <h1 class="helmik-listing-title">{$listing->apartmentType}, {$listing->city}</h1>
                  <div class="helmik-listing-description">{$listing->address}</div>
                  <div class="helmik-listing-description">Valmistui </div>
                  <div class="helmik-listing-description">{$listing->rooms}</div>
                  <div class="helmik-listing-description">Hinta {$format_number($listing->salesPrice)}&nbsp;€</div>
                  <div class="helmik-listing-description">Vuokra {$format_number($listing->rentAmount)} €/kk</div>
                  <div class="helmik-listing-description">Pinta-ala {$format_number($listing->area)}&nbsp;m²</div>
                  <button>Näytä</button>
              </div>
            </section>
            END;
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('helmikohteet', 'helmikohteet_loop_shortcode_get_listings');

register_uninstall_hook(__FILE__, 'helmikohteet_on_uninstall');

// include stuff only needed for the admin interface here
if (is_admin()) {
    $admin_dir = plugin_dir_path(__FILE__) . 'admin';
    // admin dependencies
    require_once "$admin_dir/admin-menu.php"; // add plugin settings to the admin menu
    require_once "$admin_dir/settings-page.php"; // settings page template
    require_once "$admin_dir/settings-register.php"; // register settings
    require_once "$admin_dir/settings-callbacks.php"; // implement settings functionality
    require_once "$admin_dir/settings-parser.php"; // parse submitted settings values
}

// dependencies for both admin and public site
/** @noinspection PhpIncludeInspection */
require_once plugin_dir_path(__FILE__) . 'includes/core-functions.php'; // common core functionality

/**
 * Includes used classes from the namespace directory automatically.
 *
 * NOTE: All classes must be defined under the 'Helmikohteet\' namespace.
 *
 * @param string $class_name Fully qualified class name
 */
function helmikohteet_autoload(string $class_name)
{
    // parse a fully qualified name
    $namespace_parts = explode('\\', $class_name);
    $main_namespace  = array_shift($namespace_parts);

    // only apply to the 'Helmikohteet' namespace
    if ('Helmikohteet' !== $main_namespace) {
        return;
    }

    // build the class file path
    array_unshift($namespace_parts, plugin_dir_path(__FILE__) . 'Helmikohteet');
    $file_path = implode(DIRECTORY_SEPARATOR, $namespace_parts) . '.php';

    if (!file_exists($file_path)) {
        wp_die(esc_html("Cannot load $class_name: file not found"));
    }

    include_once($file_path);
}

spl_autoload_register('helmikohteet_autoload');

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
