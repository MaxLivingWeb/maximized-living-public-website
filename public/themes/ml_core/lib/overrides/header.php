<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-08
 */

/**
 * Removes security vulnerabilities, extraneous styles and scripts,
 * as well as related resource inclusions for Wordpress 4.7.x
 *
 * All actions have been broken up into their related groupings with comments
 * as to what each grouping affects and any specific notes.
 */
function removeHeadLinks()
{
    /**
     * Disables all RSS based feed links from being output.
     * See line 70 for function to completely disable feeds from being accessible.
     */
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);

    /**
     * Disables RSD and WLM endpoint exposure.
     * See attached .htaccess to restrict access to these files
     */
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');

    /**
     * Disables adjacent posts links.
     */
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

    /**
     * Removes security issue of broadcasting the Wordpress version installed.
     */
    remove_action('wp_head', 'wp_generator');

    /**
     * Removes REST API and oEmbed link references. Does not stop you from using the RESTful API,
     * just removes the broadcasting of it.
     */
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    /**
     * Removes pre-fetching header for external sources such as the Emoji CDN.
     */
    remove_action('wp_head', 'wp_resource_hints', 2);

    /**
     * Removes all styles and scripts related to inline Emoji detection and conversion.
     */
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}

add_action('init', 'removeHeadLinks');


/**
 * Ensures that if the feeds are hidden, they are no longer accessible.
 * Code for redirect is courtesy of https://github.com/solarissmoke
 * Only thing that has been done to it is conversion from a php class and cleaning up
 * the look of the code.
 */
function feedTemplateRedirect()
{
    /**
     * Only proceed if current query is for a feed.
     */
    if (!is_feed()) {
        return;
    }

    if (isset($_GET['feed'])) {
        wp_redirect(esc_url_raw(remove_query_arg('feed')), 301);
        exit;
    }

    if (get_query_var('feed') !== 'old') {
        set_query_var('feed', '');
    }

    redirect_canonical();

    /**
     * Still here? redirect_canonical failed to redirect, probably because of a filter. Try the hard way.
     */
    global $wp_rewrite;

    $structure = (!is_singular() && is_comment_feed()) ?
        $wp_rewrite->get_comment_feed_permastruct() : $wp_rewrite->get_feed_permastruct();
    $structure = preg_quote($structure, '#');
    $structure = str_replace('%feed%', '(\w+)?', $structure);
    $structure = preg_replace('#/+#', '/', $structure);
    $requested_url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $new_url = preg_replace('#' . $structure . '/?$#', '', $requested_url);
    if ($new_url != $requested_url) {
        wp_redirect($new_url, 301);
        exit;
    }

}

add_action('template_redirect', 'feedTemplateRedirect', 1);