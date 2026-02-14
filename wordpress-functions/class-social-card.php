<?php
/*
    Plugin Name: Socials Custom Post Type
    Description: Creates a custom post type for social media links with categories
    Version: 1.0
    Author: KFlamsted
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Social Card Post Type Class
 */
class Social_Card_Post_Type {

    /**
     * Post type slug
     */
    const POST_TYPE = 'social-card';

    /**
     * Taxonomy slug
     */
    const TAXONOMY = 'social_platform';

    /**
     * Meta keys
     */
    const META_HANDLE = '_social_handle';
    const META_URL = '_social_url';

    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomy'));
        add_action('init', array($this, 'add_platform_terms'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_data'));
        add_action('rest_api_init', array($this, 'register_rest_fields'));
    }

    /**
     * Register social-card post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x('Social Cards', 'Post type general name', 'social-card'),
            'singular_name'         => _x('Social Card', 'Post type singular name', 'social-card'),
            'menu_name'            => _x('Social Cards', 'Admin Menu text', 'social-card'),
            'name_admin_bar'       => _x('Social Card', 'Add New on Toolbar', 'social-card'),
            'add_new'              => __('Add New', 'social-card'),
            'add_new_item'         => __('Add New Social Card', 'social-card'),
            'new_item'             => __('New Social Card', 'social-card'),
            'edit_item'            => __('Edit Social Card', 'social-card'),
            'view_item'            => __('View Social Card', 'social-card'),
            'all_items'            => __('All Social Cards', 'social-card'),
            'search_items'         => __('Search Social Cards', 'social-card'),
            'parent_item_colon'    => __('Parent Social Cards:', 'social-card'),
            'not_found'            => __('No social cards found.', 'social-card'),
            'not_found_in_trash'   => __('No social cards found in Trash.', 'social-card'),
            'featured_image'        => _x('Social Card Thumbnail', 'Overrides the "Featured Image" phrase for this post type.', 'social-card'),
            'set_featured_image'    => _x('Set thumbnail', 'Overrides the "Set featured image" phrase for this post type.', 'social-card'),
            'remove_featured_image' => _x('Remove thumbnail', 'Overrides the "Remove featured image" phrase for this post type.', 'social-card'),
            'use_featured_image'    => _x('Use as thumbnail', 'Overrides the "Use as featured image" phrase for this post type.', 'social-card'),
            'archives'              => _x('Social Card archives', 'The post type archive label used in nav menus.', 'social-card'),
            'insert_into_item'      => _x('Insert into social card', 'Overrides the "Insert into post" phrase.', 'social-card'),
            'uploaded_to_this_item' => _x('Uploaded to this social card', 'Overrides the "Uploaded to this post" phrase.', 'social-card'),
            'filter_items_list'     => _x('Filter social cards list', 'Screen reader text for the filter links heading on the post type listing screen.', 'social-card'),
            'items_list_navigation' => _x('Social cards list navigation', 'Screen reader text for the pagination heading on the post type listing screen.', 'social-card'),
            'items_list'           => _x('Social cards list', 'Screen reader text for the items list heading on the post type listing screen.', 'social-card'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-share',
            'menu_position'      => 5,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'social-card'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array('title', 'thumbnail'),
            'show_in_rest'       => true,
            'rest_base'          => 'social-card',
            'taxonomies'         => array(self::TAXONOMY),
        );

        register_post_type(self::POST_TYPE, $args);
    }

    /**
     * Register social_platform taxonomy
     */
    public function register_taxonomy() {
        $labels = array(
            'name'                       => _x('Social Platforms', 'Taxonomy general name', 'social-card'),
            'singular_name'              => _x('Social Platform', 'Taxonomy singular name', 'social-card'),
            'search_items'               => __('Search Social Platforms', 'social-card'),
            'all_items'                  => __('All Social Platforms', 'social-card'),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __('Edit Social Platform', 'social-card'),
            'update_item'                => __('Update Social Platform', 'social-card'),
            'add_new_item'               => __('Add New Social Platform', 'social-card'),
            'new_item_name'              => __('New Social Platform Name', 'social-card'),
            'menu_name'                  => __('Social Platforms', 'social-card'),
            'view_item'                  => __('View Social Platform', 'social-card'),
            'popular_items'              => __('Popular Social Platforms', 'social-card'),
            'separate_items_with_commas' => __('Separate social platforms with commas', 'social-card'),
            'add_or_remove_items'        => __('Add or remove social platforms', 'social-card'),
            'choose_from_most_used'      => __('Choose from the most used social platforms', 'social-card'),
            'not_found'                  => __('No social platforms found.', 'social-card'),
            'no_terms'                   => __('No social platforms', 'social-card'),
            'items_list_navigation'      => __('Social platforms list navigation', 'social-card'),
            'items_list'                 => __('Social platforms list', 'social-card'),
            'back_to_items'              => __('&larr; Back to Social Platforms', 'social-card'),
        );

        $args = array(
            'labels'            => $labels,
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => false,
            'show_in_rest'      => true,
            'rest_base'         => 'social-platform',
        );

        register_taxonomy(self::TAXONOMY, array(self::POST_TYPE), $args);
    }

    /**
     * Pre-populate platform taxonomy with available options
     */
    public function add_platform_terms() {
        $platforms = array(
            'YOUTUBE',
            'BLUESKY',
            'TWITCH',
            'TWITTER',
            'INSTAGRAM',
            'FACEBOOK',
            'TIKTOK',
            'DISCORD',
            'KICK',
        );

        // Check if taxonomy is registered
        if (!taxonomy_exists(self::TAXONOMY)) {
            return;
        }

        foreach ($platforms as $platform) {
            if (!term_exists($platform, self::TAXONOMY)) {
                wp_insert_term($platform, self::TAXONOMY, array(
                    'slug' => strtolower($platform),
                ));
            }
        }
    }

    /**
     * Add meta boxes for social card fields
     */
    public function add_meta_boxes() {
        add_meta_box(
            'social_card_details',
            __('Social Card Details', 'social-card'),
            array($this, 'render_meta_box'),
            self::POST_TYPE,
            'normal',
            'high'
        );
    }

    /**
     * Render meta box content
     */
    public function render_meta_box($post) {
        // Add nonce for security
        wp_nonce_field('social_card_meta_box', 'social_card_meta_box_nonce');

        // Get current values
        $handle = get_post_meta($post->ID, self::META_HANDLE, true);
        $url = get_post_meta($post->ID, self::META_URL, true);

        // Get current platform
        $current_platforms = wp_get_post_terms($post->ID, self::TAXONOMY, array('fields' => 'ids'));
        $current_platform = !empty($current_platforms) ? $current_platforms[0] : 0;

        // Get all platforms
        $platforms = get_terms(array(
            'taxonomy'   => self::TAXONOMY,
            'hide_empty' => false,
        ));

        // Platform select
        echo '<p>';
        echo '<label for="social_platform" style="display:block;font-weight:bold;margin-bottom:5px;">';
        echo esc_html__('Platform:', 'social-card');
        echo '</label>';
        echo '<select name="social_platform" id="social_platform" style="width:100%;">';
        echo '<option value="">' . esc_html__('Select a platform', 'social-card') . '</option>';
        foreach ($platforms as $platform) {
            printf(
                '<option value="%d" %s>%s</option>',
                esc_attr($platform->term_id),
                selected($current_platform, $platform->term_id, false),
                esc_html($platform->name)
            );
        }
        echo '</select>';
        echo '</p>';

        // Handle input
        echo '<p>';
        echo '<label for="social_handle" style="display:block;font-weight:bold;margin-bottom:5px;">';
        echo esc_html__('Handle:', 'social-card');
        echo '</label>';
        echo '<input type="text" id="social_handle" name="social_handle" value="';
        echo esc_attr($handle);
        echo '" style="width:100%;" placeholder="@username">';
        echo '</p>';

        // URL input
        echo '<p>';
        echo '<label for="social_url" style="display:block;font-weight:bold;margin-bottom:5px;">';
        echo esc_html__('URL:', 'social-card');
        echo '</label>';
        echo '<input type="url" id="social_url" name="social_url" value="';
        echo esc_attr($url);
        echo '" style="width:100%;" placeholder="https://...">';
        echo '</p>';
    }

    /**
     * Save meta data when the post is saved
     */
    public function save_meta_data($post_id) {
        // Check if our nonce is set
        if (!isset($_POST['social_card_meta_box_nonce'])) {
            return;
        }

        // Verify that the nonce is valid
        if (!wp_verify_nonce($_POST['social_card_meta_box_nonce'], 'social_card_meta_box')) {
            return;
        }

        // If this is an autosave, don't do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions
        if (isset($_POST['post_type']) && self::POST_TYPE === $_POST['post_type']) {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        } else {
            return;
        }

        // Save Platform Taxonomy
        if (isset($_POST['social_platform'])) {
            $platform_id = intval($_POST['social_platform']);
            if ($platform_id > 0) {
                wp_set_post_terms($post_id, array($platform_id), self::TAXONOMY);
            } else {
                wp_set_post_terms($post_id, array(), self::TAXONOMY);
            }
        }

        // Save Handle
        if (isset($_POST['social_handle'])) {
            $handle = sanitize_text_field($_POST['social_handle']);
            update_post_meta($post_id, self::META_HANDLE, $handle);
        }

        // Save URL
        if (isset($_POST['social_url'])) {
            $url = esc_url_raw($_POST['social_url']);
            update_post_meta($post_id, self::META_URL, $url);
        }
    }

    /**
     * Register REST API fields
     */
    public function register_rest_fields() {
        // Register handle field
        register_rest_field(
            self::POST_TYPE,
            'handle',
            array(
                'get_callback'    => array($this, 'get_handle_field'),
                'update_callback' => array($this, 'update_handle_field'),
                'schema'          => array(
                    'description' => __('Social media handle', 'social-card'),
                    'type'        => 'string',
                    'context'     => array('view', 'edit'),
                ),
            )
        );

        // Register URL field
        register_rest_field(
            self::POST_TYPE,
            'url',
            array(
                'get_callback'    => array($this, 'get_url_field'),
                'update_callback' => array($this, 'update_url_field'),
                'schema'          => array(
                    'description' => __('Social media profile URL', 'social-card'),
                    'type'        => 'string',
                    'format'        => 'uri',
                    'context'       => array('view', 'edit'),
                ),
            )
        );

        // Register platform field
        register_rest_field(
            self::POST_TYPE,
            'platform',
            array(
                'get_callback'    => array($this, 'get_platform_field'),
                'update_callback' => array($this, 'update_platform_field'),
                'schema'          => array(
                    'description' => __('Social media platform', 'social-card'),
                    'type'        => 'string',
                    'enum'        => array('YOUTUBE', 'BLUESKY', 'TWITCH', 'TWITTER', 'INSTAGRAM', 'FACEBOOK', 'TIKTOK', 'DISCORD', 'KICK'),
                    'context'       => array('view', 'edit'),
                ),
            )
        );
    }

    /**
     * Get handle field for REST API
     */
    public function get_handle_field($object) {
        $post_id = $object['id'];
        return get_post_meta($post_id, self::META_HANDLE, true);
    }

    /**
     * Update handle field via REST API
     */
    public function update_handle_field($value, $object) {
        $post_id = $object->ID;
        update_post_meta($post_id, self::META_HANDLE, sanitize_text_field($value));
        return true;
    }

    /**
     * Get URL field for REST API
     */
    public function get_url_field($object) {
        $post_id = $object['id'];
        return get_post_meta($post_id, self::META_URL, true);
    }

    /**
     * Update URL field via REST API
     */
    public function update_url_field($value, $object) {
        $post_id = $object->ID;
        update_post_meta($post_id, self::META_URL, esc_url_raw($value));
        return true;
    }

    /**
     * Get platform field for REST API
     */
    public function get_platform_field($object) {
        $post_id = $object['id'];
        $terms = wp_get_post_terms($post_id, self::TAXONOMY, array('fields' => 'names'));
        
        if (is_wp_error($terms) || empty($terms)) {
            return null;
        }
        
        return $terms[0]; // Return first (and only) platform
    }

    /**
     * Update platform field via REST API
     */
    public function update_platform_field($value, $object) {
        $post_id = $object->ID;
        
        // Find the term by name
        $term = get_term_by('name', $value, self::TAXONOMY);
        
        if ($term) {
            wp_set_post_terms($post_id, array($term->term_id), self::TAXONOMY);
            return true;
        }
        
        return false;
    }
}

// Initialize the class
new Social_Card_Post_Type();
