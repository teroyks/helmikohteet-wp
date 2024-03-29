<?php
/*
Plugin Name: Helmikohteet
Plugin URI: https://github.com/teroyks/helmikohteet-wp
Description: Helmi-kohteiden haku ja selailu
Version: 0.8.7
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
use Helmikohteet\ListingDetails\Finder as ListingFinder;
use Helmikohteet\ListingDetails\Listing as DetailedListing;
use Helmikohteet\ListingsList\Listing;
use Helmikohteet\ListingsList\ListParser;
use Helmikohteet\PluginConfig;
use Helmikohteet\Utilities\Format;

if (!defined('ABSPATH')) {
    exit;
}


function helmikohteet_query_rewrite() {
  add_rewrite_rule(PluginConfig::DETAILS_KEY_PARAM . '/?([^/]*)', 'index.php?hmk_lid=$matches[1]', 'top');
}


function helmikohteet_set_query_vars($vars) {
  $vars[] = PluginConfig::DETAILS_KEY_PARAM;
  return $vars;
}

function helmikohteet_flush_rules() {
  flush_rewrite_rules();
}

add_action('init', 'helmikohteet_query_rewrite');
add_filter('query_vars', 'helmikohteet_set_query_vars');
add_action('init', 'helmikohteet_flush_rules');

/**
 * Initializes the plugin on activation.
 *
 * - TODO: update transient content
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
 * - TODO: remove the transient data & settings.
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
    // include the script for filtering listings
    wp_enqueue_script(
        'helmikohteet-filter', // js script link id handle
        plugin_dir_url(__FILE__) . 'public/js/helmikohteet-filter.js', // script URL
        [], // dependencies that need to be loaded before this file
        null, // version query string parameter value
        true // put JS in the footer
    );

    // fetch the listings data
    try {
        $xml = HelmiClient::getListingsXml();
    } catch (Exception $e) {
        return '<div class="helmik-error">Kohteiden haku epäonnistui</div>';
    }

    // convert XML to an array of Listing objects
    $all_listings = (new ListParser($xml))->getApartments(Listing::STATUS_FOR_SALE);
    // echo '<pre>';
    // var_dump($all_listings[0]); // first apartment
    // echo '</pre>';

    // format decimal numbers
    $format_number = fn($nr) => is_numeric($nr) ? number_format($nr, 2, ',', ' ') : '';

    // define listing type class
    $listing_type_class = fn($type) => Listing::TYPE_SALE == $type
        ? 'helmik-listing-type-sale' : 'helmik-listing-type-rental';

    // modifies a string into one that can be used as element id
    $str2id = fn($str) => preg_replace('/[^a-z0-9]/', '', strtolower($str));

    $filter_value_sale   = Listing::TYPE_SALE;
    $filter_value_rental = Listing::TYPE_RENTAL;

    $apartment_types = array_map(fn($listing) => $listing->apartmentType, $all_listings);
    sort($apartment_types);
    $uniq_apartment_types   = array_unique($apartment_types);
    $filter_apartment_types = implode(
        "\n",
        array_map(
            fn($type) => '
            <label for="helmik-' . $str2id($type) . '">
              <input id="helmik-' . $str2id($type) . '" type="checkbox" class="helmik-filter-checkbox" value="' . $type . '" />
              <span>' . $type . '</span>
            </label></span>',
            $uniq_apartment_types
        )
    );

    $output = <<<END
        <div class="helmik-listing-filters">
          <form method="get" action="#" id="helmik-filter-form">
            <div class="helmik-filter-row">
              <div class="helmik-filter-column">
                <label>Vapaasanahaku:</label>
                <input type="text" class="helmik-filter-input" id="helmik-search">
                <label>Hinta:</label>
                <div class="helmik-range-row">
                  <input type="number" class="helmik-filter-input" id="helmik-min-price"/>
                  -
                  <input type="number" class="helmik-filter-input" id="helmik-max-price"/>
                </div>
                <label>Pinta-ala:</label>
                <div class="helmik-range-row">
                  <input type="number" class="helmik-filter-input" id="helmik-min-area"/>
                  -
                  <input type="number" class="helmik-filter-input" id="helmik-max-area"/>
                </div>
                <fieldset id="helmik-filter-listing-type">
                  <label>Asumismuoto:</label>
                  <label for="helmik-filter-type-for-sale">
                    <input type="checkbox" class="helmik-filter-checkbox" id="helmik-filter-type-for-sale" value="$filter_value_sale" />
                    <span>Myydään</span>
                  </label>
                  <label for="helmik-filter-type-for-rent">
                    <input type="checkbox" class="helmik-filter-checkbox" id="helmik-filter-type-for-rent" value="$filter_value_rental" />
                    <span>Vuokrataan</span>
                  </label>
                </fieldset>
              </div>
              <div class="helmik-filter-column">
                <fieldset id="helmik-filter-apartment-type">
                  <label>Kohdetyyppi:</label>
                  $filter_apartment_types
                </fieldset>
              </div>
            </div>
          </form>
        </div>
        <style>
          .filtered-out {
            display: none;
          }
        </style>
        <div class="helmik-listing-container">
        END;

    // list all the properties
    foreach ($all_listings as $listing) {
        if (Listing::TYPE_SALE == $listing->listingType) {
            $priceLabel = 'Myyntihinta';
            if ($listing->onlineOffer == "K") {
                $priceLabel = 'Lähtöhinta';
            }
            $price      = $listing->salesPrice;
        } else {
            $priceLabel = 'Vuokra/kk';
            $price      = $listing->rentAmount;
        }

        $unencumberedSalesPrice = "";
        $dataPrice = $price;
        if ($listing->realEstateType == 'OSAKE' && Listing::TYPE_SALE == $listing->listingType) {
            $unencumberedSalesPrice = '<div class="helmik-listing-description">Velaton hinta ' . $format_number(
                    $listing->unencumberedSalesPrice
                ) . '&nbsp;€</div>';
            if ($listing->onlineOffer == "K") {
                $unencumberedSalesPrice = '<div class="helmik-listing-description">Lähtöhinta ilman velkaosuutta ' . $format_number(
                      $listing->unencumberedSalesPrice
                  ) . '&nbsp;€</div>';
            }
            $dataPrice = $listing->unencumberedSalesPrice;
        }

        // year of building may not be listed
        if ($listing->yearOfBuilding) {
            $yearOfBuildingIfDefined = '<div class="helmik-listing-description">Valmistui ' . $listing->yearOfBuilding . '</div>';
        } else {
            $yearOfBuildingIfDefined = ''; // don't show year unless it is included
        }

        // link to the details page
        $detailsLink = get_site_url() . '/' . PluginConfig::DETAILS_KEY_PARAM . '/' . $listing->key;

        $output .= <<<END
            <section
              class="helmik-listing {$listing_type_class($listing->listingType)}"
              data-listing-type="$listing->listingType"
              data-apartment-type="$listing->apartmentType"
              data-apartment-address="$listing->address"
              data-apartment-rooms="$listing->rooms"
              data-apartment-area="$listing->area"
              data-apartment-city="$listing->city"
              data-apartment-price="$dataPrice"
            >
              <a href="{$detailsLink}">
                <div class="helmik-listing-img">
                  <img src="{$listing->imgUrl}" alt="" />
                </div>
                <div class="helmik-listing-content">
                  <h1 class="helmik-listing-title">{$listing->apartmentType}, {$listing->city}</h1>
                  <div class="helmik-listing-description">{$listing->address}</div>
                  {$yearOfBuildingIfDefined}
                  <div class="helmik-listing-description">{$listing->rooms}</div>
                  {$unencumberedSalesPrice}
                  <div class="helmik-listing-description">{$priceLabel} {$format_number($price)}&nbsp;€</div>
                  <div class="helmik-listing-description">Pinta-ala {$format_number($listing->area)}&nbsp;m²</div>
                </div>
              </a>
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
 * @todo         can a page template be used here?
 * @todo         handle the 'Not Found' error
 * @noinspection PhpUnusedLocalVariableInspection
 */
function helmikohteet_listing_details()
{
    $rawListingId = get_query_var(PluginConfig::DETAILS_KEY_PARAM);
    if (!$rawListingId) {
        return;
    }

    try {
        $allListings = HelmiClient::getListingsXml();
    } catch (Exception $e) {
        // could not load listing data
        return;
    }

    $listingId     = sanitize_key($rawListingId);
    $listingFinder = new ListingFinder($allListings);
    $rawData       = $listingFinder->getListingData($listingId);
    if ($rawData) {
        // template formatting helper
        $fmt = new Format();

        $ls = new DetailedListing($rawData); // pass values to the template

        // determine the template to use based on the listing type
        $detailsTemplate = $ls->realEstateType == 'KIINTEISTO' ? 'details_real_estate.php' : 'details_apartment.php';

        include_once plugin_dir_path(__FILE__) . "templates/$detailsTemplate";
    }
    die();
}

add_filter('parse_query', 'helmikohteet_listing_details');

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
        'api_key' => '',
    ];
}

// if (is_page()) {
//     // ignore plugin stuff on posts
// }
