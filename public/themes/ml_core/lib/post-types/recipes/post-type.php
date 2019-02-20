<?php

if ( ! function_exists('recipe_post_type') ) {

    // Register Custom Post Type
    function recipe_post_type() {
        $labels = array(
            'name'                  => _x( 'Recipes', 'Post Type General Name', 'maxliving' ),
            'singular_name'         => _x( 'Recipe', 'Post Type Singular Name', 'maxliving' ),
            'menu_name'             => __( 'Recipes', 'maxliving' ),
            'name_admin_bar'        => __( 'Recipes', 'maxliving' ),
            'archives'              => __( 'Recipe Archives', 'maxliving' ),
            'attributes'            => __( 'Recipe Attributes', 'maxliving' ),
            'parent_item_colon'     => __( 'Parent Recipe:', 'maxliving' ),
            'all_items'             => __( 'All Recipes', 'maxliving' ),
            'add_new_item'          => __( 'Add Recipe', 'maxliving' ),
            'add_new'               => __( 'Add Recipe', 'maxliving' ),
            'new_item'              => __( 'New Recipe', 'maxliving' ),
            'edit_item'             => __( 'Edit Recipe', 'maxliving' ),
            'update_item'           => __( 'Update Recipe', 'maxliving' ),
            'view_item'             => __( 'View Recipe', 'maxliving' ),
            'view_items'            => __( 'View Recipes', 'maxliving' ),
            'search_items'          => __( 'Search Recipe', 'maxliving' ),
            'not_found'             => __( 'Not found', 'maxliving' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'maxliving' ),
            'featured_image'        => __( 'Featured Image', 'maxliving' ),
            'set_featured_image'    => __( 'Set featured image', 'maxliving' ),
            'remove_featured_image' => __( 'Remove featured image', 'maxliving' ),
            'use_featured_image'    => __( 'Use as featured image', 'maxliving' ),
            'insert_into_item'      => __( 'Insert into recipe', 'maxliving' ),
            'uploaded_to_this_item' => __( 'Uploaded to this recipe', 'maxliving' ),
            'items_list'            => __( 'Recipes list', 'maxliving' ),
            'items_list_navigation' => __( 'Recipes list navigation', 'maxliving' ),
            'filter_items_list'     => __( 'Filter recipes list', 'maxliving' ),
        );
        $rewrite = array(
            'slug'                  => 'healthy-recipes',
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => true,
        );

        $taxonomies = array();
        $supports = array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' );

        if (get_current_blog_id() == 1) {
            $taxonomies = array('recipe_categories');
            $supports = array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields' );
        }

        $meta = 'add_metaboxes';
        if(get_option('stylesheet') === 'ml_whitelabel') {
            $meta = '';
        }

        $args = array(
            'label'                 => __( 'Recipe', 'maxliving' ),
            'description'           => __( 'Healthy Recipes', 'maxliving' ),
            'labels'                => $labels,
            'supports'              => $supports,
            'taxonomies'            => $taxonomies,
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 11,
            'menu_icon'             => 'dashicons-carrot',
            'register_meta_box_cb' => $meta,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => array('recipe', 'recipes'),
            'map_meta_cap'          => true,
            'show_in_rest'          => true,

        );
        register_post_type( 'recipe', $args );
    }
    add_action( 'init', 'recipe_post_type', 0 );

}
