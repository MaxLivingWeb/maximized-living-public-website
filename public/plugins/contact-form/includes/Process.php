<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-22
 * Time: 3:14 PM
 */

namespace MaxLiving\ContactForm\Includes;

use Respect\Validation\Validator as v;
use GuzzleHttp;

class Process
{
    public static function contact_form() {

        //csrf token validation
        if(wp_verify_nonce($_POST['_wpnonce'], 'csrf') === false) {
            wp_redirect(wp_get_referer().'?errors[]=csrf' );
            exit;
        }

        //honeypot
        if(!empty($_POST['websiteID'])) {
            wp_redirect(wp_get_referer().'?errors[]=spam' );
            exit;
        }

        //sanitize inputs
        $form_filters = [
            'fname' => FILTER_SANITIZE_STRING,
            'lname' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL,
            'phone' => FILTER_SANITIZE_STRING,
            'category' => FILTER_SANITIZE_STRING,
            'comment' => FILTER_SANITIZE_STRING,
            'utm_campaign' => FILTER_SANITIZE_STRING,
            'utm_term' => FILTER_SANITIZE_STRING,
            'utm_source' => FILTER_SANITIZE_STRING,
            'utm_medium' => FILTER_SANITIZE_STRING,
            'utm_content' => FILTER_SANITIZE_STRING,
            'site_id' => FILTER_SANITIZE_STRING,
            'form_name' => FILTER_SANITIZE_STRING,
            'terms_of_service' => FILTER_SANITIZE_STRING
        ];

        $form_data = self::sanitize_data($form_filters, $_POST);

        //validate inputs
        $form_validation = [
            'fname' => v::stringType()->notEmpty(),
            'lname' => v::stringType()->notEmpty(),
            'email' => v::email()->notEmpty(),
            'phone' => v::phone()->notEmpty(),
            'category' => v::stringType()->notEmpty(),
            'comment' => v::stringType()->notEmpty(),
            'utm_campaign' => v::stringType(),
            'utm_term' => v::stringType(),
            'utm_source' => v::stringType(),
            'utm_medium' => v::stringType(),
            'utm_content' => v::stringType(),
            'site_id' => v::stringType()->notEmpty(),
            'form_name' => v::stringType()->notEmpty(),
            'terms_of_service' => v::stringType()->notEmpty()
        ];

        $form_errors = self::validate_data($form_validation, $form_data);

        if(empty($form_errors)) {

            //send to the contact API
            self::send_to_contact_api($form_data);

            //success, redirect to thank-you
            wp_redirect( home_url().'/thank-you?n=' . urlencode($form_data['fname']) );

            exit;
        }

        //send the user back to the form if we have errors
        self::handle_errors($form_errors, $form_data);

        return;
    }

