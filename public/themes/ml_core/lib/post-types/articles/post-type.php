<?php

if ( ! function_exists('article_post_type') ) {

    // Register Custom Post Type
    function article_post_type() {

        $labels = array(
            'name'                  => _x( 'Articles', 'Post Type General Name', 'maxliving' ),
            'singular_name'         => _x( 'Article', 'Post Type Singular Name', 'maxliving' ),
            'menu_name'             => __( 'Articles', 'maxliving' ),
            'name_admin_bar'        => __( 'Articles', 'maxliving' ),
            'archives'              => __( 'Articles Archives', 'maxliving' ),
            'attributes'            => __( 'Articles Attributes', 'maxliving' ),
            'parent_item_colon'     => __( 'Parent Articles:', 'maxliving' ),
            'all_items'             => __( 'All Articles', 'maxliving' ),
            'add_new_item'          => __( 'Add Article', 'maxliving' ),
            'add_new'               => __( 'Add Article', 'maxliving' ),
            'new_item'              => __( 'New Article', 'maxliving' ),
            'edit_item'             => __( 'Edit Article', 'maxliving' ),
            'update_item'           => __( 'Update Article', 'maxliving' ),
            'view_item'             => __( 'View Article', 'maxliving' ),
            'view_items'            => __( 'View Articles', 'maxliving' ),
            'search_items'          => __( 'Search Article', 'maxliving' ),
            'not_found'             => __( 'Not found', 'maxliving' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'maxliving' ),
            'featured_image'        => __( 'Featured Image', 'maxliving' ),
            'set_featured_image'    => __( 'Set featured image', 'maxliving' ),
            'remove_featured_image' => __( 'Remove featured image', 'maxliving' ),
            'use_featured_image'    => __( 'Use as featured image', 'maxliving' ),
            'insert_into_item'      => __( 'Insert into article', 'maxliving' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Article', 'maxliving' ),
            'items_list'            => __( 'Articles list', 'maxliving' ),
            'items_list_navigation' => __( 'Articles list navigation', 'maxliving' ),
            'filter_items_list'     => __( 'Filter Articles list', 'maxliving' ),
        );
        $rewrite = array(
            'slug'                  => 'healthy-articles',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $taxonomies = array();
        $supports = array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields' );

        if (get_current_blog_id() == 1) {
            $taxonomies = array('article_categories');
            $supports = array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields' );
        }

        $meta = 'add_metaboxes';
        if(get_option('stylesheet') === 'ml_whitelabel') {
            $meta = '';
        }

        $args = array(
            'label'                 => __( 'Articles', 'maxliving' ),
            'description'           => __( 'Articles', 'maxliving' ),
            'labels'                => $labels,
            'supports'              => $supports,
            'taxonomies'            => $taxonomies,
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 13,
            'menu_icon'             => 'dashicons-media-document',
            'register_meta_box_cb' => $meta,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => array('article', 'articles'),
            'map_meta_cap'          => true,
            'show_in_rest'          => true,
        );
        register_post_type( 'article', $args );
    }
    add_action( 'init', 'article_post_type', 0 );

}
