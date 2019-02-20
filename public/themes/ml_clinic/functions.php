<?php
add_action('wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

/**
 * Clinic Admin Menu Updates / Clinic Admin Dashboard
 */
include 'lib/additions/clinic-admin-menu.php';

/**
 * Submitted Content Landing Page
 */
include 'lib/pages/submitted-content-page.php';

/**
 * Remove Event Post Type Media Options (Only on Child Site)
 */
include 'lib/additions/remove-event-media.php';

include 'lib/overrides/dashboard.php';

global $affiliate_id;
$affiliate_id = \MaxLiving\ContactForm\FrontEnd\Shortcode::get_affiliate_id();
