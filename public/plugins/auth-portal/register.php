<?php
/*
Plugin Name: Authportal Intergration
Plugin URI:
Description: Allows for authentication via the authportal.
Version: 1.0.0
Author: Arcane
Author URI: https://arcane.ws/
Copyright: Arcane
*/

namespace MaxLiving\AuthPortal;

require_once ABSPATH . 'wp-admin/includes/ms.php';

add_action('wp_authenticate', __NAMESPACE__.'\Includes\Authenticate::from_auth_portal');

//adding the auth portal button the login page
add_action('login_init', function() {

    $authportal_url = env('AUTHPORTAL_URL');

    echo '
    <style>
        #login {
            display: none;
        }
        .wp-core-ui .authportal-btn-container {
            text-align: center;
            
        }
        .wp-core-ui .button.button-large.authportal-btn {
            float: none;
            width: 300px;
        }
    </style>
    
    <div class="authportal-btn-container">
        <h1><a href="'.home_url().'" title="MaxLiving" tabindex="-1">MaxLiving</a></h1>
        <a href="'.$authportal_url.'?redirect_uri='.wp_login_url().'" class="authportal-btn button button-primary button-large">MaxLiving Account Login</a>
    </div>';
});

//disable welcome email
add_action('phpmailer_init', __NAMESPACE__.'\Includes\User::intercept_registration_email');

add_action( 'rest_api_init', function () {
    register_rest_route(
        'authportal',
        '/user/create',
        array(
            'methods' => 'POST',
            'callback' => __NAMESPACE__.'\Includes\User::create'
        )
    );
} );

add_action( 'rest_api_init', function () {
    register_rest_route(
        'authportal',
        '/user/delete',
        array(
            'methods' => 'POST',
            'callback' => __NAMESPACE__.'\Includes\User::delete'
        )
    );
} );
