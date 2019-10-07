<?php
/*
Plugin Name: Periodic Content
Plugin URI:
Description: Handles periodic content for MaxLiving.
Version: 1.0.0
Author: Arcane
Author URI: https://arcane.ws/
Copyright: Arcane
*/

namespace MaxLiving\PeriodicContent;

/*
 * Registering Pages
 * adding action and menu item for childsites
 */
global $blog_id;
if ($blog_id != 1) {
    add_action( 'admin_menu', __NAMESPACE__  .'\\create_menu_my_events' );
    add_action( 'admin_menu', __NAMESPACE__  .'\\create_menu_my_recipes' );
    add_action( 'admin_menu', __NAMESPACE__  .'\\create_menu_my_articles' );
    add_action( 'admin_menu', __NAMESPACE__  .'\\create_menu_create_content' );
}
if ($blog_id == 1) {
    add_action( 'admin_menu', __NAMESPACE__  .'\\menu_corporate_only_recipes' );
    add_action( 'pre_get_posts', __NAMESPACE__  .'\Includes\Transmission::corporate_only_recipe' );
    add_action( 'admin_menu', __NAMESPACE__  .'\\menu_corporate_only_articles' );
    add_action( 'pre_get_posts', __NAMESPACE__  .'\Includes\Transmission::corporate_only_recipe' );

    add_action( 'admin_menu', __NAMESPACE__  .'\\menu_submitted_recipes' );
    add_action( 'pre_get_posts', __NAMESPACE__  .'\Includes\Transmission::submitted_recipes_sort' );
    add_action( 'admin_menu', __NAMESPACE__  .'\\menu_submitted_articles' );
    add_action( 'pre_get_posts', __NAMESPACE__  .'\Includes\Transmission::submitted_articles_sort' );

    add_action( 'admin_menu', __NAMESPACE__  .'\\menu_pending_recipes' );
    add_action( 'admin_menu', __NAMESPACE__  .'\\menu_pending_articles' );

}

/*
 *Routes for post transmission
*/
add_action( 'save_post' , __NAMESPACE__  .'\Includes\Transmission::send_to_corporate', 10, 3);

/**
 * Hooks for when we are querying the corporate site and pulling down the recipes/articles for the childsite
 */
add_action( 'pre_get_posts', __NAMESPACE__  .'\Includes\Transmission::pre_corporate_post_list_query' );
add_action( 'wp', __NAMESPACE__  .'\Includes\Transmission::post_corporate_post_list_query' );

/**
 * this is to hook into the post list page and customize columns
 */
add_action( 'manage_recipe_posts_custom_column', __NAMESPACE__  .'\Includes\Posts::event_table_content', 10, 2 );
add_filter( 'manage_recipe_posts_columns', __NAMESPACE__  .'\Includes\Posts::event_table_head' );
add_action( 'manage_article_posts_custom_column', __NAMESPACE__  .'\Includes\Posts::event_table_content', 10, 2 );
add_filter( 'manage_article_posts_columns', __NAMESPACE__  .'\Includes\Posts::event_table_head' );
add_action( 'admin_post_decline_post', __NAMESPACE__  .'\Includes\Posts::decline_post' );
add_action( 'admin_footer', __NAMESPACE__  .'\Includes\Posts::add_decline_options');

/**
 * Pull in the correct posts on the front-end of the website
 */
add_action( 'pre_get_posts', __NAMESPACE__  .'\Includes\FrontendPosts::post_list_filtering' );
add_action( 'wp', __NAMESPACE__  .'\Includes\FrontendPosts::after_post_list_loading' );

/**
 * Cache article/recipe single views
 */
//add_action( 'save_post', __NAMESPACE__  .'\Includes\Posts::cache_single_views' );

/**
 * Setting meta data
 */
//add_action( 'wpseo_canonical', __NAMESPACE__  .'\Includes\FrontendPosts::set_canonical' );

function create_menu_my_events() {
    add_submenu_page(
        'edit.php?post_type=event',
        'My Events Drafts',
        'Drafts',
        'clinic_admin',
        'my-events-drafts',
        __NAMESPACE__  ."\Views\Content::my_events_drafts"
    );
}

function create_menu_my_recipes() {
    add_submenu_page(
        'edit.php?post_type=recipe',
        'My Recipes Drafts',
        'Drafts',
        'clinic_admin',
        'my-recipes-drafts',
        __NAMESPACE__  ."\Views\Content::my_recipes_drafts"
    );
}

function create_menu_my_articles() {
    add_submenu_page(
        'edit.php?post_type=article',
        'My Articles Drafts',
        'Drafts',
        'clinic_admin',
        'my-articles-drafts',
        __NAMESPACE__  ."\Views\Content::my_articles_drafts"
    );
}

function create_menu_create_content() {
    add_menu_page(
        "Create Content",
        "Create Content",
        "clinic_admin",
        "create-content",
        __NAMESPACE__  ."\Views\Content::create_content",
        "dashicons-welcome-add-page",
        "10"
    );
}

function menu_pending_recipes() {
    add_submenu_page(
        'edit.php?post_type=recipe',
        'Pending Recipes',
        'Pending Recipes',
        'clinic_admin',
        'pending-recipes',
        __NAMESPACE__  ."\Views\Content::pending_recipes"
    );
}

function menu_pending_articles() {
    add_submenu_page(
        'edit.php?post_type=article',
        'Pending Articles',
        'Pending Articles',
        'clinic_admin',
        'pending-articles',
        __NAMESPACE__  ."\Views\Content::pending_articles"
    );
}

function menu_corporate_only_recipes() {
    add_submenu_page(
        'edit.php?post_type=recipe',
        'Corporate Recipes',
        'Corporate Recipes',
        'editor',
        'corporate-only-recipes',
        __NAMESPACE__  ."\Views\Content::corporate_recipes"
    );
}
function menu_corporate_only_articles() {
    add_submenu_page(
        'edit.php?post_type=article',
        'Corporate Articles',
        'Corporate Articles',
        'editor',
        'corporate-only-articles',
        __NAMESPACE__  ."\Views\Content::corporate_articles"
    );
}


function menu_submitted_recipes() {
    add_submenu_page(
        'edit.php?post_type=recipe',
        'Submitted Recipes',
        'Submitted Recipes',
        'editor',
        'submitted-recipes',
        __NAMESPACE__  ."\Views\Content::submitted_recipes"
    );
}
function menu_submitted_articles() {
    add_submenu_page(
        'edit.php?post_type=article',
        'Submitted Articles',
        'Submitted Articles',
        'editor',
        'submitted-articles',
        __NAMESPACE__  ."\Views\Content::submitted_articles"
    );
}
