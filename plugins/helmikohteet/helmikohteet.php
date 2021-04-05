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
use Helmikohteet\HelmiApi\Client as HelmiClient;
use Helmikohteet\ListingsList\Listing;
use Helmikohteet\ListingsList\ListParser;
use Helmikohteet\PluginConfig;

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
    $listings = HelmiClient::getListingsJson();

    // convert JSON to an associative array
    $all_listings = (new ListParser($listings))->getApartments(Listing::STATUS_FOR_SALE);
    // echo '<pre>';
    // var_dump($all_listings[0]); // first apartment
    // echo '</pre>';

    // format decimal numbers
    $format_number = fn($nr) => is_numeric($nr) ? number_format($nr, 2, ',', ' ') : '';

    // define listing type class
    $listing_type_class = fn($type) => Listing::TYPE_SALE == $type
        ? 'helmik-listing-type-sale' : 'helmik-listing-type-rental';

    $output = <<<END
        <div>Filtering here</div>
        <div class="helmik-listing-container">
        END;

    // list all the properties
    foreach ($all_listings as $listing) {
        if (Listing::TYPE_SALE == $listing->listingType) {
            $priceLabel = 'Hinta';
            $price      = $listing->salesPrice;
        } else {
            $priceLabel = 'Vuokra/kk';
            $price      = $listing->rentAmount;
        }

        // year of building may not be listed
        if ($listing->yearOfBuilding) {
            $yearOfBuildingIfDefined = '<div class="helmik-listing-description">Valmistui ' . $listing->yearOfBuilding . '</div>';
        } else {
            $yearOfBuildingIfDefined = ''; // don't show year unless it is included
        }

        // link to the details page
        $detailsLink = get_site_url() . '?' . http_build_query([PluginConfig::DETAILS_KEY_PARAM => $listing->key]);

        $output .= <<<END
            <section class="helmik-listing {$listing_type_class($listing->listingType)}">
              <div class="helmik-listing-img">
                <img src="{$listing->imgUrl}" alt="" />
              </div>
              <div class="helmik-listing-content">
                  <h1 class="helmik-listing-title">{$listing->apartmentType}, {$listing->city}</h1>
                  <div class="helmik-listing-description">{$listing->address}</div>
                  {$yearOfBuildingIfDefined}
                  <div class="helmik-listing-description">{$listing->rooms}</div>
                  <div class="helmik-listing-description">{$priceLabel} {$format_number($price)}&nbsp;€</div>
                  <div class="helmik-listing-description">Pinta-ala {$format_number($listing->area)}&nbsp;m²</div>
                  <div><a href="{$detailsLink}">Näytä</a></div>
              </div>
            </section>
            END;
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('helmikohteet', 'helmikohteet_loop_shortcode_get_listings');

/**
 * Replaces page HTML with the listing details.
 *
 * @todo can a page template be used here?
 */
function helmikohteet_listing_details()
{
    if (!isset($_GET[PluginConfig::DETAILS_KEY_PARAM])) {
        return;
    }

    $rawListings   = HelmiClient::getListingsJson();
    $listingId     = sanitize_key($_GET[PluginConfig::DETAILS_KEY_PARAM]);
    $listingFinder = new Helmikohteet\ListingDetails\Finder($rawListings);
    $rawData       = $listingFinder->getListingData($listingId);
    include plugin_dir_path(__FILE__) . 'templates/listing_details.php';
    die();
}

add_filter('init', 'helmikohteet_listing_details');

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
