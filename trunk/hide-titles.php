<?php

/**
 * Plugin Name:         Hide Page and Post Title
 * Plugin URI:          https://wordpress.org/plugins/hide-titles/
 * Description:         Hide Titles from all Posts and Pages of your Website.
 * Version:             1.4
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
 * Hide Page and Post Titles is free software: you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your 
 * option) any later version.
 * 
 * Hide Page and Post Titles is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * this program.  If not, see <https://www.gnu.org/licenses/>.
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

    add_menu_page( 'Hide Page and Post Titles Option', 'Hide Page and Post Titles', 'manage_options', 'hide-titles', 'hide_titles_create_page', 'dashicons-admin-plugins', 101 );
}
add_action( 'admin_menu', 'hide_titles_option_page' );

function hide_titles_style_settings() {

    wp_enqueue_style( 'hide-titles-settings', plugins_url( 'css/hide-titles-settings.css', __FILE__ ), false, "1.0.0" );
}
add_action( 'admin_enqueue_scripts', 'hide_titles_style_settings' );

function hide_titles_create_page() {
    ?>
    <div class="hide_titles_main">
        <div class="hide_titles_body hide_titles_common">
            <h1 id="page-title"><?php esc_attr_e( 'Settings', 'hide-titles' ); ?></h1>
            <form action="options.php" method="post">
                <?php wp_nonce_field( 'update-options' ); ?>

                <!-- Hide Titles -->
                <label for="hide-titles-option"><?php esc_attr_e( 'Hide Titles Option', 'hide-titles' ); ?></label>

                <label class="radios">
                    <input type="radio" name="hide-titles-option" id="hide-titles-option-nothing" value="nothing" <?php if( get_option( 'hide-titles-option' ) == 'nothing' ) { echo 'checked="checked"'; } ?>>
                    <span><?php _e( 'Don\'t Hide Any Title', 'hide-titles' ); ?></span>
                </label>

                <label class="radios">
                    <input type="radio" name="hide-titles-option" id="hide-titles-option-posts" value="posts" <?php if( get_option( 'hide-titles-option' ) == 'posts' ) { echo 'checked="checked"'; } ?>>
                    <span><?php _e( 'Hide All Post Titles', 'hide-titles' ); ?></span>
                </label>

                <label class="radios">
                    <input type="radio" name="hide-titles-option" id="hide-titles-option-pages" value="pages" <?php if( get_option( 'hide-titles-option' ) == 'pages' ) { echo 'checked="checked"'; } ?>>
                    <span><?php _e( 'Hide All Page Titles', 'hide-titles' ); ?></span>
                </label>

                <label class="radios">
                    <input type="radio" name="hide-titles-option" id="hide-titles-option-all" value="all" <?php if( get_option( 'hide-titles-option' ) == 'all' ) { echo 'checked="checked"'; } ?>>
                    <span><?php _e( 'Hide Page and Post Titles', 'hide-titles' ); ?></span>
                </label>

                <!--  -->
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="page_options" value="hide-titles-option">
                <br>
                <input class="button button-primary" type="submit" name="submit" value="<?php _e( 'Save Changes', 'hide-titles' ) ?>">
            </form>
        </div>
        <div class="hide_titles_aside hide_titles_common">
            <!-- about plugin author -->
            <h2 class="aside-title"><?php esc_attr_e( 'About Plugin Author', 'hide-titles' ); ?></h2>
            <div class="author-card">
                <a class="link" href="https://profiles.wordpress.org/mehrazmorshed/" target="_blank">
                    <img class="center" src="<?php print plugin_dir_url( __FILE__ ) . '/img/author.png'; ?>" width="128px">
                    <h3 class="author-title"><?php esc_attr_e( 'Mehraz Morshed', 'hide-titles' ); ?></h3>
                    <h4 class="author-title"><?php esc_attr_e( 'WordPress Developer', 'hide-titles' ); ?></h4>
                </a>
                <h1 class="author-title">
                    <a class="link" href="https://www.facebook.com/mehrazmorshed" target="_blank"><span class="dashicons dashicons-facebook"></span></a>
                    <a class="link" href="https://twitter.com/mehrazmorshed" target="_blank"><span class="dashicons dashicons-twitter"></span></a>
                    <a class="link" href="https://www.linkedin.com/in/mehrazmorshed" target="_blank"><span class="dashicons dashicons-linkedin"></span></a>
                    <a class="link" href="https://www.youtube.com/@mehrazmorshed" target="_blank"><span class="dashicons dashicons-youtube"></span></a>
                </h1>
            </div>
            <!-- other useful plugins -->
            <h3 class="aside-title"><?php esc_attr_e( 'Other Useful Plugins', 'hide-titles' ); ?></h3>
            <div class="author-card">
                <a class="link" href="https://wordpress.org/plugins/turn-off-comments/" target="_blank">
                    <span class="dashicons dashicons-admin-plugins"></span> <b><?php _e( 'Turn Off Comments', 'hide-titles' ) ?></b>
                </a>
                <hr>
                <a class="link" href="https://wordpress.org/plugins/hide-admin-navbar/" target="_blank">
                    <span class="dashicons dashicons-admin-plugins"></span> <b><?php _e( 'Hide Admin Navbar', 'hide-titles' ) ?></b>
                </a>
                <hr>
                <a class="link" href="https://wordpress.org/plugins/tap-to-top/" target="_blank">
                    <span class="dashicons dashicons-admin-plugins"></span> <b><?php _e( 'Tap To Top', 'hide-titles' ) ?></b>
                </a>
                <hr>
                <a class="link" href="https://wordpress.org/plugins/customized-login/" target="_blank">
                    <span class="dashicons dashicons-admin-plugins"></span> <b><?php _e( 'Custom Login Page', 'hide-titles' ) ?></b>
                </a>
            </div>
            <!-- donate to this plugin -->
            <h3 class="aside-title"><?php esc_attr_e( 'Hide Titles', 'hide-titles' ); ?></h3>
            <a class="link" href="https://www.buymeacoffee.com/mehrazmorshed" target="_blank">
                <button class="button button-primary btn"><?php esc_attr_e( 'Donate To This Plugin', 'hide-titles' ); ?></button>
            </a>
        </div>
    </div>
    <?php
}

if( get_option( 'hide-titles-option' ) == 'posts' ) {

    function hide_post_titles(){

        ?>
        <style>
            .post .entry-title {
                display: none;
            }
        </style>
        <?php
    }
    add_action( 'wp_head', 'hide_post_titles' );
}

if( get_option( 'hide-titles-option' ) == 'pages' ) {

    function hide_page_titles(){

        ?>
        <style>
            .page .entry-title {
                display: none;
            }
        </style>
        <?php
    }
    add_action( 'wp_head', 'hide_page_titles' );
}

if( get_option( 'hide-titles-option' ) == 'all' ) {

    function hide_titles() {

        return false;
    }
    add_filter('the_title', 'hide_titles');
}

function hide_titles_plugin_activation() {

    add_option( 'hide_titles_plugin_do_activation_redirect', true );
}
register_activation_hook( __FILE__, 'hide_titles_plugin_activation' );

function hide_titles_plugin_redirect() {

    if( get_option( 'hide_titles_plugin_do_activation_redirect', false ) ) {

        delete_option( 'hide_titles_plugin_do_activation_redirect' );

        if ( !isset( $_GET['active-multi'] ) ) {

            wp_safe_redirect( admin_url( 'admin.php?page=hide-titles' ) );
            exit;
        }
    }
}
add_action( 'admin_init', 'hide_titles_plugin_redirect' );
