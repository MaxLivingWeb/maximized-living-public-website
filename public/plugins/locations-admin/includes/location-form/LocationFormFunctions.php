<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-21
 * Time: 10:53 AM
 */

namespace MaxLiving\Location\Includes\LocationForm;

use MaxLiving\Location\Includes\CoreFunctions as CoreFunctions;

class LocationFormFunctions
{
    /**
     * @return array
     */
    public static function get_site_info() {
        //parse the query string
        \parse_str($_SERVER['QUERY_STRING'], $query_string);

        //default value -- these are when we're doing an update
        $site_info = [
            'vanity_website_url' => '',
            'site_id' => '0',
            'whitelabel' => '0',
            'action' => 'update_location',
            'form_submission' => 'Update Location'
        ];

        //if we're creating, we'll override the values above with values needed to create a location
        foreach($site_info as $key => $value) {
            if(\array_key_exists($key, $query_string)) {
                $site_info[$key] = $query_string[$key];
            }
        }

        return $site_info;
    }

    /**
     * @param $site_id
     * @return array
     */
    public static function get_location_info($site_id, $location_id) {
        //parse location information
        $location_data = (array)CoreFunctions::get_location($site_id, $location_id);

        $location = [
            'name' => '',
            'email' => '',
            'telephone' => '',
            'telephone_ext' => '',
            'fax' => '',
            'opening_date' => '',
            'closing_date' => '',
            'pre_open_display_date' => '',
            'daylight_savings_applies' => '',
            'vanity_website_url' => '',
            'vanity_website_id' => '',
            'address_1' => '',
            'address_2' => '',
            'zip_postal_code' => '',
            'latitude' => '',
            'longitude' => '',
            'city_name' => '',
            'region_name' => '',
            'country_name' => '',
            'business_hours' => '',
            'gmb_id' => ''
        ];

        if(isset($location_data['name'])) {
            $location['name'] = $location_data['name'];
        }

        if(isset($location_data['email'])) {
            $location['email'] = $location_data['email'];
        }

        if(isset($location_data['telephone'])) {
            $location['telephone'] = $location_data['telephone'];
        }

        if(isset($location_data['telephone_ext'])) {
            $location['telephone_ext'] = $location_data['telephone_ext'];
        }

        if(isset($location_data['fax'])) {
            $location['fax'] = $location_data['fax'];
        }

        if(isset($location_data['opening_date'])) {
            $location['opening_date'] = $location_data['opening_date'];
        }

        if(isset($location_data['closing_date'])) {
            $location['closing_date'] = $location_data['closing_date'];
        }

        if(isset($location_data['pre_open_display_date'])) {
            $location['pre_open_display_date'] = $location_data['pre_open_display_date'];
        }

        if(isset($location_data['daylight_savings_applies'])) {
            $location['daylight_savings_applies'] = $location_data['daylight_savings_applies'];
        }

        if(isset($location_data['vanity_website_url'])) {
            $location['vanity_website_url'] = $location_data['vanity_website_url'];
        }

        if(isset($location_data['vanity_website_id'])) {
            $location['vanity_website_id'] = $location_data['vanity_website_id'];
        }

        if(isset($location_data['addresses'][0]->address_1)) {
            $location['address_1'] = $location_data['addresses'][0]->address_1;
        }

        if(isset($location_data['addresses'][0]->address_2)) {
            $location['address_2'] = $location_data['addresses'][0]->address_2;
        }

        if(isset($location_data['addresses'][0]->zip_postal_code)) {
            $location['zip_postal_code'] = $location_data['addresses'][0]->zip_postal_code;
        }

        if(isset($location_data['addresses'][0]->latitude)) {
            $location['latitude'] = $location_data['addresses'][0]->latitude;
        }

        if(isset($location_data['addresses'][0]->longitude)) {
            $location['longitude'] = $location_data['addresses'][0]->longitude;
        }

        if(isset($location_data['addresses'][0]->city[0]->name)) {
            $location['city_name'] = $location_data['addresses'][0]->city[0]->name;
        }

        if(isset($location_data['addresses'][0]->city[0]->region[0]->name)) {
            $location['region_name'] = $location_data['addresses'][0]->city[0]->region[0]->name;
        }

        if(isset($location_data['addresses'][0]->city[0]->region[0]->country[0]->name)) {
            $location['country_name'] = $location_data['addresses'][0]->city[0]->region[0]->country[0]->name;
        }

        if(isset($location_data['business_hours'] ) ) {
            $location['business_hours'] = $location_data['business_hours'];
        }

        if(isset($location_data['gmb_id'] ) ) {
            $location['gmb_id'] = $location_data['gmb_id'];
        }

        return (array)$location;
    }

    public static function get_gmb_id($gmb_name) {

        $gmb_name_arr = explode("/", $gmb_name);

        return end($gmb_name_arr);
    }
}
