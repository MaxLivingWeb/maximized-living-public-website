<?php
global $blog_id;
if ( ! function_exists( 'article_categories' )) {

// Register Custom Taxonomy
    function article_categories() {

        $labels = array(
            'name'                       => _x( 'Article Categories', 'Taxonomy General Name', 'article_categories' ),
            'singular_name'              => _x( 'Article Category', 'Taxonomy Singular Name', 'article_categories' ),
            'menu_name'                  => __( 'Categories', 'article_categories' ),
            'all_items'                  => __( 'All Categories', 'article_categories' ),
            'parent_item'                => __( 'Parent Category', 'article_categories' ),
            'parent_item_colon'          => __( 'Parent Category:', 'article_categories' ),
            'new_item_name'              => __( 'New Category', 'article_categories' ),
            'add_new_item'               => __( 'Add New Category', 'article_categories' ),
            'edit_item'                  => __( 'Edit Category', 'article_categories' ),
            'update_item'                => __( 'Update Category', 'article_categories' ),
            'view_item'                  => __( 'View Category', 'article_categories' ),
            'separate_items_with_commas' => __( 'Separate categories with commas', 'article_categories' ),
            'add_or_remove_items'        => __( 'Add or remove categories', 'article_categories' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'article_categories' ),
            'popular_items'              => __( 'Popular Categories', 'article_categories' ),
            'search_items'               => __( 'Search Categories', 'article_categories' ),
            'not_found'                  => __( 'Not Found', 'article_categories' ),
            'no_terms'                   => __( 'No categories', 'article_categories' ),
            'items_list'                 => __( 'Categories list', 'article_categories' ),
            'items_list_navigation'      => __( 'Categories list navigation', 'article_categories' ),
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
        register_taxonomy( 'article_categories', array( 'article' ), $args );

    }
    add_action( 'init', 'article_categories', 0 );

}
