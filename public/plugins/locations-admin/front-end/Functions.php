<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-21
 * Time: 1:45 PM
 */

namespace MaxLiving\Location\FrontEnd;

use WP_REST_Request;

class Functions
{
    /**
     * @param null $site_id
     * @param array $fields
     * @return object|string
     */
    public function get_location_by_site_id($site_id = null, $fields = array() ) {
        if(is_null($site_id) ) {
            return '';
        }

        $locations_api = \getenv("LOCATIONS_API_URL");
        $query_field = implode(",", $fields);

        //if an empty array is passed in, grab everything
        if(empty($fields)) {
            $query_field = 'name,telephone,telephone_ext,fax,email,vanity_website_url,vanity_website_id,slug,pre_open_display_date,opening_date,closing_date,daylight_savings_applies,business_hours,addresses{address_1,address_2,zip_postal_code,latitude,longitude,city{name,slug,region{name,abbreviation,country{name,abbreviation}}}}';
        }

        $response = \wp_remote_get( $locations_api."graphql?query=query+query{locations(vanity_website_id:$site_id){ $query_field }}", array('method' => "GET") );

        $location = json_decode($response["body"] );

        if(count($location->data->locations) > 0) {
            return $location->data;
        }

        return '';
    }

    public function get_location($location_slug = null, $city_slug = null, $region_code = null, $country_code = null, $fields = array() ) {
        if(is_null($location_slug) ) {
            return '';
        }

        $locations_api = \getenv("LOCATIONS_API_URL");
        $query_field = implode(",", $fields);

        //if an empty array is passed in, grab everything
        if(empty($fields)) {
            $query_field = 'name,telephone,telephone_ext,fax,email,vanity_website_url,vanity_website_id,slug,pre_open_display_date,opening_date,closing_date,daylight_savings_applies,business_hours,addresses{address_1,address_2,zip_postal_code,latitude,longitude,city{name,slug,region{name,abbreviation,country{name,abbreviation}}}}';
        }

        $response = \wp_remote_get( $locations_api."graphql?query=query+query{locations(slug:\"$location_slug\",citySlug:\"$city_slug\",regionCode:\"$region_code\",countryCode:\"$country_code\"){ $query_field }}", array('method' => "GET") );

        $location = json_decode($response["body"] );

        if(count($location->data->locations) > 0) {
            return $location->data;
        }

        return '';
    }

    /**
     * @param null $city_name
     * @param array $fields
     * @return array|string
     */
    public function get_location_by_city($city_slug = null, $region_code = null, $country_code = null, $fields = array() ) {
        if(is_null($city_slug) || is_null($region_code) || is_null($country_code) ) {
            return '';
        }

        $locations_api = \getenv("LOCATIONS_API_URL");
        $query_field = implode(",", $fields);

        //if an empty array is passed in, grab everything
        if(empty($fields)) {
            $query_field = 'name,telephone,telephone_ext,fax,email,vanity_website_url,vanity_website_id,slug,pre_open_display_date,opening_date,closing_date,daylight_savings_applies,business_hours,addresses{address_1,address_2,zip_postal_code,latitude,longitude,city{name,slug,region{name,abbreviation,country{name,abbreviation}}}}';
        }

        $response = \wp_remote_get( $locations_api."graphql?query=query+query{locations(citySlug:\"$city_slug\",regionCode:\"$region_code\",countryCode:\"$country_code\"){ $query_field }}", array('method' => "GET") );

        $locations = json_decode($response["body"] );

        if(count($locations->data->locations) > 0) {
            return $locations->data;
        }

        return '';
    }

