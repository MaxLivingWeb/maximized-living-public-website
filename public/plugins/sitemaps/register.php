<?php
/*
Plugin Name: Sitemaps
Plugin URI:
Description: Generates Sitemaps
Version: 1.0.0
Author: Arcane
Author URI: https://arcane.ws/
Copyright: Arcane
*/

namespace MaxLiving\Sitemaps;

// add the filter
add_filter( 'wpseo_sitemap_index', __NAMESPACE__.'\Includes\Custom::append_index', 10, 1 );
//add_filter( 'wpseo_enable_xml_sitemap_trans ient_caching', '__return_false');

add_action('init', function() {
    $generate = new \MaxLiving\Sitemaps\Includes\Generate();

    if(get_current_blog_id() === 1) {
        global $wpseo_sitemaps;
        $wpseo_sitemaps->register_sitemap( 'locations', __NAMESPACE__ . '\Includes\Custom::locations_sitemap' );
        add_action( 'wpseo_do_sitemap_locations', __NAMESPACE__.'\Includes\Custom::locations_sitemap');
        add_action( 'wp_seo_do_sitemap_our-locations', __NAMESPACE__ . '\Includes\Custom::locations_sitemap' );
    }


    //getting the last piece of the url to make sure it is "recipe-sitemap.xml" or "article-sitemap.xml"
    $relative_url = $_SERVER["REQUEST_URI"];
    $relative_url_pieces = explode("/", $relative_url);
    $end_url = end($relative_url_pieces);

    if ($end_url == 'recipe-sitemap.xml') {
        $generate->sitemap('recipe');die;
    }

    if ($end_url == 'article-sitemap.xml') {
        $generate->sitemap('article');die;
    }
});
