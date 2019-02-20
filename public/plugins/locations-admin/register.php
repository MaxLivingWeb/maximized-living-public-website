<?php
/*
Plugin Name: Locations - Clinic Admin
Plugin URI:
Description: Custom dashboard for MaxLiving locations api integration.
Version: 1.0.0
Author: Arcane
Author URI: https://arcane.ws/
Copyright: Arcane
*/

namespace MaxLiving\Location;
//$requiredVersion = "4.8";
//if (version_compare(get_bloginfo('version'), $requiredVersion, '<' )) {
//    wp_die("<h1>You must update WordPress to use this plugin! </h1><br>
//    You are currently running WordPress version <strong>".get_bloginfo('version')."</strong><br> This plugin requires <strong>".$requiredVersion."</strong> or greater");
//}

/**
 *Routes for form processing
*/

//adding the hook for the update location
add_action( 'admin_post_update_location', __NAMESPACE__  .'\Includes\CoreFunctions::update_location' );
//adding the hook for the create location
add_action( 'admin_post_create_location', __NAMESPACE__  .'\Includes\CoreFunctions::create_location' );
//when creating a site in the network level
add_action( 'admin_post_create_site', __NAMESPACE__  .'\Includes\CoreFunctions::create_site' );
//delete location
add_action( 'admin_post_delete_location', __NAMESPACE__  .'\Includes\CoreFunctions::delete_location' );
//update location site id
add_action( 'admin_post_update_location_site_id', __NAMESPACE__  .'\Includes\CoreFunctions::update_location_site_id' );

/**
 * Registering Pages
 */

//adding action and menu item for childsites
add_action( 'admin_menu', __NAMESPACE__  .'\\create_menu' );
//adding action and menu item for the network level
add_action( 'network_admin_menu', __NAMESPACE__  .'\\create_location_menu' );
//hidden route for processing a new site
add_action( 'network_admin_menu', __NAMESPACE__  .'\\create_locations_create_site' );
//network route calling in the form
add_action( 'network_admin_menu', __NAMESPACE__  .'\\network_location_form' );
//the page the user goes to after the location form as been submitted
add_action( 'network_admin_menu', __NAMESPACE__  .'\\network_location_done' );
//the page the user goes to view all locations
add_action( 'network_admin_menu', __NAMESPACE__  .'\\network_view_location' );
//the page the user goes to delete a location
add_action( 'network_admin_menu', __NAMESPACE__  .'\\network_delete_location' );
//the page the user goes to update a locations site id
add_action( 'network_admin_menu', __NAMESPACE__  .'\\network_update_location_site_id' );

//redirect to the right location template based on url
//I believe this is the best hook.  'template_redirect' renders a 404 and it's the next hook to fire after wp
add_filter('parse_request', __NAMESPACE__.'\FrontEnd\Functions::template_redirects');

//register the API route to mask the api endpoint from users
add_action( 'rest_api_init', function () {
    register_rest_route(
        'locations',
        '/api/filter_by_radius',
        array(
            'methods' => 'GET',
            'callback' => __NAMESPACE__.'\FrontEnd\Functions::filter_location_by_radius'
        )
    );

    register_rest_route(
        'locations',
        '/api/get/all',
        array(
            'methods' => 'GET',
            'callback' => __NAMESPACE__.'\Includes\Network\NetworkFunctions::get_all_locations'
        )
    );

} );

function create_menu() {
    add_menu_page(
        "Location",
        "Location",
        "clinic_admin",
        "location-details",
        __NAMESPACE__  ."\AdminViews\LocationForm::render_form" ,
        "dashicons-location",
        "20"
    );
}

function create_location_menu() {
    add_menu_page(
        "Location Network Landing",
        "Locations",
        "editor",
        "location-details-landing",
        __NAMESPACE__  ."\AdminViews\Network\Network::location_details_landing",
        "dashicons-location"
    );
}

function create_locations_create_site() {
    add_submenu_page(
        'Location Create Site',
        'Create Site',
        'Hidden!',
        'editor',
        'location-create-site',
        __NAMESPACE__  .'\AdminViews\Network\Network::location_create_site'
    );
}

function network_location_form() {
    add_submenu_page(
        'Network Location Form',
        'Create Location',
        'Hidden!',
        'editor',
        'network-location-form',
        __NAMESPACE__  .'\AdminViews\LocationForm::render_form'
    );
}

function network_location_done() {
    add_submenu_page(
        'Network Location Done',
        'Location Added',
        'Hidden!',
        'editor',
        'location-done',
        __NAMESPACE__  .'\AdminViews\Network\Network::location_done'
    );
}

function network_view_location() {
    add_submenu_page(
        'Network View Locations',
        'View Locations',
        'Hidden!',
        'editor',
        'network-view-location',
        __NAMESPACE__  .'\AdminViews\Network\Network::view_all_locations'
    );
}

function network_delete_location() {
    add_submenu_page(
        'Network Delete Location',
        'Delete Location',
        'Hidden!',
        'editor',
        'network-delete-location',
        __NAMESPACE__  .'\AdminViews\Network\Network::delete_location'
    );
}
function network_update_location_site_id() {
    add_submenu_page(
        'Network Update Location ID',
        'Update Location Site ID',
        'Hidden!',
        'editor',
        'network-update-location-site-id',
        __NAMESPACE__  .'\AdminViews\Network\Network::update_location_site_id'
    );
}
