<?php

/**
 * Variables
 */
include 'lib/additions/variables.php';
$stylesheet = get_option('stylesheet');

/**
 * Tracking
 */
include 'lib/additions/tracking.php';

/**
 * Remove default Wordpress head tag clutter
 */
require_once 'lib/overrides/header.php';

/**
 * Posts Overrides
 */
require_once 'lib/overrides/posts.php';

/**
 * Remove default Wordpress footer clutter
 */
require_once 'lib/overrides/footer.php';

/**
 * Handles WordPress image size creation / etc
 */
require_once 'lib/overrides/images.php';

/**
 * Custom Wordpress Login
 */
require_once 'lib/overrides/login.php';

/**
 * Restricts dashboard options to only needed items.
 */
require_once 'lib/overrides/dashboard.php';

/**
 * Restricts dashboard options to only needed items.
 */
require_once 'lib/overrides/security.php';

/**
 * Alters plugin functionality for SEO optimization
 */
include 'lib/overrides/plugins.php';

/**
 * is Clinic a White Label
 */
require_once 'lib/additions/whitelabel.php';

/**
 * Remove classes and IDs from WordPress wp_nav_menu()
 */
include 'lib/overrides/remove-menu-bloat.php';

/**
 * Registers image related support
 */
include 'lib/additions/images.php';

/**
 * Support for Title tag
 */
include 'lib/additions/title-tag-support.php';

/**
 * Registers navigation menus.
 */
include 'lib/additions/menus.php';

/**
 * Enqueues styles and scripts.
 */
include 'lib/additions/assets.php';

/**
 * Cache
 */
//include 'lib/additions/cache.php';

/**
 * Find a Clinic Page
 */
include 'lib/pages/page-find-a-clinic-meta.php';

/**
 * Flexible Content Template
 */
include 'lib/pages/page-flexible-content-meta.php';

/**
 * Includes custom post type for recipes.
 */
include 'lib/post-types/recipes/post-type.php';
include 'lib/post-types/recipes/meta-boxes.php';
include 'lib/post-types/recipes/taxonomies.php';


/**
 * Includes custom post type for events.
 */
if ($stylesheet !== 'ml_whitelabel') {
    include 'lib/post-types/events/post-type.php';
    if(get_current_blog_id() == 1) {
        include 'lib/post-types/events/meta-boxes.php';
    }
    else  {
        include 'lib/post-types/events/meta-boxes-child.php';
    }
    include 'lib/post-types/events/meta-boxes-conference.php';
    include 'lib/post-types/events/taxonomies.php';
    //Event Promo section
    include 'lib/post-types/events/event-promo-page.php';
    include 'lib/post-types/events/event-promo-page-meta.php';
}

/**
 * Includes custom post type for articles.
 */
include 'lib/post-types/articles/post-type.php';
include 'lib/post-types/articles/taxonomies.php';


/**
 * Remove Category Archive views
 */
include 'lib/overrides/remove-category-archives.php';

/**
 * Pagination
 */
include 'lib/additions/pagination.php';

/**
 * Footer Options Page
 */
include 'lib/additions/footer-acf.php';
include 'lib/pages/footer-meta.php';

/**
 * Regions Page Options
 */
include 'lib/additions/regions/regions-options-page.php';
include 'lib/additions/regions/regions-data.php';
include 'lib/additions/regions/page-regions-acf.php';
include 'lib/pages/page-regions-meta.php';

/**
 * SEM Landing Page
 */
if (get_current_blog_id() != 1 && current_user_can( 'manage_network' )) {
    include 'lib/additions/sem-pages/sem-pages-options-page.php';
    include 'lib/additions/sem-pages/sem-pages-acf.php';
    include 'lib/additions/sem-pages/sem-pages-data.php';
}

/**
 * Sitewide Content Page Options
 */
include 'lib/additions/sitewide-content/content-options-page.php';
include 'lib/additions/sitewide-content/page-content-acf.php';

/**
 * fromClinic Metabox values. Distribution region and clinic ID
 */
include 'lib/additions/from-clinic-meta.php';

/**
 * Clinic Admin user role.
 */
include 'lib/additions/permissions.php';

/**
 * Adding post status of declined
 */
include 'lib/additions/status.php';

/**
 * Clinic Site Options
 */
if ($stylesheet !== 'ml_whitelabel') {
    include 'lib/additions/site-options/clinic-site-options-page.php';
    include 'lib/additions/site-options/clinic-site-options.php';
    include 'lib/additions/site-options/clinic-site-options-meta.php';
}

/**
 * Home Page Options
 */
include 'lib/additions/clinic-home-options-page.php';
if ($stylesheet !== 'ml_whitelabel') {
    include 'lib/pages/page-clinic-home-meta.php';
} else {
    include 'lib/pages/page-clinic-home-meta-white-label.php';
}

/**
 * About Page Options
 */
include 'lib/additions/clinic-about-options-page.php';
include 'lib/pages/page-clinic-about-meta.php';

/**
 * Patient Paperwork Page Options
 */
include 'lib/additions/clinic-patient-paperwork-options-page.php';
if ($stylesheet !== 'ml_whitelabel') {
    include 'lib/pages/page-clinic-patient-paperwork-meta.php';
} else {
    include 'lib/pages/page-clinic-patient-paperwork-meta-white-label.php';
}

//flush_rewrite_rules();

add_filter( 'wpseo_json_ld_output', '__return_false' );

function sender_email( $original_email_address ) {
	return 'info@maxliving.com';
}
add_filter( 'wp_mail_from', 'sender_email' );
