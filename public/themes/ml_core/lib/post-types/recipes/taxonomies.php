<?php
global $blog_id;
if ( ! function_exists( 'recipe_categories' )) {

// Register Custom Taxonomy
    function recipe_categories() {

        $labels = array(
            'name'                       => _x( 'Recipe Categories', 'Taxonomy General Name', 'recipe_categories' ),
            'singular_name'              => _x( 'Recipe Category', 'Taxonomy Singular Name', 'recipe_categories' ),
            'menu_name'                  => __( 'Categories', 'recipe_categories' ),
            'all_items'                  => __( 'All Categories', 'recipe_categories' ),
            'parent_item'                => __( 'Parent Category', 'recipe_categories' ),
            'parent_item_colon'          => __( 'Parent Category:', 'recipe_categories' ),
            'new_item_name'              => __( 'New Category', 'recipe_categories' ),
            'add_new_item'               => __( 'Add New Category', 'recipe_categories' ),
            'edit_item'                  => __( 'Edit Category', 'recipe_categories' ),
            'update_item'                => __( 'Update Category', 'recipe_categories' ),
            'view_item'                  => __( 'View Category', 'recipe_categories' ),
            'separate_items_with_commas' => __( 'Separate categories with commas', 'recipe_categories' ),
            'add_or_remove_items'        => __( 'Add or remove categories', 'recipe_categories' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'recipe_categories' ),
            'popular_items'              => __( 'Popular Categories', 'recipe_categories' ),
            'search_items'               => __( 'Search Categories', 'recipe_categories' ),
            'not_found'                  => __( 'Not Found', 'recipe_categories' ),
            'no_terms'                   => __( 'No categories', 'recipe_categories' ),
            'items_list'                 => __( 'Categories list', 'recipe_categories' ),
            'items_list_navigation'      => __( 'Categories list navigation', 'recipe_categories' ),
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
        register_taxonomy( 'recipe_categories', array( 'recipe' ), $args );

    }
    add_action( 'init', 'recipe_categories', 0 );

}
