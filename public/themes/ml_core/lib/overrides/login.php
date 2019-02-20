<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-08
 */

/**
 * custom login screen css
 */

function login_style() { ?>
    <style type="text/css">
        body {
            background-color: #fff;
        }
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/images/logo-wordmark-under-logo.svg);
            height:175px;
            width:320px;
            background-size: 550px 200px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
        .login form {
            background: none;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .login form .input, .login input[type="text"] {
            padding: 5px;
            margin: 1px 10px 15px 0;
        }

        .wp-core-ui .button-primary {
            background: none;
            border-color: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            color: none;
            text-decoration: none;
            text-shadow: none;
        }

        .wp-core-ui .button, .wp-core-ui .button-secondary {
            color: none;
            border-color: #58BFBA;
            background: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            vertical-align: none;
        }

        .button.button-primary, button.button-primary {
            background-color: #58BFBA;
        }
        .button.button-primary:hover, button.button-primary:hover {
            opacity: .8;
        }

        .wp-core-ui .button.button-large, .wp-core-ui .button-group.button-large .button {
            height: 30px;
            line-height: 28px;
            margin-top: 0rem;
            padding: 0 12px 2px;
            width: 50%;
        }
        #lostpasswordform .button-large, #lostpasswordform .button {
            width: 60%;
        }

        p#nav, p#backtoblog, #login_error,  p.message  {
            display: none;
        }

    </style>
<?php }
add_action( 'login_head', 'login_style' );


function custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/styles/theme.css" />';
}
add_action('login_head', 'custom_login');

/**
 * Remove the Login Page Shake
 */
function login_head() {
    remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'login_head');

/**
 * custom login screen url
 * @return string|void
 */
function custom_login_url() {
    return get_home_url();
}

add_filter('login_headerurl', 'custom_login_url', 10, 4);

/**
 * custom login page title
 * @return string|void
 */
function custom_login_header_title() {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'custom_login_header_title');

/**
 * Remove error text from failed login attempts
 */
add_filter('login_errors', create_function('$a', "return null;"));
