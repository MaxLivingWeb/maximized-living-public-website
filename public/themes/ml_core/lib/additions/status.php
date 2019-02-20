<?php

add_action( 'init', 'add_declined_status' );

function add_declined_status(){
    register_post_status( 'declined', array(
        'label'                     => _x( 'Declined', 'post' ),
        'public'                    => false,
        'internal'                  => true,
        'protected'                 => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Declined <span class="count">(%s)</span>', 'Declined <span class="count">(%s)</span>' ),
    ) );
}

//redirect hackery
function app_output_buffer() {
    ob_start();
} // soi_output_buffer
add_action('init', 'app_output_buffer');

function app_destroy_person( $person_id ) {

    // Include the necessary library to delete a person
    include_once( 'wp-admin/includes/user.php' );
    wp_delete_user( $person_id );

    // Redirect back to the Person listing
    wp_redirect( app_get_permalink_by_slug( 'all', 'person' ) );
    exit;

} // end app_destroy_person