    public static function generic_form() {

        //csrf token validation
        if(wp_verify_nonce($_POST['_wpnonce'], 'csrf') === false) {
            wp_redirect(wp_get_referer().'?errors[]=csrf' );
            exit;
        }

        //honeypot
        if(!empty($_POST['websiteID'])) {
            wp_redirect(wp_get_referer().'?errors[]=spam' );
            exit;
        }

        //sanitize inputs
        $form_filters = [
            'fname' => FILTER_SANITIZE_STRING,
            'lname' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL,
            'phone' => FILTER_SANITIZE_STRING,
            'utm_campaign' => FILTER_SANITIZE_STRING,
            'utm_term' => FILTER_SANITIZE_STRING,
            'utm_source' => FILTER_SANITIZE_STRING,
            'utm_medium' => FILTER_SANITIZE_STRING,
            'utm_content' => FILTER_SANITIZE_STRING,
            'site_id' => FILTER_SANITIZE_STRING,
            'delivery_email' => FILTER_SANITIZE_EMAIL,
            'form_name' => FILTER_SANITIZE_STRING,
            'terms_of_service' => FILTER_SANITIZE_STRING,
            'affiliate_id' => FILTER_SANITIZE_STRING
        ];

        $form_data = self::sanitize_data($form_filters, $_POST);

        //validate inputs
        $form_validation = [
            'fname' => v::stringType()->notEmpty(),
            'lname' => v::stringType()->notEmpty(),
            'email' => v::email()->notEmpty(),
            'phone' => v::phone()->notEmpty(),
            'utm_campaign' => v::stringType(),
            'utm_term' => v::stringType(),
            'utm_source' => v::stringType(),
            'utm_medium' => v::stringType(),
            'utm_content' => v::stringType(),
            'site_id' => v::stringType()->notEmpty(),
            'delivery_email' => v::email()->notEmpty(),
            'form_name' => v::stringType()->notEmpty(),
            'terms_of_service' => v::stringType()->notEmpty(),
            'affiliate_id' => v::stringType()
        ];

        $form_errors = self::validate_data($form_validation, $form_data);

        if(empty($form_errors)) {

            //send to the contact API
            $form_data['clinic']=true;
            self::send_to_contact_api($form_data);

            //success, redirect to thank-you
            wp_redirect( home_url().'/thank-you?n=' . urlencode($form_data['fname']) );

            exit;
        }

        //send the user back to the form if we have errors
        self::handle_errors($form_errors, $form_data);

        return;
    }

    public static function corporate_wellness_form() {

        //csrf token validation
        if(wp_verify_nonce($_POST['_wpnonce'], 'csrf') === false) {
            wp_redirect(wp_get_referer().'?errors[]=csrf' );
            exit;
        }

        //honeypot
        if(!empty($_POST['websiteID'])) {
            wp_redirect(wp_get_referer().'?errors[]=spam' );
            exit;
        }

        //sanitize inputs
        $form_filters = [
            'company_name' => FILTER_SANITIZE_STRING,
            'company_website' => FILTER_SANITIZE_STRING,
            'fname' => FILTER_SANITIZE_STRING,
            'lname' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL,
            'phone' => FILTER_SANITIZE_STRING,
            'utm_campaign' => FILTER_SANITIZE_STRING,
            'utm_term' => FILTER_SANITIZE_STRING,
            'utm_source' => FILTER_SANITIZE_STRING,
            'utm_medium' => FILTER_SANITIZE_STRING,
            'utm_content' => FILTER_SANITIZE_STRING,
            'site_id' => FILTER_SANITIZE_STRING,
            'delivery_email' => FILTER_SANITIZE_EMAIL,
            'form_name' => FILTER_SANITIZE_STRING,
            'terms_of_service' => FILTER_SANITIZE_STRING
        ];

        $form_data = self::sanitize_data($form_filters, $_POST);

        //validate inputs
        $form_validation = [
            'company_name' => v::stringType(),
            'company_website' => v::alnum(':/.'),
            'fname' => v::stringType()->notEmpty(),
            'lname' => v::stringType()->notEmpty(),
            'email' => v::email()->notEmpty(),
            'phone' => v::phone()->notEmpty(),
            'utm_campaign' => v::stringType(),
            'utm_term' => v::stringType(),
            'utm_source' => v::stringType(),
            'utm_medium' => v::stringType(),
            'utm_content' => v::stringType(),
            'site_id' => v::stringType()->notEmpty(),
            'delivery_email' => v::email()->notEmpty(),
            'form_name' => v::stringType()->notEmpty(),
            'terms_of_service' => v::stringType()->notEmpty()
        ];

        $form_errors = self::validate_data($form_validation, $form_data);

        if(empty($form_errors)) {

            //send to the contact API
            self::send_to_contact_api($form_data);

            //success, redirect to thank-you
            wp_redirect( home_url().'/thank-you?n=' . urlencode($form_data['fname']) );

            exit;
        }

        //send the user back to the form if we have errors
        self::handle_errors($form_errors, $form_data);

        return;
    }

