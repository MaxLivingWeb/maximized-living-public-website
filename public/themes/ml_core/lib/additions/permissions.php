<?php

//Add User Role(s)
add_role(
    'clinic_admin',
    __('Clinic Admin'),
    [
        'edit_posts'    => true,
        'delete_posts'  => true,
        'read'          => true
    ]
);



//Use to reset user permissions.
//remove_role('clinic_admin');
// Replace in functions where add_cap is


//Permissions

//Recipe Permissions
function add_recipe_perms() {
    $caps = array(
        'read',
        'edit',
        'read_recipe',
        'upload_files',
        'read_private_recipes',
        'edit_recipes',
        'edit_private_recipes',
        'edit_published_recipes',
        'edit_others_recipes',
        'delete_recipes',
        'delete_private_recipes',
        'delete_published_recipes',
        'delete_others_recipes',
    );
    $roles = array(
        get_role( 'administrator' ),
        get_role( 'clinic_admin' ),
    );
    foreach ($roles as $role) {
        foreach ($caps as $cap) {
            if( ! $role )
                continue;
            $role->add_cap( $cap );
        }
    }
}
add_action( 'after_setup_theme', 'add_recipe_perms' );

//Article Permissions
function add_article_perms() {
    $caps = array(
        'read',
        'edit',
        'read_article',
        'read_private_articles',
        'edit_articles',
        'edit_private_articles',
        'edit_published_articles',
        'edit_others_articles',
        'delete_articles',
        'delete_private_articles',
        'delete_published_articles',
        'delete_others_articles',
    );
    $roles = array(
        get_role( 'administrator' ),
        get_role( 'clinic_admin' ),
    );
    foreach ($roles as $role) {
        foreach ($caps as $cap) {
            if( ! $role )
                continue;
            $role->add_cap( $cap );
        }
    }
}
add_action( 'after_setup_theme', 'add_article_perms' );

//Event Permissions
function add_event_perms() {
    $caps = array(
        'read',
        'read_event',
        'read_private_events',
        'edit_events',
        'edit_private_events',
        'edit_published_events',
        'edit_others_events',
        'publish_events',
        'delete_events',
        'delete_private_events',
        'delete_published_events',
        'delete_others_events',
        'select_event_categories',
    );
    $roles = array(
        get_role( 'administrator' ),
        get_role( 'clinic_admin' ),
    );
    foreach ($roles as $role) {
        foreach ($caps as $cap) {
            if( ! $role )
                continue;
            $role->add_cap( $cap );
        }
    }
}
add_action( 'after_setup_theme', 'add_event_perms' );

//Press Permissions
function add_press_perms() {
    $caps = array(
        'read',
        'read_press',
        'read_private_presss',
        'edit_presss',
        'edit_private_presss',
        'edit_published_presss',
        'edit_others_presss',
        'publish_presss',
        'delete_presss',
        'delete_private_presss',
        'delete_published_presss',
        'delete_others_presss',
    );
    $roles = array(
        get_role( 'administrator' )
    );
    foreach ($roles as $role) {
        foreach ($caps as $cap) {
            if( ! $role )
                continue;
            $role->add_cap( $cap );
        }
    }
}
add_action( 'after_setup_theme', 'add_press_perms' );

//Essential Permissions
function add_essential_perms() {
    $caps = array(
        'read',
        'read_essential',
        'read_private_essentials',
        'edit_essentials',
        'edit_private_essentials',
        'edit_published_essentials',
        'edit_others_essentials',
        'publish_essentials',
        'delete_essentials',
        'delete_private_essentials',
        'delete_published_essentials',
        'delete_others_essentials',
    );
    $roles = array(
        get_role( 'administrator' )
    );
    foreach ($roles as $role) {
        foreach ($caps as $cap) {
            if( ! $role )
                continue;
            $role->add_cap( $cap );
        }
    }
}
add_action( 'after_setup_theme', 'add_essential_perms' );
