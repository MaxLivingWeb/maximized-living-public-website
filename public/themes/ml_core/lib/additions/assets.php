<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-09
 */

/**
 * Loads theme styles properly with Wordpress.
 */
function theme_styles()
{

    wp_register_style('app', get_template_directory_uri() . '/css/app.css', false, '1.0.0');
    wp_enqueue_style('app');

    wp_register_style('print', get_template_directory_uri() . '/css/print.css', false, '1.0.0', 'print');
    wp_enqueue_style('print');

}

//add_action('wp_enqueue_scripts', 'theme_styles');


/**
 * Loads theme scripts properly with Wordpress.
 * PLEASE NOTE: Currently this is not done because Wordpress doesn't allow for
 * SRI has inclusion when adding in a script. Once that becomes available, please
 * revise to include scripts here.
 *
 * Subresource Integrity Info:  https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity
 */
function theme_scripts()
{

}

//add_action('wp_enqueue_scripts', 'theme_scripts');


