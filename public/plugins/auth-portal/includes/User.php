<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-12-13
 * Time: 4:23 PM
 */

namespace MaxLiving\AuthPortal\Includes;

use WP_REST_Request;

class User
{
    /**
     * @param WP_REST_Request $request
     * @return int
     */
    public static function create(WP_REST_Request $request) {

        $email = $request->get_param('email');
        $vanity_website_ids = $request->get_param('vanity_website_ids');
        $password = self::randomPassword();
        $username = self::usernameify($email).self::randomPassword();

        //concatenate first_name and last_name for the user name
        //create the user with the new name, wp_create_user return the user id
        $user_id = wp_create_user($username, $password, $email);

        //we got an error on user creation
        if(!is_int($user_id) ) {
            return "500 - error user was not created";
        }

        //the vanity_website_ids are not in array format
        if(!is_array($vanity_website_ids) ) {
            return "400 - vanity_website_ids must be an array";
        }

        //add new user to their site
        foreach ($vanity_website_ids as $id) {
            add_user_to_blog($id, $user_id, 'clinic_admin');
        }

        //remove user from corporate site if they are not associated with the corporate site
        if(!in_array('1', $vanity_website_ids) ){
            remove_user_from_blog( $user_id, 1 );
        }

        //probably return a success code
        return "200 - user was successfully created";
    }

    public static function delete(WP_REST_Request $request) {

        $email = $request->get_param('email');
        $user_id = email_exists($email);

        if (!$user_id) {
            return "400 - email does not exist";
        }

        $has_posts = false;

        //grab all post types
        $post_types = get_post_types();

        //check if the passed in email has any content associated with it
        foreach ($post_types as $post_type) {
            if (count_user_posts($user_id, $post_type) > 0) {
                $has_posts = true;
            }
        }

        //don't delete them if they have any content associated with them
        if ($has_posts) {
            return "400 - user has content associated with it and cannot be deleted";
        }

        $is_deleted = wpmu_delete_user( $user_id );
        if ($is_deleted) {
            return "200 - user successfully deleted";
        }

        return "500 - something went wrong";
    }

    public static function intercept_registration_email($phpmailer) {
        //clear the recipient list
        $phpmailer->clearAllRecipients();
    }

    /**
     * @return string
     */
    private static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /**
     * @param $email
     * @return mixed
     */
    private static function usernameify($email) {
        //remove all special characters and letters from the email
        return strtolower(preg_replace('/[^0-9A-Za-z\-]/', '', $email) );
    }

}