    public static function my_future_form() {

        //csrf token validation
        if(wp_verify_nonce($_POST['_wpnonce'], 'csrf') === false) {
            wp_redirect(wp_get_referer().'?errors[]=csrf' );
            exit;
        }

        //honeypot
        if(!empty($_POST['websiteID'])) {
            wp_redirect(wp_get_referer().'?errors[]=spam' );
            exit;
        }

        //sanitize inputs
        $form_filters = [
            'fname' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL,
            'phone' => FILTER_SANITIZE_STRING,
            'interest' => FILTER_SANITIZE_STRING,
            'utm_campaign' => FILTER_SANITIZE_STRING,
            'utm_term' => FILTER_SANITIZE_STRING,
            'utm_source' => FILTER_SANITIZE_STRING,
            'utm_medium' => FILTER_SANITIZE_STRING,
            'utm_content' => FILTER_SANITIZE_STRING,
            'site_id' => FILTER_SANITIZE_STRING,
            'form_name' => FILTER_SANITIZE_STRING,
            'delivery_email' => FILTER_SANITIZE_EMAIL,
            'chiropractic_student' => FILTER_SANITIZE_STRING,
            'receive_emails' => FILTER_SANITIZE_STRING
        ];

        $form_data = self::sanitize_data($form_filters, $_POST);

        //validate inputs
        $form_validation = [
            'fname' => v::stringType()->notEmpty(),
            'email' => v::email()->notEmpty(),
            'phone' => v::phone()->notEmpty(),
            'interest' => v::stringType(),
            'utm_campaign' => v::stringType(),
            'utm_term' => v::stringType(),
            'utm_source' => v::stringType(),
            'utm_medium' => v::stringType(),
            'utm_content' => v::stringType(),
            'site_id' => v::stringType()->notEmpty(),
            'form_name' => v::stringType()->notEmpty(),
            'delivery_email' => v::email()->notEmpty(),
            'chiropractic_student' => v::stringType(),
            'receive_emails' => v::stringType()
        ];

        $form_errors = self::validate_data($form_validation, $form_data);

        if(empty($form_errors)) {
            //send to the contact API
            self::send_to_contact_api($form_data);

            //success, redirect to thank-you
            wp_redirect( home_url().'/myfuture-thank-you');

            exit;
        }

        //send the user back to the form if we have errors
        self::handle_errors($form_errors, $form_data);

        return;
    }

