<?php
global $taxonomy;
global $category_name;
// yoast primary category or first category set
$category = get_the_terms( $post->ID, $taxonomy );
$useCatLink = true;
// If post has a category assigned.
if ($category){
    $category_name = '';
    if ( class_exists('WPSEO_Primary_Term') ) {
        $wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, get_the_id() );
        $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
        $term = get_term( $wpseo_primary_term );
        if (is_wp_error($term)) {
            // Default to first category
            $category_name = $category[0]->name;
        }
        else {
            // Yoast Primary category
            $category_name = $term->name;
        }
    }
    else {
        // Default, display the first category in WP's list of assigned categories
        $category_name = $category[0]->name;
    }
}