    /**
     * @param null $region_code
     * @param array $fields
     * @return array|string
     */
    public function get_location_by_region($region_code = null, $country_code = null, $fields = array() ) {
        if(is_null($region_code) || is_null($country_code)) {
            return '';
        }

        $locations_api = \getenv("LOCATIONS_API_URL");
        $query_field = implode(",", $fields);

        //if an empty array is passed in, grab everything
        if(empty($fields)) {
            $query_field = 'name,telephone,telephone_ext,fax,email,vanity_website_url,vanity_website_id,slug,pre_open_display_date,opening_date,closing_date,daylight_savings_applies,business_hours,addresses{address_1,address_2,zip_postal_code,latitude,longitude,city{name,slug,region{name,abbreviation,country{name,abbreviation}}}}';
        }

        $response = \wp_remote_get( $locations_api."graphql?query=query+query{locations(regionCode:\"$region_code\",countryCode:\"$country_code\"){ $query_field }}", array('method' => "GET") );

        $locations = json_decode($response["body"] );

        if(count($locations->data->locations) > 0) {
            return $locations->data;
        }

        return '';
    }

    /**
     * @param null $country_code
     * @param array $fields
     * @return array|string
     */
    public function get_location_by_country($country_code = null, $fields = array() ) {
        if(is_null($country_code) ) {
            return '';
        }

        $locations_api = \getenv("LOCATIONS_API_URL");
        $query_field = implode(",", $fields);

        //if an empty array is passed in, grab everything
        if(empty($fields)) {
            $query_field = 'name,telephone,telephone_ext,fax,email,vanity_website_url,vanity_website_id,slug,pre_open_display_date,opening_date,closing_date,daylight_savings_applies,business_hours,addresses{address_1,address_2,zip_postal_code,latitude,longitude,city{name,slug,region{name,abbreviation,country{name,abbreviation}}}}';
        }

        $response = \wp_remote_get( $locations_api."graphql?query=query+query{locations(countryCode:\"$country_code\"){ $query_field }}", array('method' => "GET") );

        $locations = json_decode($response["body"] );

        if(count($locations->data->locations) > 0) {
            return $locations->data;
        }

        return '';
    }

    /**
     * @param WP_REST_Request $request
     * @return array|string
     */
    public static function filter_location_by_radius(WP_REST_Request $request) {

        $latitude = $request->get_param('latitude');
        $longitude = $request->get_param('longitude');

        return self::run_filter_by_radius($latitude, $longitude);
    }

    public function filter_location_by_radius_on_load() {

        $latitude = $_GET['lat'];
        $longitude = $_GET['long'];

        return self::run_filter_by_radius($latitude, $longitude);
    }

    private static function run_filter_by_radius($latitude, $longitude)
    {

        if (empty($latitude) || empty($longitude)) {
            return '';
        }
        $locations_api = \getenv("LOCATIONS_API_URL");

        $query_field = 'address_1,address_2,latitude,longitude,zip_postal_code,location_name,location_id,location_slug,location_telephone,location_telephone_ext,location_vanity_website_id,location_business_hours,city_name,city_slug,region_name,region_code,country_name,country_code';
        $latitude = (double)$latitude;
        $longitude = (double)$longitude;

        $response = \wp_remote_get($locations_api . "graphql?query=query+query{locations(filter_by_radius:true,latitude:$latitude,longitude:$longitude,distance:50){ $query_field }}", array('method' => "GET"));

        $locations = json_decode($response["body"]);

        foreach ($locations->data->locations as $location){
            $new_hours = self::format_business_hours($location->location_business_hours);
            $location->location_business_hours = $new_hours;

            $location->country_code = strtolower($location->country_code);
            $location->region_code = strtolower($location->region_code);
        }

        return $locations->data;
    }

    public function get_all_cities() {

        $location_transient = get_transient('sitemap_locations');

        if($location_transient !== false) {
            return $location_transient;
        }

        $locations_api = \getenv("LOCATIONS_API_URL");

        $response = \wp_remote_get( $locations_api."graphql?query=query+query{countries{name,abbreviation,regions{name,abbreviation,cities{name,slug,addresses{address_1,locations{name}}}}}}", array('method' => "GET", 'timeout' => 10) );

        $locations = json_decode($response["body"] );



        if(isset($locations->data) ) {
            set_transient('sitemap_locations', $locations->data, WEEK_IN_SECONDS);

            return $locations->data;
        }

        return '';
    }

