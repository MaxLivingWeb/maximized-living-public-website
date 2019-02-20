<?php
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/**
 * Home Page Options
 */
include 'lib/additions/home-options-page.php';
include 'lib/pages/page-home-meta.php';

/**
 * Contact Page Options
 */
include 'lib/additions/contact-options-page.php';
include 'lib/pages/page-contact-meta.php';

/**
 * Includes custom post type for press releases.
 */
include 'lib/post-types/press/post-type.php';
include 'lib/post-types/press/taxonomies.php';

/**
 * Corporate Dashboard
 */
include 'lib/additions/corporate-dashboard.php';
