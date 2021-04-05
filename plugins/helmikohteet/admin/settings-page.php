<?php
/**
 * Plugin settings page content.
 */

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Displays the settings page content.
 */
function helmikohteet_display_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields
            settings_fields('helmikohteet_options');
            // output settings sections
            do_settings_sections('helmikohteet');

            submit_button('Tallenna');
            ?>
        </form>
    </div>
  <div class="wrap">
    <p>Kohdeluettelon vanhenemisaika: <?= \Helmikohteet\PluginConfig::LISTINGS_EXPIRATION_HOURS ?> tuntia</p>
  </div>
    <?php
}
