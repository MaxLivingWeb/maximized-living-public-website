<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-09
 */
/**
 * If Yoast SEO is installed, remove html comments that expose version information.
 * Remove function is courtesy of https://github.com/trajche
 */
if (defined('WPSEO_VERSION')) {
    add_action('get_header', function () {
        ob_start('remove_yoast_comments');
    });
    add_action('wp_head', function () {
        ob_end_flush();
    }, 999);
}
function remove_yoast_comments($output)
{
    $targets = array(
        '<!-- This site is optimized with the Yoast WordPress SEO plugin v' . WPSEO_VERSION . ' - https://yoast.com/wordpress/plugins/seo/ -->',
        '<!-- / Yoast WordPress SEO plugin. -->'
    );
    $output = str_ireplace($targets, '', $output);
    $output = trim($output);
    $output = preg_replace('/\n?<.*?yoast.*?>/mi', '', $output);
    return $output;
}
