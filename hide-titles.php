<?php

/**
 * Plugin Name:         MM Title Manager
 * Plugin URI:          https://wordpress.org/plugins/hide-titles/
 * Description:         Remove Titles from Posts and Single Pages on WordPress.
 * Version:             1.10
 * Requires at least:   4.4
 * Requires PHP:        5.6
 * Tested up to:        7.0
 * Author:              Mehraz Morshed
 * Author URI:          https://profiles.wordpress.org/mehrazmorshed/
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         hide-titles
 * Domain Path:         /languages
 */

/**
 * Hide Titles is free software: you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 
 * of the License, or (at your option) any later version.
 * 
 * Hide Titles is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
 * GNU General Public License for more details.
 * 
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

    add_menu_page( __( 'MM Title Manager', 'hide-titles' ), __( 'MM Title Manager', 'hide-titles' ), 'manage_options', 'hide-titles', 'hide_titles_create_page', 'dashicons-heading', 101 );
}
add_action( 'admin_menu', 'hide_titles_option_page' );

function hide_titles_style_settings( $hook_suffix ) {

    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen ) {
        return;
    }

    $screens = array( 'toplevel_page_hide-titles', 'post', 'page' );
    if ( ! in_array( $screen->id, $screens, true ) ) {
        return;
    }

    wp_enqueue_style( 'hide-titles-admin', plugins_url( 'css/hide-titles-settings.css', __FILE__ ), array(), '1.9.2' );
}
add_action( 'admin_enqueue_scripts', 'hide_titles_style_settings' );

function hide_titles_create_page() {
    $current = get_option( 'hide-titles-option', 'nothing' );
    ?>
    <div class="hide_titles_main">
        <div class="hide_titles_body hide_titles_common">
            <header class="ht-mm-hero">
                <p class="ht-mm-hero__eyebrow"><?php esc_html_e( 'MM Title Manager', 'hide-titles' ); ?></p>
                <h1 class="ht-mm-hero__title" id="page-title"><?php esc_html_e( 'Title visibility', 'hide-titles' ); ?></h1>
                <p class="ht-mm-hero__lead"><?php esc_html_e( 'Control titles on single posts and pages. Navigation menus always keep their labels.', 'hide-titles' ); ?></p>
            </header>

            <form class="ht-mm-form" action="options.php" method="post">
                <?php wp_nonce_field( 'update-options' ); ?>

                <fieldset class="ht-mm-fieldset">
                    <legend class="ht-mm-fieldset__legend"><?php esc_html_e( 'Global behavior', 'hide-titles' ); ?></legend>
                    <p class="ht-mm-fieldset__hint"><?php esc_html_e( 'Applies site-wide unless you override per post or page in the editor.', 'hide-titles' ); ?></p>

                    <div class="ht-mm-options">
                        <label class="ht-mm-card">
                            <input type="radio" name="hide-titles-option" id="hide-titles-option-nothing" value="nothing" <?php checked( $current, 'nothing' ); ?>>
                            <span class="ht-mm-card__icon dashicons dashicons-visibility" aria-hidden="true"></span>
                            <span class="ht-mm-card__text">
                                <strong class="ht-mm-card__title"><?php esc_html_e( 'Show all titles', 'hide-titles' ); ?></strong>
                                <span class="ht-mm-card__desc"><?php esc_html_e( 'Default WordPress title output everywhere.', 'hide-titles' ); ?></span>
                            </span>
                        </label>

                        <label class="ht-mm-card">
                            <input type="radio" name="hide-titles-option" id="hide-titles-option-all" value="all" <?php checked( $current, 'all' ); ?>>
                            <span class="ht-mm-card__icon dashicons dashicons-no-alt" aria-hidden="true"></span>
                            <span class="ht-mm-card__text">
                                <strong class="ht-mm-card__title"><?php esc_html_e( 'Hide all titles', 'hide-titles' ); ?></strong>
                                <span class="ht-mm-card__desc"><?php esc_html_e( 'Removes titles in templates; menus still show link text.', 'hide-titles' ); ?></span>
                            </span>
                        </label>
                    </div>
                </fieldset>

                <input type="hidden" name="action" value="update">
                <input type="hidden" name="page_options" value="hide-titles-option">

                <p class="ht-mm-actions">
                    <button type="submit" name="submit" class="button button-primary button-hero ht-mm-submit"><?php esc_html_e( 'Save changes', 'hide-titles' ); ?></button>
                </p>
            </form>

            <section class="ht-mm-tip" aria-labelledby="ht-mm-per-post-heading">
                <h2 id="ht-mm-per-post-heading" class="ht-mm-tip__title"><?php esc_html_e( 'Per post or page', 'hide-titles' ); ?></h2>
                <p class="ht-mm-tip__text"><?php esc_html_e( 'Edit any post or page and use the Hide Titles box in the sidebar to hide only that item’s title. Menu labels stay visible.', 'hide-titles' ); ?></p>
                <figure class="ht-mm-tip__figure">
                    <img class="screenshot" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'img/single.png' ); ?>" alt="">
                </figure>
            </section>
        </div>
        <div class="hide_titles_aside hide_titles_common">
            <!-- about plugin author -->
            <h2 class="aside-title"><?php esc_html_e( 'About Plugin Author', 'hide-titles' ); ?></h2>
            <div class="author-card">
                <a class="link" href="https://profiles.wordpress.org/mehrazmorshed/" target="_blank">
                    <img class="center" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'img/author.png' ); ?>" width="128" height="128" alt="">
                    <h3 class="author-title"><?php esc_html_e( 'Mehraz Morshed', 'hide-titles' ); ?></h3>
                    <h4 class="author-title"><?php esc_html_e( 'WordPress Developer', 'hide-titles' ); ?></h4>
                </a>
                <h1 class="author-title">
                    <a class="link" href="https://www.facebook.com/mehrazmorshed" target="_blank"><span class="dashicons dashicons-facebook"></span></a>
                    <a class="link" href="https://twitter.com/mehrazmorshed" target="_blank"><span class="dashicons dashicons-twitter"></span></a>
                    <a class="link" href="https://www.linkedin.com/in/mehrazmorshed" target="_blank"><span class="dashicons dashicons-linkedin"></span></a>
                    <a class="link" href="https://www.youtube.com/@mehrazmorshed" target="_blank"><span class="dashicons dashicons-youtube"></span></a>
                </h1>
            </div>
            <!-- other useful plugins -->
            <h3 class="aside-title"><?php esc_html_e( 'Other Useful Plugins', 'hide-titles' ); ?></h3>
            <div class="author-card">
                <a class="link" href="https://wordpress.org/plugins/turn-off-comments/" target="_blank">
                    <span class="dashicons dashicons-admin-plugins"></span> <b><?php _e( 'Disable Comments', 'hide-titles' ) ?></b>
                </a>
                <hr>
                <a class="link" href="https://wordpress.org/plugins/hide-admin-navbar/" target="_blank">
                    <span class="dashicons dashicons-admin-plugins"></span> <b><?php _e( 'Hide Admin Toolbar', 'hide-titles' ) ?></b>
                </a>
                <hr>
                <a class="link" href="https://wordpress.org/plugins/about-post-author/" target="_blank">
                    <span class="dashicons dashicons-admin-plugins"></span> <b><?php _e( 'Simple Author Box', 'hide-titles' ) ?></b>
                </a>
            </div>
            <!-- donate to this plugin -->
            <h3 class="aside-title"><?php esc_html_e( 'Support', 'hide-titles' ); ?></h3>
            <a class="link" href="https://www.buymeacoffee.com/mehrazmorshed" target="_blank" rel="noopener noreferrer">
                <button type="button" class="button button-primary btn"><?php esc_html_e( 'Donate to this plugin', 'hide-titles' ); ?></button>
            </a>
            <p class="ht-mm-or"><span><?php esc_html_e( 'or', 'hide-titles' ); ?></span></p>
            <a class="link" href="https://wordpress.org/support/plugin/hide-titles/reviews/#new-post" target="_blank" rel="noopener noreferrer">
                <button type="button" class="button button-secondary btn"><?php esc_html_e( 'Leave a review', 'hide-titles' ); ?></button>
            </a>
        </div>
    </div>
    
    <?php
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
/*********************************************************************/
add_action('add_meta_boxes', 'hide_titles_meta_box');
add_action('save_post', 'hide_titles_save_meta');
add_filter( 'the_title', 'hide_titles_filter_title', 10, 2 );
add_filter( 'nav_menu_item_title', 'hide_titles_restore_nav_menu_title', 10, 4 );

