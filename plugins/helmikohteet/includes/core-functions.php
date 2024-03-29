<?php
/**
 * Core functionality.
 */

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Includes the plugin styles & Javascript in the site code.
 */
function helmikohteet_custom_styles()
{
    // listings list styles
    wp_enqueue_style(
        'helmikohteet', // stylesheet link id handle
        plugin_dir_url(dirname(__FILE__)) . 'public/css/helmikohteet.css', // CSS URL
        [], // dependencies that need to be loaded before this file
        null, // version query string parameter value
        'screen' // media
    );

    // listing details styles
    wp_enqueue_style(
        'helmikohteet_details', // stylesheet link id handle
        plugin_dir_url(dirname(__FILE__)) . 'public/css/helmikohteet-details.css', // CSS URL
        [], // dependencies that need to be loaded before this file
        null, // version query string parameter value
        'screen' // media
    );

    // listing pictures script styles
    wp_enqueue_style(
        'helmikohteet_details_pictures',
        plugin_dir_url(dirname(__FILE__)) . 'public/css/fotorama.css',
        [],
        null,
        'screen'
    );

    wp_enqueue_script(
        'helmikohteet', // js script link id handle
        plugin_dir_url(dirname(__FILE__)) . 'public/js/helmikohteet.js', // script URL
        [], // dependencies that need to be loaded before this file
        null, // version query string parameter value
        true // put JS in the footer
    );
}

add_action(
    'wp_enqueue_scripts', // hook to add scripts & styles to public pages
    'helmikohteet_custom_styles'
);