    public function country_has_locations($country) {

        $has_location = false;

        foreach($country->regions as $region) {
            foreach($region->cities as $city) {
                foreach($city->addresses as $address) {
                    foreach($address->locations as $location) {
                        if(!empty($location) ) {
                            $has_location = true;
                        }
                    }
                }
            }
        }

        return $has_location;
    }

    public function region_has_locations($region) {

        $has_location = false;

        foreach($region->cities as $city) {
            foreach($city->addresses as $address) {
                foreach($address->locations as $location) {
                    if(!empty($location) ) {
                        $has_location = true;
                    }
                }
            }
        }

        return $has_location;
    }

    public function city_has_locations($city) {

        $has_location = false;

        foreach($city->addresses as $address) {
            foreach($address->locations as $location) {
                if(!empty($location) ) {
                    $has_location = true;
                }
            }
        }

        return $has_location;
    }

    /**
     * @param $vars
     */
    public static function template_redirects($vars) {

        $url_array = explode( '/', $vars->request );

        //if the first part of the URL doesn't contain location leave
        if($url_array[0] !== 'locations') {
            return;
        }

        //if it's the locations search page with no lat/long get variables
        if($url_array[0] === 'locations' && count($url_array) === 1 && (!isset($_GET['lat']) || !isset($_GET['long'])) ) {
            return;
        }

        global $location;
        global $showNewsletter;
        $showNewsletter = false;
        global $showFooter;
        set_query_var('isLocationPage', true);

        //URL is looking for a country, region, or city or lat/long get variables are set
        if( ( count($url_array) > 1 && count($url_array) <= 4 ) || ( isset($_GET['lat']) && isset($_GET['long']) ) ) {

            $location = self::set_location_results($url_array);
            $location_results = locate_template('locationResults.php');
            set_query_var('locationTemplate', 'results');
            set_query_var('mapScripts', true);
            $showFooter = false;

            if( empty($_GET['lat']) && empty($_GET['long']) ) {

                //redirect to 404 page
                if(empty($location)) {
                    wp_redirect(home_url()."/404");
                    exit;
                }

                $region = $location->locations[0]->addresses[0]->city[0]->region[0]->name;//region
                $city = $location->locations[0]->addresses[0]->city[0]->name;//city

                $center_centre = 'Centers';
                if ($url_array[1] === 'ca') {// Canadian spelling for centres
                    $center_centre = 'Centres';
                }
                if (count($url_array) === 2) {// country
                    $country = "United States";
                    if ($url_array[1] === 'ca') {// CA
                        $country = "Canadian";
                    }
                    apply_filters('pre_get_document_title', $country . ' Chiropractic ' . $center_centre . ' - Align Your Health | MaxLiving');
                    set_query_var('locationTitle', $country . ' Chiropractic ' . $center_centre . ' - Align Your Health | MaxLiving');
                }
                if (count($url_array) === 3) {// region
                    apply_filters('pre_get_document_title', $region . ' Chiropractic ' . $center_centre . ' - Align Your Health | MaxLiving');
                    set_query_var('locationTitle', $region . ' Chiropractic ' . $center_centre . ' - Align Your Health | MaxLiving');
                }
                if (count($url_array) === 4) {// city
                    apply_filters('pre_get_document_title', $city . ' Chiropractic ' . $center_centre . ' - Align Your Health | MaxLiving');
                    set_query_var('locationTitle',  $city . ' Chiropractic ' . $center_centre . ' - Align Your Health | MaxLiving');
                }
            }

            load_template($location_results);

            exit;
        }

        $location = self::set_location_details($url_array);

        //redirect to 404 page
        if(empty($location)) {
            wp_redirect(home_url()."/404");
            exit;
        }

        //single location
        set_query_var('locationTemplate', 'details');
        $location_details = locate_template('locationDetails.php');

        //Apply Title on Location Details Page
        $city = $location->locations[0]->addresses[0]->city[0]->name;//city
        apply_filters( 'pre_get_document_title', $location->locations[0]->name.' - '.$city.' Chiropractors | MaxLiving');
        set_query_var('locationTitle', $location->locations[0]->name.' - '.$city.' Chiropractors | MaxLiving');
        set_query_var('mapScripts', true);

        load_template($location_details);

        exit;
    }