/**
 * Restore menu link text when titles are hidden via the_title.
 *
 * WordPress runs post titles through `the_title` when building menu items
 * (see wp_setup_nav_menu_item). Without this, hidden titles become blank
 * or “no title” in menus. We keep the stored navigation label or the raw
 * post title for display in menus only.
 *
 * @param string   $title     The menu item’s title.
 * @param object   $menu_item The menu item object.
 * @param stdClass $args      An object of wp_nav_menu() arguments.
 * @param int      $depth     Depth of menu item.
 * @return string
 */
function hide_titles_restore_nav_menu_title( $title, $menu_item, $args, $depth ) {

    if ( ! is_object( $menu_item ) || 'post_type' !== $menu_item->type || empty( $menu_item->object_id ) ) {
        return $title;
    }

    $object_id = (int) $menu_item->object_id;
    if ( $object_id < 1 ) {
        return $title;
    }

    $hide_globally = ( get_option( 'hide-titles-option' ) === 'all' );
    $hide_per_post = ( get_post_meta( $object_id, '_hide_title', true ) === 'on' );

    if ( ! $hide_globally && ! $hide_per_post ) {
        return $title;
    }

    if ( isset( $menu_item->post_title ) && '' !== $menu_item->post_title ) {
        return $menu_item->post_title;
    }

    $raw = get_post_field( 'post_title', $object_id, 'raw' );

    return ( is_string( $raw ) && '' !== $raw ) ? $raw : $title;
}

