<?php

if ( ! function_exists('press_post_type') ) {

// Register Custom Post Type
    function press_post_type() {

        $labels = array(
            'name'                  => _x( 'Press &amp; Media', 'Post Type General Name', 'maxliving' ),
            'singular_name'         => _x( 'Press &amp; Media', 'Post Type Singular Name', 'maxliving' ),
            'menu_name'             => __( 'Press &amp; Media', 'maxliving' ),
            'name_admin_bar'        => __( 'Press &amp; Media', 'maxliving' ),
            'archives'              => __( 'Press &amp; Media Release Archives', 'maxliving' ),
            'attributes'            => __( 'Press &amp; Media Release Attributes', 'maxliving' ),
            'parent_item_colon'     => __( 'Parent Press & Media Release:', 'maxliving' ),
            'all_items'             => __( 'All Press &amp; Media Releases', 'maxliving' ),
            'add_new_item'          => __( 'Add Press &amp; Media Release', 'maxliving' ),
            'add_new'               => __( 'Add Press &amp; Media Release', 'maxliving' ),
            'new_item'              => __( 'New Press &amp; Media Release', 'maxliving' ),
            'edit_item'             => __( 'Edit Press &amp; Media Release', 'maxliving' ),
            'update_item'           => __( 'Update Press &amp; Media Release', 'maxliving' ),
            'view_item'             => __( 'View Press &amp; Media Release', 'maxliving' ),
            'view_items'            => __( 'View Press &amp; Media Releases', 'maxliving' ),
            'search_items'          => __( 'Search Press &amp; Media Release', 'maxliving' ),
            'not_found'             => __( 'Not found', 'maxliving' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'maxliving' ),
            'featured_image'        => __( 'Featured Image', 'maxliving' ),
            'set_featured_image'    => __( 'Set featured image', 'maxliving' ),
            'remove_featured_image' => __( 'Remove featured image', 'maxliving' ),
            'use_featured_image'    => __( 'Use as featured image', 'maxliving' ),
            'insert_into_item'      => __( 'Insert into press-release', 'maxliving' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Press Release', 'maxliving' ),
            'items_list'            => __( 'Press &amp; Media Releases list', 'maxliving' ),
            'items_list_navigation' => __( 'Press &amp; Media Releases list navigation', 'maxliving' ),
            'filter_items_list'     => __( 'Filter Press &amp; Media Releases list', 'maxliving' ),
        );
        $rewrite = array(
            'slug'                  => 'press-media',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => __( 'Press &amp; Media', 'maxliving' ),
            'description'           => __( 'Press &amp; Media', 'maxliving' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', ),
            'taxonomies'            => array(),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 14,
            'menu_icon'             => 'dashicons-megaphone',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => array('press','presss'),
            'map_meta_cap'          => true,
            'show_in_rest'          => true,
        );
        register_post_type( 'press', $args );

    }
    add_action( 'init', 'press_post_type', 0 );

}
