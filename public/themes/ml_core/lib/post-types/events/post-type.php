<?php

if ( ! function_exists('event_post_type') ) {

    // Register Custom Post Type
    function event_post_type() {

        $labels = array(
            'name'                  => _x( 'Events', 'Post Type General Name', 'maxliving' ),
            'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'maxliving' ),
            'menu_name'             => __( 'Events', 'maxliving' ),
            'name_admin_bar'        => __( 'Events', 'maxliving' ),
            'archives'              => __( 'Event Archives', 'maxliving' ),
            'attributes'            => __( 'Event Attributes', 'maxliving' ),
            'parent_item_colon'     => __( 'Parent Event:', 'maxliving' ),
            'all_items'             => __( 'All Events', 'maxliving' ),
            'add_new_item'          => __( 'Add Event', 'maxliving' ),
            'add_new'               => __( 'Add Event', 'maxliving' ),
            'new_item'              => __( 'New Event', 'maxliving' ),
            'edit_item'             => __( 'Edit Event', 'maxliving' ),
            'update_item'           => __( 'Update Event', 'maxliving' ),
            'view_item'             => __( 'View Event', 'maxliving' ),
            'view_items'            => __( 'View Events', 'maxliving' ),
            'search_items'          => __( 'Search Event', 'maxliving' ),
            'not_found'             => __( 'Not found', 'maxliving' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'maxliving' ),
            'featured_image'        => __( 'Featured Image', 'maxliving' ),
            'set_featured_image'    => __( 'Set featured image', 'maxliving' ),
            'remove_featured_image' => __( 'Remove featured image', 'maxliving' ),
            'use_featured_image'    => __( 'Use as featured image', 'maxliving' ),
            'insert_into_item'      => __( 'Insert into event', 'maxliving' ),
            'uploaded_to_this_item' => __( 'Uploaded to this event', 'maxliving' ),
            'items_list'            => __( 'Events list', 'maxliving' ),
            'items_list_navigation' => __( 'Events list navigation', 'maxliving' ),
            'filter_items_list'     => __( 'Filter events list', 'maxliving' ),
        );
        $rewrite = array(
            'slug'                  => 'events',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );

        $taxonomies = array();
        $supports = array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' );

        if (get_current_blog_id() == 1) {
            $taxonomies = array('event_categories');
            $supports = array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields' );
        }

        $args = array(
            'label'                 => __( 'Event', 'maxliving' ),
            'description'           => __( 'Events', 'maxliving' ),
            'labels'                => $labels,
            'supports'              => $supports,
            'taxonomies'            => $taxonomies,
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 12,
            'menu_icon'             => 'dashicons-calendar-alt',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => array('event', 'events'),
            'map_meta_cap'          => true,
            'show_in_rest'          => true,
        );
        register_post_type( 'event', $args );
    }
    add_action( 'init', 'event_post_type', 0 );

}