    public static function affiliate_form() {

        //csrf token validation
        if(wp_verify_nonce($_POST['_wpnonce'], 'csrf') === false) {
            wp_redirect(wp_get_referer().'?errors[]=csrf' );
            exit;
        }

        //honeypot
        if(!empty($_POST['websiteID'])) {
            wp_redirect(wp_get_referer().'?errors[]=spam' );
            exit;
        }

        //sanitize inputs
        $form_filters = [
            'affiliateName' => FILTER_SANITIZE_STRING,
            'affiliateLastName' => FILTER_SANITIZE_STRING,
            'affiliateCompany' => FILTER_SANITIZE_STRING,
            'affiliateWebsite' => FILTER_SANITIZE_STRING,
            'affiliateEmail' => FILTER_SANITIZE_EMAIL,
            'affiliatePhone' => FILTER_SANITIZE_STRING,
            'specialEvents' => FILTER_SANITIZE_STRING,

            'affiliateAddress' => FILTER_SANITIZE_STRING,
            'affiliateCountry' => FILTER_SANITIZE_STRING,
            'affiliateStateProv' => FILTER_SANITIZE_STRING,
            'affiliateCity' => FILTER_SANITIZE_EMAIL,
            'affiliateZipPostal' => FILTER_SANITIZE_STRING,
            'affiliateStateProvMissing' => FILTER_SANITIZE_STRING,
            'affiliateAddressType' => FILTER_SANITIZE_STRING,

            'shippingFName' => FILTER_SANITIZE_STRING,
            'shippingLName' => FILTER_SANITIZE_STRING,
            'shippingPhone' => FILTER_SANITIZE_STRING,
            'shippingAddress' => FILTER_SANITIZE_EMAIL,
            'shippingCountry' => FILTER_SANITIZE_STRING,
            'shippingStateProv' => FILTER_SANITIZE_STRING,
            'shippingCity' => FILTER_SANITIZE_STRING,

            'shippingZipPostal' => FILTER_SANITIZE_STRING,
            'shippingStateProvMissing' => FILTER_SANITIZE_STRING,
            'shippingAddressType' => FILTER_SANITIZE_STRING,
            'heardAbout' => FILTER_SANITIZE_EMAIL,

            'utm_campaign' => FILTER_SANITIZE_STRING,
            'utm_term' => FILTER_SANITIZE_STRING,
            'utm_source' => FILTER_SANITIZE_STRING,
            'utm_medium' => FILTER_SANITIZE_STRING,
            'utm_content' => FILTER_SANITIZE_STRING,
            'form_name' => FILTER_SANITIZE_STRING,
            'delivery_email' => FILTER_SANITIZE_EMAIL
        ];

        $form_data = self::sanitize_data($form_filters, $_POST);

        //validate inputs
        $form_validation = [
            'affiliateName' => v::stringType()->notEmpty(),
            'affiliateLastName' => v::stringType()->notEmpty(),
            'affiliateCompany' => v::stringType(),
            'affiliateWebsite' => v::alnum(':/.'),
            'affiliateEmail' => v::email()->notEmpty(),
            'affiliatePhone' => v::phone()->notEmpty(),
            'specialEvents' => v::stringType(),

            'affiliateAddress' => v::stringType()->notEmpty(),
            'affiliateCountry' => v::stringType()->notEmpty(),
            'affiliateStateProv' => v::stringType()->notEmpty(),
            'affiliateCity' => v::stringType()->notEmpty(),
            'affiliateZipPostal' => v::stringType()->notEmpty(),
            'affiliateStateProvMissing' => v::stringType(),
            'affiliateAddressType' => v::stringType(),

            'shippingFName' => v::stringType()->notEmpty(),
            'shippingLName' => v::stringType()->notEmpty(),
            'shippingPhone' => v::phone()->notEmpty(),
            'shippingAddress' => v::stringType()->notEmpty(),
            'shippingCountry' => v::stringType()->notEmpty(),
            'shippingStateProv' => v::stringType()->notEmpty(),
            'shippingCity' => v::stringType()->notEmpty(),

            'shippingZipPostal' => v::stringType()->notEmpty(),
            'shippingStateProvMissing' => v::stringType(),
            'shippingAddressType' => v::stringType(),
            'heardAbout' => v::stringType(),

            'utm_campaign' => v::stringType(),
            'utm_term' => v::stringType(),
            'utm_source' => v::stringType(),
            'utm_medium' => v::stringType(),
            'utm_content' => v::stringType(),
            'form_name' => v::stringType()->notEmpty(),
            'delivery_email' => v::email()->notEmpty()
        ];

        $form_errors = self::validate_data($form_validation, $form_data);

        if(empty($form_errors)) {

            //send to the contact API
            self::send_to_contact_api($form_data);

            //success, redirect to thank-you
            wp_redirect( home_url().'/thank-you?n=' . urlencode($form_data['affiliateName']) );

            exit;
        }

        //send the user back to the form if we have errors
        self::handle_errors($form_errors, $form_data);

        return;
    }

