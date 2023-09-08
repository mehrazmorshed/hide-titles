<?php

/*
 * Plugin Name:         Hide Titles
 * Plugin URI:          https://wordpress.org/plugins/hide-titles/
 * Description:         Hide Titles from all Posts and Pages of your Website.
 * Version:             1.2
 * Requires at least:   5.2
 * Requires PHP:        7.2
 * Tested up to:        6.3.1
 * Author:              Mehraz Morshed
 * Author URI:          https://profiles.wordpress.org/mehrazmorshed/
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         hide-titles
 * Domain Path:         /languages
 */

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load the text-domain
function hide_titles_load_textdomain() {
    load_plugin_textdomain( 'hide-titles', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
add_action( 'init', 'hide_titles_load_textdomain' );

function hide_titles_option_page() {

    add_menu_page( 'Hide Titles Option', 'Hide Titles', 'manage_options', 'hide-titles', 'hide_titles_create_page', 'dashicons-admin-plugins', 101 );
}
add_action( 'admin_menu', 'hide_titles_option_page' );

function hide_titles_style_settings() {

    wp_enqueue_style( 'hide-titles-settings', plugins_url( 'css/hide-titles-settings.css', __FILE__ ), false, "1.0.0" );
}
add_action( 'admin_enqueue_scripts', 'hide_titles_style_settings' );










// Hide all titles
function hide_titles() {
    return false;
}
add_filter('the_title', 'hide_titles');

// Register activation Hook
function hide_titles_activation_hook() {
    set_transient( 'hide-titles-notification', true, 5 );
}
register_activation_hook( __FILE__, 'hide_titles_activation_hook' );

// Activation notification
function hide_titles_activation_notification(){
    if( get_transient( 'hide-titles-notification' ) ) {
        ?>
        <div class="updated notice is-dismissible">
            <p><?php esc_attr_e( 'Thank you for installing Hide Titles!', 'hide-titles' ); ?></p>
        </div>
        <?php
        delete_transient( 'hide-titles-notification' );
    }
}
add_action( 'admin_notices', 'hide_titles_activation_notification' );
