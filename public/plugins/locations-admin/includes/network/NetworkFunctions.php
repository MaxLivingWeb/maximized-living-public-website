<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-21
 * Time: 11:19 AM
 */

namespace MaxLiving\Location\Includes\Network;

class NetworkFunctions
{
    /**
     * @return string
     */
    public static function get_new_blog() {
        \parse_str($_SERVER['QUERY_STRING'], $query_string);
        $link = '';

        if(\array_key_exists('new_site_id', $query_string) ) {
            if(!empty($query_string['new_site_id'])) {
                $new_site_id = $query_string['new_site_id'];
                \switch_to_blog($new_site_id);
                global $blog_id;
                $link = \get_admin_url($blog_id);
                \restore_current_blog();
            }
        }

        return $link;
    }

    public static function get_all_locations() {

        $locations_api = \getenv("LOCATIONS_API_URL");

        $query_field = 'id,name,telephone,telephone_ext,fax,email,vanity_website_url,vanity_website_id,slug,pre_open_display_date,opening_date,closing_date,daylight_savings_applies,business_hours,addresses{address_1,address_2,zip_postal_code,latitude,longitude,city{name,slug,region{name,abbreviation,country{name,abbreviation}}}}';

        $response = \wp_remote_get( $locations_api."graphql?query=query+query{locations{ $query_field }}", array('method' => "GET") );

        $locations = json_decode($response["body"] );

        if(count($locations->data->locations) > 0) {
            return $locations->data;
        }

        return '';
    }

    public static function get_gmb_locations() {

        if(get_transient('gmb_location') ) {
            return get_transient('gmb_location');
        }

        $locations_api = \getenv("LOCATIONS_API_URL");

        $response = \wp_remote_get( $locations_api.'/api/gmb/get_all', array('method' => "GET") );

        $locations = json_decode($response["body"] );

        return $locations;

    }
}