    public static function wholesale_form() {

        //csrf token validation
        if(wp_verify_nonce($_POST['_wpnonce'], 'csrf') === false) {
            wp_redirect(wp_get_referer().'?errors[]=csrf' );
            exit;
        }

        //honeypot
        if(!empty($_POST['websiteID'])) {
            wp_redirect(wp_get_referer().'?errors[]=spam' );
            exit;
        }

        //sanitize inputs
        $form_filters = [
            'wholesalerCompany' => FILTER_SANITIZE_STRING,
            'wholesalerAddress' => FILTER_SANITIZE_STRING,
            'wholesalerWebsite' => FILTER_SANITIZE_STRING,
            'wholesalerName' => FILTER_SANITIZE_STRING,
            'wholesalerEmail' => FILTER_SANITIZE_EMAIL,
            'wholesalerPhone' => FILTER_SANITIZE_STRING,

            'questionHeardAbout' => FILTER_SANITIZE_STRING,
            'questionInterest' => FILTER_SANITIZE_STRING,
            'questionProducts' => FILTER_SANITIZE_STRING,
            'questionYourProducts' => FILTER_SANITIZE_STRING,
            'questionBestSeller' => FILTER_SANITIZE_STRING,
            'questionYears' => FILTER_SANITIZE_STRING,
            'questionAudience' => FILTER_SANITIZE_STRING,
            'questionChiro' => FILTER_SANITIZE_STRING,
            'questionPromo' => FILTER_SANITIZE_STRING,
            'questionCompete' => FILTER_SANITIZE_STRING,
            'questionModel' => FILTER_SANITIZE_STRING,
            'questionOnline' => FILTER_SANITIZE_STRING,
            'questionCompetitor' => FILTER_SANITIZE_STRING,
            'questionDistributor' => FILTER_SANITIZE_STRING,
            'questionSelling' => FILTER_SANITIZE_STRING,

            'utm_campaign' => FILTER_SANITIZE_STRING,
            'utm_term' => FILTER_SANITIZE_STRING,
            'utm_source' => FILTER_SANITIZE_STRING,
            'utm_medium' => FILTER_SANITIZE_STRING,
            'utm_content' => FILTER_SANITIZE_STRING,
            'form_name' => FILTER_SANITIZE_STRING,
            'delivery_email' => FILTER_SANITIZE_EMAIL
        ];

        $form_data = self::sanitize_data($form_filters, $_POST);

        //validate inputs
        $form_validation = [
            'wholesalerCompany' => v::stringType()->notEmpty(),
            'wholesalerAddress' => v::stringType()->notEmpty(),
            'wholesalerWebsite' => v::alnum(':/.')->notEmpty(),
            'wholesalerName' => v::stringType()->notEmpty(),
            'wholesalerEmail' => v::email()->notEmpty(),
            'wholesalerPhone' => v::stringType()->notEmpty(),

            'questionHeardAbout' => v::stringType(),
            'questionInterest' => v::stringType(),
            'questionProducts' => v::stringType(),
            'questionYourProducts' => v::stringType(),
            'questionBestSeller' => v::stringType(),
            'questionYears' => v::stringType(),
            'questionAudience' => v::stringType(),
            'questionChiro' => v::stringType(),
            'questionPromo' => v::stringType(),
            'questionCompete' => v::stringType(),
            'questionModel' => v::stringType(),
            'questionOnline' => v::stringType(),
            'questionCompetitor' => v::stringType(),
            'questionDistributor' => v::stringType(),
            'questionSelling' => v::stringType(),

            'utm_campaign' => v::stringType(),
            'utm_term' => v::stringType(),
            'utm_source' => v::stringType(),
            'utm_medium' => v::stringType(),
            'utm_content' => v::stringType(),
            'form_name' => v::stringType()->notEmpty(),
            'delivery_email' => v::email()->notEmpty()
        ];

        $form_errors = self::validate_data($form_validation, $form_data);

        if(empty($form_errors)) {
            //send to the contact API
            self::send_to_contact_api($form_data);

            //success, redirect to thank-you
            wp_redirect( home_url().'/thank-you?n=' . urlencode($form_data['affiliateName']) );

            exit;
        }

        //send the user back to the form if we have errors
        self::handle_errors($form_errors, $form_data);

        return;
    }

    /**
     * @param $form_filters
     * @param $form_data
     * @return array
     */
    private static function sanitize_data($form_filters, $form_data) {

        $sanitized_data = [];

        foreach($form_filters as $key => $value) {
            $sanitized_data[$key] = filter_var($form_data[$key], $value);
        }

        return $sanitized_data;
    }

