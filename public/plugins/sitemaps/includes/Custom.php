<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2018-01-08
 * Time: 12:24 PM
 */

namespace MaxLiving\Sitemaps\Includes;

class Custom {

    /**
     * Create Locations Sitemap
     */
    function locations_sitemap() {

        global $wpseo_sitemaps;
        $output    = '';
        $locations = '';
        $date      = '2018-01-15 12:00:00';//default date

        if(get_transient('locationsSitemap')) {
            $locations = get_transient('locations-sitemap');
        }
        else {
            $location_functions = new \MaxLiving\Location\FrontEnd\Functions();
            $locations = $location_functions->get_all_cities();
            set_transient('locations-sitemap', $locations,240 * MINUTE_IN_SECONDS);
        }

        //Add countries
        foreach ( $locations->countries as $country ) {
            if ( $location_functions->country_has_locations( $country ) ) {
                $url = get_home_url() . "/locations/" . strtolower( $country->abbreviation );

                if ( ! empty( $country->updated_at ) ) {
                    $date = $country->updated_at;
                }

                $output .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . $date . '</lastmod>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>';

            }
        }

        //Add Regions
        foreach ( $locations->countries as $country ) {
            foreach ( $country->regions as $region ) {
                if ( $location_functions->region_has_locations( $region ) ) {
                    $url = get_home_url() . "/locations/" . strtolower( $country->abbreviation . "/" . $region->abbreviation );

                    if ( ! empty( $region->updated_at ) ) {
                        $date = $region->updated_at;
                    }

                    $output .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . $date . '</lastmod>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>';
                }
            }
        }

        //Add Cities
        foreach ( $locations->countries as $country ) {
            foreach ( $country->regions as $region ) {
                foreach ( $region->cities as $city ) {
                    if ( $location_functions->city_has_locations( $city ) ) {
                        $url = get_home_url() . "/locations/" . strtolower( $country->abbreviation . "/" . $region->abbreviation . "/" . $city->slug );

                        if ( ! empty( $city->updated_at ) ) {
                            $date = $city->updated_at;
                        }

                        $output .= '<url>
<loc>' . $url . '</loc>
<lastmod>' . $date . '</lastmod>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>';
                    }
                }
            }
        }


        if ( empty( $output ) ) {
            $wpseo_sitemaps->bad_sitemap = true;
            return;
        }
        //Build the full locations sitemap
        $sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
        $sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $sitemap .= $output;
        $sitemap .= '</urlset>';
        $wpseo_sitemaps->set_sitemap( $sitemap );
    }


    public static function append_index( $appended_items ) {

        $home_url = home_url();

        $recipes_lastmod = new \WP_Query( array(
            'post_type' => 'recipe',
            'orderby'   => 'post_modified',
            'order'     => 'DESC'
        ) );

        $appended_items = '
            <sitemap>
            <loc>' . $home_url . '/recipe-sitemap.xml</loc>
            <lastmod>' . $recipes_lastmod->posts[0]->post_modified . '</lastmod>
            </sitemap>';

        $articles_lastmod = new \WP_Query( array(
            'post_type' => 'article',
            'orderby'   => 'post_modified',
            'order'     => 'DESC'
        ) );

        $appended_items .= '
            <sitemap>
            <loc>' . $home_url . '/article-sitemap.xml</loc>
            <lastmod>' . $articles_lastmod->posts[0]->post_modified . '</lastmod>
            </sitemap>';

        if ( get_current_blog_id() === 1 ) {
            $appended_items .= '
            <sitemap>
            <loc>' . home_url() . '/store/sitemap.xml</loc>
            <lastmod></lastmod>
            </sitemap>';

            $appended_items .= '
            <sitemap>
            <loc>' . home_url() . '/locations-sitemap.xml</loc>
            <lastmod></lastmod>
            </sitemap>';


        }

        return $appended_items;
    }

}
