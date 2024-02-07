<?php

add_action('add_meta_boxes', 'hide_titles_meta_box');
add_action('save_post', 'hide_titles_save_meta');
add_filter('the_title', 'hide_titles_filter_title', 10, 2);

// Add meta box to hide title
function hide_titles_meta_box() {
    add_meta_box('hide-title-meta-box', 'Hide Titles', 'hide_titles_meta_box_callback', ['post', 'page'], 'side', 'default');
}

// Meta box callback function
function hide_titles_meta_box_callback($post) {
    $value = get_post_meta($post->ID, '_hide_title', true);
    ?>
    <label for="hide-titles-checkbox">
        <input type="checkbox" id="hide-titles-checkbox" name="hide_titles_checkbox" <?php checked($value, 'on'); ?> />
        Hide The Title
    </label>
    <br><br>
    <p><small>This option comes from the <b>Hide Titles</b> plugin. <a href="https://wordpress.org/support/plugin/hide-titles/reviews/?filter=5#new-post"><strong>Please consider leaving a review</strong></a> to share your experience with us.</small></p>
    <?php
}

// Save meta box data
function hide_titles_save_meta($post_id) {
    if (array_key_exists('hide_titles_checkbox', $_POST)) {
        update_post_meta($post_id, '_hide_title', 'on');
    } else {
        delete_post_meta($post_id, '_hide_title');
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
