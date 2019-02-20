<?php

if ( ! function_exists( 'press_categories' ) ) {

// Register Custom Taxonomy
    function press_categories() {

        $labels = array(
            'name'                       => _x( 'Press &amp; Media Release Categories', 'Taxonomy General Name', 'press_categories' ),
            'singular_name'              => _x( 'Press &amp; Media Release Category', 'Taxonomy Singular Name', 'press_categories' ),
            'menu_name'                  => __( 'Categories', 'press_categories' ),
            'all_items'                  => __( 'All Categories', 'press_categories' ),
            'parent_item'                => __( 'Parent Category', 'press_categories' ),
            'parent_item_colon'          => __( 'Parent Category:', 'press_categories' ),
            'new_item_name'              => __( 'New Category', 'press_categories' ),
            'add_new_item'               => __( 'Add New Category', 'press_categories' ),
            'edit_item'                  => __( 'Edit Category', 'press_categories' ),
            'update_item'                => __( 'Update Category', 'press_categories' ),
            'view_item'                  => __( 'View Category', 'press_categories' ),
            'separate_items_with_commas' => __( 'Separate categories with commas', 'press_categories' ),
            'add_or_remove_items'        => __( 'Add or remove categories', 'press_categories' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'press_categories' ),
            'popular_items'              => __( 'Popular Categories', 'press_categories' ),
            'search_items'               => __( 'Search Categories', 'press_categories' ),
            'not_found'                  => __( 'Not Found', 'press_categories' ),
            'no_terms'                   => __( 'No categories', 'press_categories' ),
            'items_list'                 => __( 'Categories list', 'press_categories' ),
            'items_list_navigation'      => __( 'Categories list navigation', 'press_categories' ),
        );
        $capabilities = array(
            'manage_terms'               => 'manage_categories',
            'edit_terms'                 => 'manage_categories',
            'delete_terms'               => 'manage_categories',
            'assign_terms'               => 'manage_categories',
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'capabilities'               => $capabilities,
            'show_in_rest'               => true,
        );
        register_taxonomy( 'press_categories', array( 'press' ), $args );

    }
    add_action( 'init', 'press_categories', 0 );

}
