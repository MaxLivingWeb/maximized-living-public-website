<?php

/* Remove category archives */
function remove_wp_archives(){
    //If we are on category or tag or date or author archive
    if( is_category() || is_tag() || is_date() || is_author() || is_tax() || is_attachment() ) {
        global $wp_query;
        $wp_query->set_404(); //set to 404 not found page
    }
}
add_action('template_redirect', 'remove_wp_archives');

/**
 * @param $data
 * @return bool|string
 * Removing trailing slash from a url
 */
function removeTrailingSlash($data){
    if(substr($data, -1) == '/') {
        return substr($data, 0, -1);
    }
    return $data;
}
