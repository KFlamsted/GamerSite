<?php
/*
Plugin Name: Socials Custom Post Type
Description: Creates a custom post type for social media links with categories
Version: 1.0
Author: Kristian Flamsted aka. Novaz
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Socials_Post_Type {
    public function __construct() {
        // Register hooks
        add_action('init', array($this, 'create_social_categories_taxonomy'));
        add_action('init', array($this, 'create_socials_post_type'));
        add_action('add_meta_boxes', array($this, 'add_social_url_meta_box'));
        add_action('save_post', array($this, 'save_social_url_meta_data'));
    }

    /**
     * Create custom taxonomy for social categories
     */
    public function create_social_categories_taxonomy() {
        $labels = array(
            'name'              => _x('Social Categories', 'taxonomy general name', 'socials-post-type'),
            'singular_name'     => _x('Social Category', 'taxonomy singular name', 'socials-post-type'),
            'search_items'      => __('Search Social Categories', 'socials-post-type'),
            'all_items'         => __('All Social Categories', 'socials-post-type'),
            'parent_item'       => __('Parent Social Category', 'socials-post-type'),
            'parent_item_colon' => __('Parent Social Category:', 'socials-post-type'),
            'edit_item'         => __('Edit Social Category', 'socials-post-type'),
            'update_item'       => __('Update Social Category', 'socials-post-type'),
            'add_new_item'      => __('Add New Social Category', 'socials-post-type'),
            'new_item_name'     => __('New Social Category Name', 'socials-post-type'),
            'menu_name'         => __('Social Categories', 'socials-post-type'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'social-category'),
        );

        register_taxonomy('social_categories', array('socials'), $args);
    }

    /**
     * Create custom post type for socials
     */
    public function create_socials_post_type() {
        $labels = array(
            'name'                  => _x('Socials', 'Post Type General Name', 'socials-post-type'),
            'singular_name'         => _x('Social', 'Post Type Singular Name', 'socials-post-type'),
            'menu_name'             => __('Socials', 'socials-post-type'),
            'name_admin_bar'        => __('Social', 'socials-post-type'),
            'archives'              => __('Social Archives', 'socials-post-type'),
            'attributes'            => __('Social Attributes', 'socials-post-type'),
            'parent_item_colon'     => __('Parent Social:', 'socials-post-type'),
            'all_items'             => __('All Socials', 'socials-post-type'),
            'add_new_item'          => __('Add New Social', 'socials-post-type'),
            'add_new'               => __('Add New', 'socials-post-type'),
            'new_item'              => __('New Social', 'socials-post-type'),
            'edit_item'             => __('Edit Social', 'socials-post-type'),
            'update_item'           => __('Update Social', 'socials-post-type'),
            'view_item'             => __('View Social', 'socials-post-type'),
            'view_items'            => __('View Socials', 'socials-post-type'),
            'search_items'          => __('Search Social', 'socials-post-type'),
            'not_found'             => __('Not found', 'socials-post-type'),
            'not_found_in_trash'    => __('Not found in Trash', 'socials-post-type'),
            'featured_image'        => __('Social Thumbnail', 'socials-post-type'),
            'set_featured_image'    => __('Set social thumbnail', 'socials-post-type'),
            'remove_featured_image' => __('Remove social thumbnail', 'socials-post-type'),
            'use_featured_image'    => __('Use as social thumbnail', 'socials-post-type'),
            'insert_into_item'      => __('Insert into social', 'socials-post-type'),
            'uploaded_to_this_item' => __('Uploaded to this social', 'socials-post-type'),
            'items_list'            => __('Socials list', 'socials-post-type'),
            'items_list_navigation' => __('Socials list navigation', 'socials-post-type'),
            'filter_items_list'     => __('Filter socials list', 'socials-post-type'),
        );

        $args = array(
            'label'                 => __('Social', 'socials-post-type'),
            'description'           => __('Social media links and profiles', 'socials-post-type'),
            'labels'                => $labels,
            'supports'              => array('title', 'thumbnail'),
            'taxonomies'            => array('social_categories'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-share',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );

        register_post_type('socials', $args);
    }

    /**
     * Add meta box for social URL
     */
    public function add_social_url_meta_box() {
        add_meta_box(
            'social_url_meta_box',
            __('Social URL', 'socials-post-type'),
            array($this, 'render_social_url_meta_box'),
            'socials',
            'normal',
            'high'
        );
    }

    /**
     * Render social URL meta box
     */
    public function render_social_url_meta_box($post) {
        // Add nonce for security
        wp_nonce_field('social_url_nonce', 'social_url_nonce_field');

        // Get existing URL
        $social_url = get_post_meta($post->ID, '_social_url', true);

        echo '<div class="social-url-meta-box">';
        echo '<label for="social_url">' . __('Social Media URL:', 'socials-post-type') . '</label>';
        echo '<input type="url" id="social_url" name="social_url" value="' . esc_attr($social_url) . '" size="50" />';
        echo '<p class="description">' . __('Enter the full URL to the social media profile or page', 'socials-post-type') . '</p>';
        echo '</div>';
    }

    /**
     * Save social URL meta data
     */
    public function save_social_url_meta_data($post_id) {
        // Verify nonce
        if (!isset($_POST['social_url_nonce_field']) || !wp_verify_nonce($_POST['social_url_nonce_field'], 'social_url_nonce')) {
            return;
        }

        // Check if this is an autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check user permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save the URL
        if (isset($_POST['social_url'])) {
            update_post_meta($post_id, '_social_url', esc_url_raw($_POST['social_url']));
        }
    }
}

// Initialize the plugin
new Socials_Post_Type();