// Add meta box to hide title
function hide_titles_meta_box() {
    add_meta_box( 'hide-title-meta-box', __( 'MM Title Manager', 'hide-titles' ), 'hide_titles_meta_box_callback', array( 'post', 'page' ), 'side', 'default' );
}

// Meta box callback function
function hide_titles_meta_box_callback($post) {
    $value = get_post_meta($post->ID, '_hide_title', true);
    wp_nonce_field( 'hide_titles_meta_save', 'hide_titles_meta_nonce' );
    ?>
    <div class="ht-mm-meta">
        <label class="ht-mm-meta__toggle" for="hide-titles-checkbox">
            <input type="checkbox" id="hide-titles-checkbox" name="hide_titles_checkbox" <?php checked( $value, 'on' ); ?> />
            <span class="ht-mm-meta__label"><?php esc_html_e( 'Hide title on this page', 'hide-titles' ); ?></span>
        </label>
        <p class="ht-mm-meta__hint"><?php esc_html_e( 'Hides the title in the content area only. Navigation menus and the admin list keep their titles.', 'hide-titles' ); ?></p>
        <p class="ht-mm-meta__review"><a href="https://wordpress.org/support/plugin/hide-titles/reviews/#new-post" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Leave a review', 'hide-titles' ); ?></a></p>
    </div>
    <?php
}

// Save meta box data
function hide_titles_save_meta($post_id) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! isset( $_POST['hide_titles_meta_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['hide_titles_meta_nonce'] ), 'hide_titles_meta_save' ) ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( array_key_exists( 'hide_titles_checkbox', $_POST ) ) {
        update_post_meta( $post_id, '_hide_title', 'on' );
    } else {
        delete_post_meta( $post_id, '_hide_title' );
    }
}

// Filter the title to hide it
function hide_titles_filter_title($title, $id = null) {
    if (is_admin() || !$id) {
        return $title;
    }

    $hide_title = get_post_meta($id, '_hide_title', true);
    if ($hide_title === 'on') {
        return '';
    }

    return $title;
}





/**
 * Save installation datetime on plugin activation
 */
function hide_titles_activate() {
    // Check if the installation time is already saved
    $installed = get_option('hide_titles_installed');
    
    if (!$installed) {
        // Save current datetime if not already set
        update_option('hide_titles_installed', current_time('mysql'));
    }
}
register_activation_hook(__FILE__, 'hide_titles_activate');

/**
 * Clean up options on plugin uninstallation
 */
function hide_titles_uninstall() {
    delete_option('hide_titles_installed');
}
register_uninstall_hook(__FILE__, 'hide_titles_uninstall');

/**
 * Show migration notice for installations before Oct 30, 2025
 */
function ht_show_migration_notice() {
    // Only show if new plugin is not active
    if (is_plugin_active('daisy-titles/daisy-titles.php')) {
        return;
    }
    
    // Get installation date
    $install_date = get_option('hide_titles_installed');
    
    // Only show notice if:
    // 1. There is NO install date (new installation) OR
    // 2. Installation date is BEFORE Oct 30, 2025
    if ($install_date && strtotime($install_date) >= strtotime('2025-10-30')) {
        return;
    }
    
    // Get install/activate URLs
    $install_url = wp_nonce_url(
        add_query_arg([
            'action' => 'install-plugin',
            'plugin' => 'daisy-titles'
        ], admin_url('update.php')),
        'install-plugin_daisy-titles'
    );
    
    $activate_url = '';
    if (file_exists(WP_PLUGIN_DIR . '/daisy-titles/daisy-titles.php')) {
        $activate_url = wp_nonce_url(
            add_query_arg([
                'action' => 'activate',
                'plugin' => 'daisy-titles/daisy-titles.php'
            ], admin_url('plugins.php')),
            'activate-plugin_daisy-titles/daisy-titles.php'
        );
    }
    ?>
    <div class="notice notice-error">
        <h4><?php esc_html_e('Important Notice About Hide Titles', 'hide-titles'); ?></h4>
        <p>
            <?php _e('This plugin is no longer maintained. Please migrate to our new improved plugin <b style="color: blue;">"Daisy Titles"</b> for continued support, new features, and future updates.', 'hide-titles'); ?>
        </p>
        <p>
            <?php if ($activate_url) : ?>
                <a href="<?php echo esc_url($activate_url); ?>" class="button button-primary">
                    <?php esc_html_e('Activate Daisy Titles Now', 'hide-titles'); ?>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url($install_url); ?>" class="button button-primary">
                    <?php esc_html_e('Migrate to Daisy Titles Now', 'hide-titles'); ?>
                </a>
            <?php endif; ?>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'ht_show_migration_notice');