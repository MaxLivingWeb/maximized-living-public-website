<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-12-07
 * Time: 10:37 AM
 */

namespace MaxLiving\PeriodicContent\Includes;

class FrontendPosts
{
    public static function post_list_filtering($query)
    {
        // Ability to Preview Posts
        if (isset($_GET['post_type'], $_GET['p'])) {
            return;
        }

        //if we're not on the frontend get out
        if (is_admin()) {
            return;
        }

        //is clinic/whitelabel homepage
        $stylesheet=get_option('stylesheet');
        if($stylesheet === 'ml_clinic') {
            $current = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if($current == get_home_url().'/' || $current == get_home_url()) {
                return;
            }
        }
        //don't do anything if the query is a page, happens with the my-doctors-blog
        if ($query->is_page()) {
            return;
        }

        //if the url contains any sitemap.xml
        if (strpos($_SERVER['REQUEST_URI'], 'sitemap.xml') !== false) {
            return;
        }

        $childsite_id = get_current_blog_id();

        //get the page template and do some string manipulation to make sure we're on the doctor's blog template
        $page_template = get_page_template();
        $page_template_arr = explode("/", $page_template);
        $template = end($page_template_arr);

        //if we're on the html sitemap
        if ($template === 'sitemap.php') {
            return;
        }

        if ($template === 'doctors-blog.php') {
            
            switch_to_blog(1);

            $query->set('post_type', array('article', 'recipe'));
            $query->set(
                'meta_query',
                array(
                    array(
                        'key' => 'siteOriginID',
                        'value' => $childsite_id
                    )
                )
            );

            return;
        }

        if (!isset($query->query['post_type'])) {
            return;
        }

        if ($query->query['post_type'] !== 'recipe' && $query->query['post_type'] !== 'article') {
            return;
        }

        //if we are on the corporate site - only show network level posts
        if ($childsite_id === 1) {
            $query->set(
                'meta_query',
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'distribution_reach',
                        'value' => 1,
                        'compare' => '='
                    ),
                    array(
                        'key' => 'distribution_reach',
                        'value' => 2,
                        'compare' => '='
                    )
                )
            );

            return;
        }

        //get the sites regions
        $site_regions = get_blog_option($childsite_id,'clinic_options_site_option_region_selection');

        switch_to_blog(1);
        $query->set(
            'meta_query',
            array(
                'relation' => 'OR',
                array(//this takes are of the "my site" only posts
                    'key' => 'siteOriginID',
                    'value' => $childsite_id,
                    'compare' => '='
                ),
                array(
                    'key' => 'distribution_reach',
                    'value' => 1,
                    'compare' => '='
                ),
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'distribution_reach',
                        'value' => 2,
                        'compare' => '='
                    ),
                    array(
                        'relation' => 'OR',
                        array(
                            'key' => 'regional_distribution',
                            'value' => $site_regions,
                            'compare' => 'IN'
                        )
                    )
                )
            )
        );

        //if it is a listing page, return because we don't need any of this seo business for listing pages
        if (!is_single()) {
            return;
        }

        //customize og:url
        add_filter('wpseo_opengraph_url', function () {
            return get_permalink();
        });

        //customize canonical
        add_filter('wpseo_canonical', function () use ($query) {

            //query is passing in ID
            $post_id = $query->queried_object->ID;

            switch_to_blog(1);

            $post_meta = get_post_meta($post_id);
            $post = get_post($post_id);

            restore_current_blog();

            //'my site only' or regional posts
            if ($post_meta['distribution_reach'][0] === '0' || $post_meta['distribution_reach'][0] === '2') {
                $site_origin_id = $post_meta['siteOriginID'][0];
                $site_origin = get_blog_details($site_origin_id)->home;

                if ($post->post_type === 'recipe') {
                    return "$site_origin/healthy-recipes/" . $post->post_name;
                }

                return "$site_origin/healthy-articles/" . $post->post_name;
            }

            //if network wide resolve to corporate
            $corporate_site = get_blog_details(1)->home;

            if ($post->post_type === 'recipe') {
                return "$corporate_site/healthy-recipes/" . $post->post_name;
            }

            return "$corporate_site/healthy-articles/" . $post->post_name;
        });

    }

    public static function after_post_list_loading()
    {

        if (is_admin()) {
            return;
        }

        restore_current_blog();

        return;
    }
}