    /**
     * @param $form_validation
     * @param $form_data
     * @return array
     */
    private static function validate_data($form_validation, $form_data) {

        $form_errors = [];

        foreach($form_validation as $key => $value) {
            if(!$value->validate($form_data[$key]) ) {
                array_push($form_errors, $key);
            }
        }

        return $form_errors;
    }

    private static function handle_errors($form_errors, $form_data) {

        $previous_url = strtok(wp_get_referer(), '?');
        $error_query = "?";

        foreach($form_errors as $error) {
            $error_query .= "errors[]=".$error."&";
        }

        $counter = 0;
        foreach($form_data as $key => $value) {
            if($counter > 0) {
                $error_query .= "&$key=".urlencode($value);
                continue;
            }

            $error_query .= "$key=".urlencode($value);

            ++$counter;
        }

        wp_redirect( $previous_url.$error_query );

        return;
    }

    private static function send_to_contact_api($form_data) {

        $to_email = "info@maxliving.com";

        if(isset($form_data['category'] )) {
            $email_arr = explode(":", $form_data['category']);

            $to_email = $email_arr[0];

            if(isset($email_arr[1])) {
                $to_email = $email_arr[1];
            }
        }

        $vanity_website_id = 0;
        if(!empty($form_data['site_id']) ) {
            $vanity_website_id = $form_data['site_id'];
        }

        $form_name = "Form";
        if(!empty($form_data['form_name']) ) {
            $form_name = preg_replace("/[\\.\\$\\[\\]\\/#]/", "", $form_data['form_name']);
        }

        $from_name = '';
        if(!empty($form_data['fname']) ) {
            $from_name = $form_data['fname'];
        }
        if(!empty($form_data['affiliateName']) ) {
            $from_name = $form_data['affiliateName'];
        }
        if(!empty($form_data['wholesalerName']) ) {
            $from_name = $form_data['wholesalerName'];
        }

        $reply_to = '';
        if(!empty($form_data['email']) ) {
            $reply_to = $form_data['email'];
        }
        if(!empty($form_data['affiliateEmail']) ) {
            $reply_to = $form_data['affiliateEmail'];
        }
        if(!empty($form_data['wholesalerEmail']) ) {
            $reply_to = $form_data['wholesalerEmail'];
        }

        if(isset($form_data['delivery_email']) ) {
            if(!empty($form_data['delivery_email'])) {
                $to_email = $form_data['delivery_email'];
            }
        }

        $affiliate_id = null;
        if(isset($form_data['affiliate_id'])) {
            $affiliate_id = $form_data['affiliate_id'];
        }

        $formatted_form_data = '';

        if(isset($form_data['clinic'])) {
            $formatted_form_data = "<br><p>First Name: ". $form_data['fname']."</p><p>Last Name: ". $form_data['lname']."</p><p>Email: ". $form_data['email']."</p><p>Phone: ". $form_data['phone']."</p>";
        }
        else {
            foreach ( $form_data as $key => $value ) {
                $formatted_form_data .= "<p>$key: $value</p>";
            }
        }

        $api_data = [
            'to_name' => "MaxLiving $form_name Submission",
            "to_email" => $to_email,
            "from_name" => $from_name,
            "from_email" => "info@maxliving.com",
            "reply_to" => $reply_to,
            "email_subject" => "MaxLiving $form_name Submission",
            "form_name" => $form_name,
            "content_type" => "text/html",
            "content" => $formatted_form_data,
            "vanity_website_id" => $vanity_website_id,
            "template_id" => 'd-077fdd8bcaba46c2bcff83bd47112941',
            "affiliate_id" => $affiliate_id
        ];

        $client = new GuzzleHttp\Client();

        try {
            $res = $client->request('POST', env('CONTACT_API_URL'), [
                'header' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($api_data)
            ]);

        } catch (GuzzleHttp\Exception\ClientException $e) {
            return false;
        }

        return true;
    }

}