    private static function set_location_results($url) {

        $query = new Functions();

        if(isset($_GET['lat']) && isset($_GET['long']) ) {
            return $query->filter_location_by_radius_on_load();
        }

        if(count($url) === 2) {
            //we have two URL parameters, query by country code
            return $query->get_location_by_country($url[1]);
        }

        if(count($url) === 3) {
            //we have two URL parameters, query by region code and country code
            return $query->get_location_by_region($url[2], $url[1]);
        }

        if(count($url) === 4) {
            //we have two URL parameters, query by region code, country code, and city slug
            return $query->get_location_by_city($url[3], $url[2], $url[1]);
        }
    }

    private static function set_location_details($url) {

        $query = new Functions();

        return $query->get_location($url[4], $url[3], $url[2], $url[1]);
    }

    public static function format_business_hours($business_hours_string) {
        if(empty($business_hours_string)){
            return;
        }
        //stripping out html special characters
        $good_json = html_entity_decode($business_hours_string);

        $business_hours = json_decode( $good_json );

        $hours_array = [];

        //format the post data so it is in an easy to use array
        foreach($business_hours as $key => $value) {
            //open
            if($value[1] === 'open') {
                //get the numbers
                $hours = '';
                $count = 1;
                foreach($value[2] as $k => $v) {
                    if($count > 1) {
                        $hours .= "<br />& $v->open - $v->closed";
                    } else {
                        $hours .= "$v->open - $v->closed";
                    }
                    ++$count;
                }
                $hours_array[ ucfirst($value[0]) ] = $hours;
            }

            //closed
            if($value[1] === 'closed') {
                $hours_array[ ucfirst($value[0]) ] = "Closed";
            }

            //by appointment
            if($value[1] === 'appointment') {
                $hours_array[ ucfirst($value[0]) ] = "By Appointment Only";
            }
        }

        //change the order of our nice new array so today's date is the first element
        $ordered_business_hours = [];
        $day_array = array(1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday');
        $today = (int)date('N');
        $on_today = true;

        foreach($hours_array as $day_name => $operating_hours) {
            foreach ($day_array as $day_num => $current_day_name) {

                $added_value = false;

                //for the first value we want the key to be 'today' not the day name
                if($day_num === $today && $on_today === true) {
                    $ordered_business_hours['Today'] = $hours_array[$current_day_name];
                    $on_today = false;

                    $added_value = true;
                }else if($day_num === $today) {
                    //add onto the array for each day as they come up relative to today
                    $ordered_business_hours[$day_array[$day_num]] = $hours_array[$current_day_name];

                    $added_value = true;
                }

                if($added_value) {
                    //increment today, if we're on 7 (sunday) kick it back to the start
                    if($today < 7) {
                        ++$today;
                    } else if($today === 7) {
                        $today = 1;
                    }
                    break;
                }

            }

        }

        return $ordered_business_hours;
    }

    public static function unformat_number($number) {
        $number = preg_replace("/[^0-9]/", "", $number);
        return $number;
    }

    public static function format_telephone($telephone) {
        $telephone = self::unformat_number($telephone);

        if(strlen($telephone) === 10){
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $telephone);
        }
        if(strlen($telephone) === 11){
            return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "+$1 $2-$3-$4", $telephone);
        }
        return $telephone;
    }
}
