<?php

if ( ! function_exists( 'event_categories' ) ) {

// Register Custom Taxonomy
    function event_categories() {

        $labels = array(
            'name'                       => _x( 'Event Categories', 'Taxonomy General Name', 'event_categories' ),
            'singular_name'              => _x( 'Event Category', 'Taxonomy Singular Name', 'event_categories' ),
            'menu_name'                  => __( 'Categories', 'event_categories' ),
            'all_items'                  => __( 'All Categories', 'event_categories' ),
            'parent_item'                => __( 'Parent Category', 'event_categories' ),
            'parent_item_colon'          => __( 'Parent Category:', 'event_categories' ),
            'new_item_name'              => __( 'New Category', 'event_categories' ),
            'add_new_item'               => __( 'Add New Category', 'event_categories' ),
            'edit_item'                  => __( 'Edit Category', 'event_categories' ),
            'update_item'                => __( 'Update Category', 'event_categories' ),
            'view_item'                  => __( 'View Category', 'event_categories' ),
            'separate_items_with_commas' => __( 'Separate categories with commas', 'event_categories' ),
            'add_or_remove_items'        => __( 'Add or remove categories', 'event_categories' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'event_categories' ),
            'popular_items'              => __( 'Popular Categories', 'event_categories' ),
            'search_items'               => __( 'Search Categories', 'event_categories' ),
            'not_found'                  => __( 'Not Found', 'event_categories' ),
            'no_terms'                   => __( 'No categories', 'event_categories' ),
            'items_list'                 => __( 'Categories list', 'event_categories' ),
            'items_list_navigation'      => __( 'Categories list navigation', 'event_categories' ),
        );
        $capabilities = array(
            'manage_terms'               => 'manage_categories',
            'edit_terms'                 => 'manage_categories',
            'delete_terms'               => 'manage_categories',
            'assign_terms'               => 'select_event_categories',
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
        register_taxonomy( 'event_categories', array( 'event' ), $args );

    }
    add_action( 'init', 'event_categories', 0 );

}
