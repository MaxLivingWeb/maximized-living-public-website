<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2018-01-08
 * Time: 12:24 PM
 */

namespace MaxLiving\Sitemaps\Includes;

use Thepixeldeveloper\Sitemap\Urlset;
use Thepixeldeveloper\Sitemap\Url;
use Thepixeldeveloper\Sitemap\Drivers\XmlWriterDriver;
use WP_Query;

class Generate
{
    public function sitemap($post_type) {

        $childsite_id = get_current_blog_id();

        //switch to corporate
        switch_to_blog(1);

        //if we are on the corporate site - only show network level posts
        if($childsite_id === 1) {
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => 500,//capping posts at 500
                'meta_query' =>
                array(
                    array(
                        'key' => 'distribution_reach',
                        'value' => 1,
                        'compare' => '='
                    )
                )
            );
        } else {

            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => 500,//capping posts at 500
                'meta_query' =>
                array(
                    'relation' => 'OR',
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'distribution_reach',
                            'value' => 0,
                            'compare' => '='
                        ),
                        array(
                            'key' => 'siteOriginID',
                            'value' => $childsite_id,
                            'compare' => '='
                        )
                    ),
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'distribution_reach',
                            'value' => 2,
                            'compare' => '='
                        ),
                        array(
                            'key' => 'siteOriginID',
                            'value' => $childsite_id,
                            'compare' => '='
                        )
                    )
                )
            );
        }

        header('Content-type: text/xml');

        $query = new \WP_Query( $args );

        $urlset = new Urlset();
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();

                $post_meta = get_post_meta( $query->post->ID );
                $site_origin_id = $post_meta['siteOriginID'][0];
                $site_origin = "https://".get_blog_details($site_origin_id)->domain;
                $post = get_post( $query->post->ID );

                //default to corporate
                $corporate_site = "https://".get_blog_details(1)->domain;
                $post_url = "$corporate_site/healthy-recipes/$post->post_name";
                if ($post_type === 'article') {
                    $post_url = "$corporate_site/healthy-articles/$post->post_name";
                }

                //if it is 'my site only' or regional
                if($post_meta['distribution_reach'][0] === '0' || $post_meta['distribution_reach'][0] === '2') {
                    $post_url = "$site_origin/healthy-recipes/$post->post_name";
                    if ($post_type === 'article') {
                        $post_url = "$site_origin/healthy-articles/$post->post_name";
                    }
                }

                $url = new Url( $post_url );
                $date = new \DateTime(get_the_modified_date() );
                $url->setLastMod( $date );
                $url->setChangeFreq("monthly");
                $url->setPriority("0.8");

                $urlset->add($url);
            }
        }

        $driver = new XmlWriterDriver();
        $urlset->accept($driver);
        echo $driver->output();
        restore_current_blog();
    }

    public function get_articles_or_recipes($post_type)
    {

        $childsite_id = get_current_blog_id();

        //switch to corporate
        switch_to_blog(1);

        //if we are on the corporate site - only show network level posts
        if ($childsite_id === 1) {
            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => 500,//capping posts at 500
                'meta_query' =>
                array(
                    array(
                        'key' => 'distribution_reach',
                        'value' => 1,
                        'compare' => '='
                    )
                )
            );
        } else {

            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => 500,//capping posts at 500
                'meta_query' =>
                    array(
                        'relation' => 'OR',
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'distribution_reach',
                                'value' => 0,
                                'compare' => '='
                            ),
                            array(
                                'key' => 'siteOriginID',
                                'value' => $childsite_id,
                                'compare' => '='
                            )
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'distribution_reach',
                                'value' => 2,
                                'compare' => '='
                            ),
                            array(
                                'key' => 'siteOriginID',
                                'value' => $childsite_id,
                                'compare' => '='
                            )
                        )
                    )
            );
        }

        restore_current_blog();

        $query = new WP_Query( $args );
        wp_reset_query();

        restore_current_blog();

        return $query;
    }
}
