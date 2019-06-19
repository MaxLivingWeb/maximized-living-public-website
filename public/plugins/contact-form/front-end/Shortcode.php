<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-22
 * Time: 3:14 PM
 */

namespace MaxLiving\ContactForm\FrontEnd;

use \MaxLiving\ContactForm\Includes\Process as Process;

class Shortcode
{
    public static function contact_form_generate()
    {
        if(!empty($_POST)) {
            Process::contact_form();
        }

        $errors = [];
        $fname = '';
        $lname = '';
        $email = '';
        $phone = '';
        $category = 'default'; //adding this value so we don't get a false positive when trying to repopulate dropdown
        $comment = '';
        $error_message = '';
        $utm_campaign = '';
        $utm_term = '';
        $utm_source = '';
        $utm_medium = '';
        $utm_content = '';

        foreach($_GET as $key => $value) {
            $$key = $value;
        }

        //Pulls in assets for this form
        global $contactFormScripts;
        $contactFormScripts = true;

        $site_id = get_current_blog_id();

        $category_options = [
            'discover@maxliving.com' => '',
            '1:info@maxliving.com' => '',
            'support@maxliving.com' => '',
            'resources@maxliving.com' => '',
            'events@maxliving.com' => '',
            'marketing@maxliving.com' => '',
            '2:info@maxliving.com' => '',
            'webservices@maxliving.com' => '',
            '3:info@maxliving.com' => ''
        ];

        foreach($category_options as $key => $value) {
            if($key == $category) {
                $category_options[$key] = 'selected';
                break;
            }
        }

        $send_us_a_message_description = '';
        if(get_field('send_us_a_message_description', 'contact_options')) {
            $send_us_a_message_description = '<p>' . get_field('send_us_a_message_description', 'contact_options') . '</p>';
        }

        $fname_error = '';
        $fname_error_class = '';
        if(in_array('fname', $errors)) {
            $fname_error = "<div class=\"errorMsg\">Field is required.</div>";
            $fname_error_class = 'class="error"';
        }

        $lname_error = '';
        $lname_error_class = '';
        if(in_array('lname', $errors)) {
            $lname_error = "<div class=\"errorMsg\">Field is required.</div>";
            $lname_error_class = 'class="error"';
        }

        $email_error = '';
        $email_error_class = '';
        if(in_array('email', $errors)) {
            $email_error = "<div class=\"errorMsg\">Field is required and must be a valid email address.</div>";
            $email_error_class = 'class="error"';
        }

        $phone_error = '';
        $phone_error_class = '';
        if(in_array('phone', $errors)) {
            $phone_error = "<div class=\"errorMsg\">Field is required and must be a valid phone number.</div>";
            $phone_error_class = 'class="error"';
        }

        $category_error = '';
        $category_error_class = '';
        if(in_array('category', $errors)) {
            $category_error = "<div class=\"errorMsg\">Field is required.</div>";
            $category_error_class = 'class="error"';
        }

        $comment_error = '';
        $comment_error_class = '';
        if(in_array('comment', $errors)) {
            $comment_error = "<div class=\"errorMsg\">Field is required.</div>";
            $comment_error_class = 'class="error"';
        }

        $terms_of_service_error = '';
        $terms_of_service_error_class = '';
        if(in_array('terms_of_service', $errors)) {
            $terms_of_service_error = "<div class=\"errorMsg\">Field is required.</div>";
            $terms_of_service_error_class = 'class="error"';
        }

        if(isset($_GET['errors'])){
            $error_message = '<div class="errorMsg">There was an issue with your submission, please try again.</div>';
        }

        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $current_link = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $contactForm = '
            <div class="contactFormContainer container">
                <div class="contactFormIntro centerAlign">
                    <h2>Send us a Message</h2>
                    '.$send_us_a_message_description.'
                    '.$error_message.'
                </div>
                <form id="contactForm" action="" method="post" novalidate>
                    <input type="hidden" name="utm_campaign" value="'.$utm_campaign.'"/>
                    <input type="hidden" name="utm_term" value="'.$utm_term.'"/>
                    <input type="hidden" name="utm_source" value="'.$utm_source.'"/>
                    <input type="hidden" name="utm_medium" value="'.$utm_medium.'"/>
                    <input type="hidden" name="utm_content" value="'.$utm_content.'"/>

                    <input type="hidden" name="site_id" value="'.$site_id.'" />
                    '.wp_nonce_field( 'csrf' ).'
                    <div class="websiteIDField">
                        <input title="websiteID" type="text" name="websiteID" value=""/>
                    </div>
                    <input type="hidden" name="form_name" value="'.get_the_title().' - Contact Form - '.$current_link.'">
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="contactFirstName">First Name *</label>
                            <input id="contactFirstName" '.$fname_error_class.' type="text" name="fname" value="'.$fname.'" required />
                            '.$fname_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="contactLastName">Last Name *</label>
                            <input id="contactLastName" '.$lname_error_class.' type="text" name="lname" value="'.$lname.'" required />
                            '.$lname_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="contactEmail">Email *</label>
                            <input id="contactEmail" '.$email_error_class.' type="email" name="email" value="'.$email.'" required />
                            '.$email_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="contactPhone">Phone *</label>
                            <input id="contactPhone" '.$phone_error_class.' type="tel" name="phone" value="'.$phone.'" required />
                            '.$phone_error.'
                        </div>
                    </div>
                    <div class="inputField form-group">
                        <label for="contactInquiryCategory">Inquiry Category *</label>
                        <select id="contactInquiryCategory" '.$category_error_class.' name="category" required>
                            <option value="">Select Category</option>
                            <option value="discover@maxliving.com" '.$category_options["discover@maxliving.com"].'>Becoming a ML Clinic and Franchising Opportunities</option>
                            <option value="1:info@maxliving.com" '.$category_options["1:info@maxliving.com"].'>Press/ Media Inquires</option>
                            <option value="support@maxliving.com" '.$category_options["support@maxliving.com"].'>ML Client Support</option>
                            <option value="resources@maxliving.com" '.$category_options["resources@maxliving.com"].'>Products and Online Store Support</option>
                            <option value="events@maxliving.com" '.$category_options["events@maxliving.com"].'>National Chiropractic Events for Chiropractors</option>
                            <option value="marketing@maxliving.com" '.$category_options["marketing@maxliving.com"].'>Health Information and Articles</option>
                            <option value="2:info@maxliving.com" '.$category_options["2:info@maxliving.com"].'>Current and Future Patients: MaxLiving Clinic Questions</option>
                            <option value="webservices@maxliving.com" '.$category_options["webservices@maxliving.com"].'>Web Support</option>
                            <option value="3:info@maxliving.com" '.$category_options["3:info@maxliving.com"].'>Other</option>
                        </select>
                        '.$category_error.'
                    </div>
                    <div class="inputField form-group">
                        <label for="contactComments">Comments *</label>
                        <textarea id="contactComments" '.$comment_error_class.' name="comment" required>'.$comment.'</textarea>
                        '.$comment_error.'
                    </div>
                    <div class="checkboxField">
                        <input id="termsOfService" name="terms_of_service" type="checkbox" value="1" required '.$terms_of_service_error_class.' style="transform: translateY(-4px);">
                        <label for="termsOfService">By checking this box, you agree to our <a href="'.get_home_url().'/terms">Terms of Service.</a></label>
                    </div>
                    '.$terms_of_service_error.'
                    <button class="contactSubmit button button-secondary" type="submit">Submit</button>
                </form>
            </div>';

        return $contactForm;
    }

    public static function generic_form_generate($atts, $content)
    {
        global $corporateID;
        if(!empty($_POST)) {
            Process::generic_form();
        }

        $errors = [];
        $fname = '';
        $lname = '';
        $email = '';
        $phone = '';
        $error_message = '';
        $utm_campaign = '';
        $utm_term = '';
        $utm_source = '';
        $utm_medium = '';
        $utm_content = '';

        foreach($_GET as $key => $value) {
            $$key = $value;
        }

        $site_id = get_current_blog_id();

        $passCorpID = "";
        if($corporateID) {
            $passCorpID = $corporateID;
        }

        $sectionTitle = '';
        if(get_sub_field('title')) {
            $sectionTitle = '<h2 class="title">' . get_sub_field('title') . '</h2>';
        }

        $send_us_a_message_description = '';
        if(get_sub_field('content')) {
            $send_us_a_message_description = '<div class="description">' . get_sub_field('content') . '</div>';
        }

        $delivery_email = 'info@maxliving.com';
        if(isset($atts['delivery_email']) ) {
            $delivery_email = $atts['delivery_email'];
        }

        $affiliate_id = '';
        if(isset($atts['show_affiliate_id']) ) {
            $site_affiliate_id = self::get_affiliate_id();
            $affiliate_id = '<input type="hidden" name="affiliate_id" value="'.$site_affiliate_id.'"/>';
        }

        $form_name = 'Leads Form';
        if(isset($atts['form_name']) ) {
            $form_name = $atts['form_name'];
        }

        //Pulls in assets for this form
        global $contactFormScripts;
        $contactFormScripts = true;

        $fname_error = '';
        $fname_error_class = '';
        if(in_array('fname', $errors)) {
            $fname_error = "<div class=\"errorMsg\">Field is required.</div>";
            $fname_error_class = 'class="error"';
        }

        $lname_error = '';
        $lname_error_class = '';
        if(in_array('lname', $errors)) {
            $lname_error = "<div class=\"errorMsg\">Field is required.</div>";
            $lname_error_class = 'class="error"';
        }

        $email_error = '';
        $email_error_class = '';
        if(in_array('email', $errors)) {
            $email_error = "<div class=\"errorMsg\">Field is required and must be a valid email address.</div>";
            $email_error_class = 'class="error"';
        }

        $phone_error = '';
        $phone_error_class = '';
        if(in_array('phone', $errors)) {
            $phone_error = "<div class=\"errorMsg\">Field is required and must be a valid phone number.</div>";
            $phone_error_class = 'class="error"';
        }

        $terms_of_service_error = '';
        $terms_of_service_error_class = '';
        if(in_array('terms_of_service', $errors)) {
            $terms_of_service_error = "<div class=\"errorMsg\">Field is required.</div>";
            $terms_of_service_error_class = 'class="error"';
        }

        if(isset($_GET['errors'])){
            $error_message = '<div class="errorMsg">There was an issue with your submission, please try again.</div>';
        }

        $title = get_the_title();
        if (get_query_var('isLocationPage') === true) {
            $title = 'Corporate Location';
        }

        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $current_link = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


        $contactForm = $content.'
            <div class="contactFormContainer contactFormContainer-noMargin container">
                <div class="contactFormIntro centerAlign">
                  '.$sectionTitle.'
                  '.$send_us_a_message_description.'
                  '.$error_message.'
                </div>
                <form id="requestAppointmentForm" action="" method="post">
                    <input type="hidden" name="delivery_email" value="'.$delivery_email.'"/>
                    '.wp_nonce_field( 'csrf' ).'
                    <div class="websiteIDField">
                        <input title="websiteID" type="text" name="websiteID" value=""/>
                    </div>
                    <input type="hidden" name="site_id" value="'.$site_id.'" />
                    <input type="hidden" name="form_name" value="'.$title.' - '.$form_name.' - '.$current_link.'">
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="requestAppointmentName">First Name *</label>
                            <input id="requestAppointmentName" '.$fname_error_class.' type="text" name="fname" value="'.$fname.'" required />
                            '.$fname_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="requestAppointmentLastName">Last Name *</label>
                            <input id="requestAppointmentLastName" '.$lname_error_class.' type="text" name="lname" value="'.$lname.'" required />
                            '.$lname_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="requestAppointmentEmail">Email *</label>
                            <input id="requestAppointmentEmail" '.$email_error_class.' type="email" name="email" value="'.$email.'" required />
                            '.$email_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="requestAppointmentPhone">Phone *</label>
                            <input id="requestAppointmentPhone" '.$phone_error_class.' type="tel" name="phone" value="'.$phone.'" required />
                            '.$phone_error.'
                        </div>
                    </div>
                    <div class="checkboxField">
                        <input id="termsOfService" name="terms_of_service" type="checkbox" value="1" required '.$terms_of_service_error_class.' style="transform: translateY(-4px);">
                        <label for="termsOfService">By checking this box, you agree to our <a href="'.get_home_url($passCorpID).'/terms">Terms of Service.</a></label>
                    </div>
                    '.$terms_of_service_error.'
                    <button class="contactSubmit button button-secondary" type="submit">Submit</button>
                </form>
            </div>';

        return $contactForm;
    }

    public static function corporate_wellness_form_generate($atts, $content)
    {
        global $corporateID;
        if(!empty($_POST)) {
            Process::corporate_wellness_form();
        }

        $errors = [];
        $company_name = '';
        $company_website = '';
        $fname = '';
        $lname = '';
        $email = '';
        $phone = '';
        $error_message = '';
        $utm_campaign = '';
        $utm_term = '';
        $utm_source = '';
        $utm_medium = '';
        $utm_content = '';

        foreach($_GET as $key => $value) {
            $$key = $value;
        }

        $site_id = get_current_blog_id();

        $passCorpID = "";
        if($corporateID) {
            $passCorpID = $corporateID;
        }

        $sectionTitle = '';
        if(get_sub_field('title')) {
            $sectionTitle = '<h2 class="title">' . get_sub_field('title') . '</h2>';
        }

        $send_us_a_message_description = '';
        if(get_sub_field('content')) {
            $send_us_a_message_description = '<div class="description">' . get_sub_field('content') . '</div>';
        }

        $delivery_email = 'info@maxliving.com';
        if(isset($atts['delivery_email']) ) {
            $delivery_email = $atts['delivery_email'];
        }

        $form_name = 'Corporate Wellness Form';
        if(isset($atts['form_name']) ) {
            $form_name = $atts['form_name'];
        }

        //Pulls in assets for this form
        global $contactFormScripts;
        $contactFormScripts = true;

        $company_name_error = '';
        $company_name_error_class = '';
        if(in_array('company_name', $errors)) {
            $company_name_error = "<div class=\"errorMsg\">Field must be a valid series of alphanumeric characters.</div>";
            $company_name_error_class = 'class="error"';
        }

        $company_website_error = '';
        $company_website_error_class = '';
        if(in_array('company_website', $errors)) {
            $company_website_error = "<div class=\"errorMsg\">Field must be a valid website.</div>";
            $company_website_error_class = 'class="error"';
        }

        $fname_error = '';
        $fname_error_class = '';
        if(in_array('fname', $errors)) {
            $fname_error = "<div class=\"errorMsg\">Field is required.</div>";
            $fname_error_class = 'class="error"';
        }

        $lname_error = '';
        $lname_error_class = '';
        if(in_array('lname', $errors)) {
            $lname_error = "<div class=\"errorMsg\">Field is required.</div>";
            $lname_error_class = 'class="error"';
        }

        $email_error = '';
        $email_error_class = '';
        if(in_array('email', $errors)) {
            $email_error = "<div class=\"errorMsg\">Field is required and must be a valid email address.</div>";
            $email_error_class = 'class="error"';
        }

        $terms_of_service_error = '';
        $terms_of_service_error_class = '';
        if(in_array('terms_of_service', $errors)) {
            $terms_of_service_error = "<div class=\"errorMsg\">Field is required.</div>";
            $terms_of_service_error_class = 'class="error"';
        }

        $phone_error = '';
        $phone_error_class = '';
        if(in_array('phone', $errors)) {
            $phone_error = "<div class=\"errorMsg\">Field is required and must be a valid phone number.</div>";
            $phone_error_class = 'class="error"';
        }

        if(isset($_GET['errors'])){
            $error_message = '<div class="errorMsg">There was an issue with your submission, please try again.</div>';
        }

        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $current_link = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $contactForm = $content.'
            <div class="contactFormContainer contactFormContainer-noMargin container">
                <div class="contactFormIntro centerAlign">
                  '.$sectionTitle.'
                  '.$send_us_a_message_description.'
                  '.$error_message.'
                </div>
                <form id="requestAppointmentForm" action="" method="post">
                    <input type="hidden" name="utm_campaign" value="'.$utm_campaign.'"/>
                    <input type="hidden" name="utm_term" value="'.$utm_term.'"/>
                    <input type="hidden" name="utm_source" value="'.$utm_source.'"/>
                    <input type="hidden" name="utm_medium" value="'.$utm_medium.'"/>
                    <input type="hidden" name="utm_content" value="'.$utm_content.'"/>
                    <input type="hidden" name="delivery_email" value="'.$delivery_email.'"/>
                    '.wp_nonce_field( 'csrf' ).'
                    <div class="websiteIDField">
                        <input title="websiteID" type="text" name="websiteID" value=""/>
                    </div>
                    <input type="hidden" name="site_id" value="'.$site_id.'" />
                    <input type="hidden" name="form_name" value="'.get_the_title().' - '.$form_name.' - '.$current_link.'">
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="corporateWellnessCompanyName">Company Name</label>
                            <input id="corporateWellnessCompanyName" '.$company_name_error_class.' type="text" name="company_name" value="'.$company_name.'" />
                            '.$company_name_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="corporateWellnessCompanyWebsite">Company Website</label>
                            <input id="corporateWellnessCompanyWebsite" '.$company_website_error_class.' type="url" name="company_website" value="'.$company_website.'" />
                            '.$company_website_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="requestAppointmentName">First Name *</label>
                            <input id="requestAppointmentName" '.$fname_error_class.' type="text" name="fname" value="'.$fname.'" required />
                            '.$fname_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="requestAppointmentLastName">Last Name *</label>
                            <input id="requestAppointmentLastName" '.$lname_error_class.' type="text" name="lname" value="'.$lname.'" required />
                            '.$lname_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="requestAppointmentEmail">Email *</label>
                            <input id="requestAppointmentEmail" '.$email_error_class.' type="email" name="email" value="'.$email.'" required />
                            '.$email_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="requestAppointmentPhone">Phone *</label>
                            <input id="requestAppointmentPhone" '.$phone_error_class.' type="tel" name="phone" value="'.$phone.'" required />
                            '.$phone_error.'
                        </div>
                    </div>
                    <div class="checkboxField">
                        <input id="termsOfService" name="terms_of_service" type="checkbox" value="1" required '.$terms_of_service_error_class.' style="transform: translateY(-4px);">
                        <label for="termsOfService">By checking this box, you agree to our <a href="'.get_home_url($passCorpID).'/terms">Terms of Service.</a></label>
                    </div>
                    '.$terms_of_service_error.'
                    <button class="contactSubmit button button-secondary" type="submit">Submit</button>
                </form>
            </div>';

        return $contactForm;
    }

    public static function my_future_form_generate() {

        if(!empty($_POST)) {
            Process::my_future_form();
        }

        $errors = [];
        $fname = '';
        $email = '';
        $phone = '';
        $interest = 'default'; //adding this value so we don't get a false positive when trying to repopulate dropdown
        $type = 'default';
        $error_message = '';
        $utm_campaign = '';
        $utm_term = '';
        $utm_source = '';
        $utm_medium = '';
        $utm_content = '';

        foreach($_GET as $key => $value) {
            $$key = $value;
        }

        //Pulls in assets for this form
        global $contactFormScripts;
        $contactFormScripts = true;

        $site_id = get_current_blog_id();

        $interest_options = [
            'Joining the MaxLiving professional network' => '',
            'MaxU student program' => '',
            'Carrying supplements' => '',
            'Attending chiropractic events' => ''
        ];

        foreach($interest_options as $key => $value) {
            if($key == $interest) {
                $interest_options[$key] = 'selected';
                break;
            }
        }

        $type_options = [
            'Chiropractic' => '',
            'Student' => '',
            'CA' => '',
            'Other' => ''
        ];

        foreach($type_options as $key => $value) {
            if($key == $type) {
                $type_options[$key] = 'selected';
                break;
            }
        }

        $fname_error = '';
        $fname_error_class = '';
        if(in_array('fname', $errors)) {
            $fname_error = "<div class=\"errorMsg\">Field is required.</div>";
            $fname_error_class = 'class="error"';
        }

        $email_error = '';
        $email_error_class = '';
        if(in_array('email', $errors)) {
            $email_error = "<div class=\"errorMsg\">Field is required and must be a valid email address.</div>";
            $email_error_class = 'class="error"';
        }

        $phone_error = '';
        $phone_error_class = '';
        if(in_array('phone', $errors)) {
            $phone_error = "<div class=\"errorMsg\">Field is required and must be a valid phone number.</div>";
            $phone_error_class = 'class="error"';
        }

        $interest_error = '';
        $interest_error_class = '';
        if(in_array('interest', $errors)) {
            $interest_error = "<div class=\"errorMsg\">Field is required.</div>";
            $interest_error_class = 'class="error"';
        }

        $type_error = '';
        $type_error_class = '';
        if(in_array('type', $errors)) {
            $type_error = "<div class=\"errorMsg\">Field is required.</div>";
            $type_error_class = 'class="error"';
        }

        if(isset($_GET['errors'])){
            $error_message = '<div class="errorMsg">There was an issue with your submission, please try again.</div>';
        }

        $content = '
            <div class="myFutureHeroForm" id="myFutureForm">
                '.$error_message.'
                <form id="contactForm" action="" method="post" novalidate>
                    <input type="hidden" name="utm_campaign" value="'.$utm_campaign.'"/>
                    <input type="hidden" name="utm_term" value="'.$utm_term.'"/>
                    <input type="hidden" name="utm_source" value="'.$utm_source.'"/>
                    <input type="hidden" name="utm_medium" value="'.$utm_medium.'"/>
                    <input type="hidden" name="utm_content" value="'.$utm_content.'"/>
                    <input type="hidden" name="form_name" value="'.get_the_title().' - My Future Contact Form">
                    <input type="hidden" name="site_id" value="'.$site_id.'" />
                    <input type="hidden" name="delivery_email" value="'.$delivery_email.'"/>

                    '.wp_nonce_field( 'csrf' ).'
                    <div class="websiteIDField">
                        <input title="websiteID" type="text" name="websiteID" value=""/>
                    </div>

                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="contactName">Name *</label>
                            <input id="contactName" type="text" name="fname" value="'.$fname.'"  '.$fname_error_class.' required />
                            '.$fname_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="contactEmail">Email *</label>
                            <input id="contactEmail" type="email" name="email" value="'.$email.'" '.$email_error_class.' required />
                            '.$email_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="contactPhone">Phone *</label>
                            <input id="contactPhone" type="tel" name="phone" value="'.$phone.'" '.$phone_error_class.' required />
                            '.$phone_error.'
                        </div>
                    </div>
                    <div class="inputField form-group">
                        <label for="contactInquiryCategory">I am Interested In</label>
                        <select id="contactInquiryCategory" name="interest" '.$interest_error_class.'>
                            <option value=""></option>
                            <option value="Joining the MaxLiving professional network" '.$interest_options["Joining the MaxLiving professional network"].'>Joining the MaxLiving professional network</option>
                            <option value="MaxU student program" '.$interest_options["MaxU student program"].'>MaxU student program</option>
                            <option value="Carrying supplements" '.$interest_options["Carrying supplements"].'>Carrying supplements</option>
                            <option value="Attending chiropractic events" '.$interest_options["Attending chiropractic events"].'>Attending chiropractic events</option>
                        </select>
                        '.$interest_error.'
                    </div>
                    <div class="inputField form-group">
                        <label for="contactTypeCategory">I am currently a...</label>
                        <select id="contactTypeCategory" name="type" '.$type_error_class.'>
                            <option value=""></option>
                            <option value="Chiropractic" '.$type_options["Chiropractic"].'>Chiropractic</option>
                            <option value="Student" '.$type_options["Student"].'>Student</option>
                            <option value="CA" '.$type_options["CA"].'>CA</option>
                            <option value="Other" '.$type_options["Other"].'>Other</option>
                        </select>
                        '.$type_error.'
                    </div>
                    <div class="checkboxField">
                        <input name="receive_emails" type="hidden" value="1">
                        <input id="termsOfReceiveEmails" name="receive_emails" type="checkbox" value="1" checked>
                        <label for="termsOfReceiveEmails">Subscribe to our MaxLiving Newsletter</label>
                    </div>
                    <button class="contactSubmit button button-secondary button-large" type="submit">Submit</button>
                </form>
            </div>';

        return $content;
    }

    public static function affiliate_form_generate()
    {
        if(!empty($_POST)) {
            Process::affiliate_form();
        }

        $errors = [];
        $affiliateName = '';
        $affiliateLastName = '';
        $affiliateCompany = '';
        $affiliateWebsite = '';
        $affiliateEmail = '';
        $affiliatePhone = '';
        $affiliateAddress = '';
        $affiliateCountry = '';
        $affiliateStateProv = '';
        $affiliateCity = '';
        $affiliateZipPostal = '';
        $affiliateStateProvMissing = '';
        $affiliateAddressType = '';

        $shippingFName = '';
        $shippingLName = '';
        $shippingPhone = '';
        $shippingAddress = '';
        $shippingCountry = '';
        $shippingStateProv = '';
        $shippingCity = '';
        $shippingZipPostal = '';
        $shippingStateProvMissing = '';
        $shippingAddressType = '';
        $heardAbout = '';

        $error_message = '';
        $utm_campaign = '';
        $utm_term = '';
        $utm_source = '';
        $utm_medium = '';
        $utm_content = '';

        foreach($_GET as $key => $value) {
            $$key = $value;
        }

        $countries = self::countries_array();
        $countries_mark_up = '';
        foreach($countries as $val => $name) {
            if($val == $affiliateCountry) {
                $countries_mark_up .= "<option value=\"$val\" selected>$name</option>";
                continue;
            }
            $countries_mark_up .= "<option value=\"$val\">$name</option>";
        }

        $states = self::state_provinces_array();
        $state_mark_up = '';
        foreach($states as $val => $name) {
            if($val == $affiliateStateProv) {
                $state_mark_up .= "<option value=\"$val\" selected>$name</option>";
                continue;
            }
            $state_mark_up .= "<option value=\"$val\">$name</option>";
        }

        $address_types = self::address_types_array();
        $address_types_mark_up = '';
        foreach($address_types as $val => $name) {
            if($val == $affiliateAddressType) {
                $address_types_mark_up .= "<option value=\"$val\" selected>$name</option>";
                continue;
            }
            $address_types_mark_up .= "<option value=\"$val\">$name</option>";
        }

        $shippingCountry_mark_up = '';
        foreach($countries as $val => $name) {
            if($val == $shippingCountry) {
                $shippingCountry_mark_up .= "<option value=\"$val\" selected>$name</option>";
                continue;
            }
            $shippingCountry_mark_up .= "<option value=\"$val\">$name</option>";
        }

        $shippingStateProv_mark_up = '';
        foreach($states as $val => $name) {
            if($val == $shippingStateProv) {
                $shippingStateProv_mark_up .= "<option value=\"$val\" selected>$name</option>";
                continue;
            }
            $shippingStateProv_mark_up .= "<option value=\"$val\">$name</option>";
        }

        $shippingAddress_types_mark_up = '';
        foreach($address_types as $val => $name) {
            if($val == $shippingAddressType) {
                $shippingAddress_types_mark_up .= "<option value=\"$val\" selected>$name</option>";
                continue;
            }
            $shippingAddress_types_mark_up .= "<option value=\"$val\">$name</option>";
        }

        //Pulls in assets for this form
        global $contactFormScripts;
        $contactFormScripts = true;

        $send_us_a_message_description = '';
//        if(get_field('send_us_a_message_description', 'contact_options')) {
//            $send_us_a_message_description = '<p>' . get_field('send_us_a_message_description', 'contact_options') . '</p>';
//        }

        $affiliateName_error = '';
        $affiliateName_error_class = '';
        if(in_array('affiliateName', $errors)) {
            $affiliateName_error = "<div class=\"errorMsg\">Field is required.</div>";
            $affiliateName_error_class = 'class="error"';
        }

        $affiliateLastName_error = '';
        $affiliateLastName_error_class = '';
        if(in_array('affiliateLastName', $errors)) {
            $affiliateLastName_error = "<div class=\"errorMsg\">Field is required.</div>";
            $affiliateLastName_error_class = 'class="error"';
        }

        $affiliateCompany_error = '';
        $affiliateCompany_error_class = '';
        if(in_array('affiliateCompany', $errors)) {
            $affiliateCompany_error = "<div class=\"errorMsg\">Field is must be a valid set of alphanumeric characters.</div>";
            $affiliateCompany_error_class = 'class="error"';
        }

        $affiliateWebsite_error = '';
        $affiliateWebsite_error_class = '';
        if(in_array('affiliateWebsite', $errors)) {
            $affiliateWebsite_error = "<div class=\"errorMsg\">Field is must be a valid website.</div>";
            $affiliateWebsite_error_class = 'class="error"';
        }

        $affiliateEmail_error = '';
        $affiliateEmail_error_class = '';
        if(in_array('affiliateEmail', $errors)) {
            $affiliateEmail_error = "<div class=\"errorMsg\">Field is must be a valid email address.</div>";
            $affiliateEmail_error_class = 'class="error"';
        }

        $affiliatePhone_error = '';
        $affiliatePhone_error_class = '';
        if(in_array('affiliatePhone', $errors)) {
            $affiliatePhone_error = "<div class=\"errorMsg\">Field is must be a valid phone number.</div>";
            $affiliatePhone_error_class = 'class="error"';
        }

        $affiliateAddress_error = '';
        $affiliateAddress_error_class = '';
        if(in_array('affiliateAddress', $errors)) {
            $affiliateAddress_error = "<div class=\"errorMsg\">Field is required.</div>";
            $affiliateAddress_error_class = 'class="error"';
        }

        $affiliateCountry_error = '';
        $affiliateCountry_error_class = '';
        if(in_array('affiliateCountry', $errors)) {
            $affiliateCountry_error = "<div class=\"errorMsg\">Field is required.</div>";
            $affiliateCountry_error_class = 'class="error"';
        }

        $affiliateStateProv_error = '';
        $affiliateStateProv_error_class = '';
        if(in_array('affiliateStateProv', $errors)) {
            $affiliateStateProv_error = "<div class=\"errorMsg\">Field is required.</div>";
            $affiliateStateProv_error_class = 'class="error"';
        }

        $affiliateCity_error = '';
        $affiliateCity_error_class = '';
        if(in_array('affiliateCity', $errors)) {
            $affiliateCity_error = "<div class=\"errorMsg\">Field is required.</div>";
            $affiliateCity_error_class = 'class="error"';
        }

        $affiliateZipPostal_error = '';
        $affiliateZipPostal_error_class = '';
        if(in_array('affiliateZipPostal', $errors)) {
            $affiliateZipPostal_error = "<div class=\"errorMsg\">Field is required.</div>";
            $affiliateZipPostal_error_class = 'class="error"';
        }

        $affiliateStateProvMissing_error = '';
        $affiliateStateProvMissing_error_class = '';
        if(in_array('affiliateStateProvMissing', $errors)) {
            $affiliateStateProvMissing_error = "<div class=\"errorMsg\">Field must be a valid series of alphanumeric characters.</div>";
            $affiliateStateProvMissing_error_class = 'class="error"';
        }

        $affiliateAddressType_error = '';
        $affiliateAddressType_error_class = '';
        if(in_array('affiliateAddressType', $errors)) {
            $affiliateAddressType_error = "<div class=\"errorMsg\">Field must be a valid series of alphanumeric characters.</div>";
            $affiliateAddressType_error_class = 'class="error"';
        }

        $shippingFName_error = '';
        $shippingFName_error_class = '';
        if(in_array('shippingFName', $errors)) {
            $shippingFName_error = "<div class=\"errorMsg\">Field is required.</div>";
            $shippingFName_error_class = 'class="error"';
        }

        $shippingLName_error = '';
        $shippingLName_error_class = '';
        if(in_array('shippingLName', $errors)) {
            $shippingLName_error = "<div class=\"errorMsg\">Field is required.</div>";
            $shippingLName_error_class = 'class="error"';
        }

        $shippingPhone_error = '';
        $shippingPhone_error_class = '';
        if(in_array('shippingPhone', $errors)) {
            $shippingPhone_error = "<div class=\"errorMsg\">Field is required and must be a valid phone number.</div>";
            $shippingPhone_error_class = 'class="error"';
        }

        $shippingAddress_error = '';
        $shippingAddress_error_class = '';
        if(in_array('shippingAddress', $errors)) {
            $shippingAddress_error = "<div class=\"errorMsg\">Field is required.</div>";
            $shippingAddress_error_class = 'class="error"';
        }

        $shippingCountry_error = '';
        $shippingCountry_error_class = '';
        if(in_array('shippingCountry', $errors)) {
            $shippingCountry_error = "<div class=\"errorMsg\">Field is required.</div>";
            $shippingCountry_error_class = 'class="error"';
        }

        $shippingStateProv_error = '';
        $shippingStateProv_error_class = '';
        if(in_array('shippingStateProv', $errors)) {
            $shippingStateProv_error = "<div class=\"errorMsg\">Field is required.</div>";
            $shippingStateProv_error_class = 'class="error"';
        }

        $shippingCity_error = '';
        $shippingCity_error_class = '';
        if(in_array('shippingCity', $errors)) {
            $shippingCity_error = "<div class=\"errorMsg\">Field is required.</div>";
            $shippingCity_error_class = 'class="error"';
        }

        $shippingZipPostal_error = '';
        $shippingZipPostal_error_class = '';
        if(in_array('shippingZipPostal', $errors)) {
            $shippingZipPostal_error = "<div class=\"errorMsg\">Field is required.</div>";
            $shippingZipPostal_error_class = 'class="error"';
        }

        $shippingStateProvMissing_error = '';
        $shippingStateProvMissing_error_class = '';
        if(in_array('shippingStateProvMissing', $errors)) {
            $shippingStateProvMissing_error = "<div class=\"errorMsg\">Field must be a valid series of alphanumeric characters.</div>";
            $shippingStateProvMissing_error_class = 'class="error"';
        }

        $shippingAddressType_error = '';
        $shippingAddressType_error_class = '';
        if(in_array('shippingAddressType', $errors)) {
            $shippingAddressType_error = "<div class=\"errorMsg\">Field must be a valid series of alphanumeric characters.</div>";
            $shippingAddressType_error_class = 'class="error"';
        }

        $heardAbout_error = '';
        $heardAbout_error_class = '';
        if(in_array('heardAbout', $errors)) {
            $heardAbout_error = "<div class=\"errorMsg\">Field must be a valid series of alphanumeric characters.</div>";
            $heardAbout_error_class = 'class="error"';
        }

        $contactForm = '
            <div class="contactFormContainer container">
                <div class="contactFormIntro">
                    '.$send_us_a_message_description.'
                    '.$error_message.'
                </div>
                <form id="wholesalerForm" action="" method="post" novalidate>
                    <input type="hidden" name="utm_campaign" value="'.$utm_campaign.'"/>
                    <input type="hidden" name="utm_term" value="'.$utm_term.'"/>
                    <input type="hidden" name="utm_source" value="'.$utm_source.'"/>
                    <input type="hidden" name="utm_medium" value="'.$utm_medium.'"/>
                    <input type="hidden" name="utm_content" value="'.$utm_content.'"/>
                    <input type="hidden" name="delivery_email" value="resources@maxliving.com"/>
                    '.wp_nonce_field( 'csrf' ).'
                    <div class="websiteIDField">
                        <input title="websiteID" type="text" name="websiteID" value=""/>
                    </div>
                    <input type="hidden" name="form_name" value="'.get_the_title().' - Affiliate Registration Form">
                    <h2 class="leftAlign">General Info</h2>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="affiliateName">First Name *</label>
                            <input id="affiliateName" '.$affiliateName_error_class.' type="text" name="affiliateName" value="'.$affiliateName.'" required />
                            '.$affiliateName_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="affiliateLastName">Last Name *</label>
                            <input id="affiliateLastName" '.$affiliateLastName_error_class.' type="text" name="affiliateLastName" value="'.$affiliateLastName.'" required />
                            '.$affiliateLastName_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="affiliateCompany">Your Company</label>
                            <input id="affiliateCompany" '.$affiliateCompany_error_class.' type="text" name="affiliateCompany" value="'.$affiliateCompany.'" />
                            '.$affiliateCompany_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="affiliateWebsite">Your Website</label>
                            <input id="affiliateWebsite" '.$affiliateWebsite_error_class.' type="url" name="affiliateWebsite" value="'.$affiliateWebsite.'"/>
                            '.$affiliateWebsite_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="affiliateEmail">Email *</label>
                            <input id="affiliateEmail" '.$affiliateEmail_error_class.' type="email" name="affiliateEmail" value="'.$affiliateEmail.'" required />
                            '.$affiliateEmail_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="affiliatePhone">Phone *</label>
                            <input id="affiliatePhone" '.$affiliatePhone_error_class.' type="tel" name="affiliatePhone" value="'.$affiliatePhone.'" required />
                            '.$affiliatePhone_error.'
                        </div>
                    </div>
                    <div class="checkboxField">
                        <input id="specialEvents" name="specialEvents" type="checkbox" value="1" style="transform: translateY(-4px);">
                        <label for="specialEvents">Notify me about special events at this store.</label>
                    </div>

                    <h2 class="leftAlign">Billing Address</h2>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="affiliateAddress">Address *</label>
                            <input id="affiliateAddress" '.$affiliateAddress_error_class.' type="text" name="affiliateAddress" value="'.$affiliateAddress.'" required />
                            '.$affiliateAddress_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="affiliateCountry">Country *</label>
                            <select id="affiliateCountry" '.$affiliateCountry_error_class.' name="affiliateCountry" required />
                            <option value="">Select One</option>
                            '.$countries_mark_up.'
                            </select>
                        </div>
                        <div class="inputField form-group">
                            <label for="affiliateStateProv">State / Province *</label>
                            <select id="affiliateStateProv" '.$affiliateStateProv_error_class.' name="affiliateStateProv" required />
                            <option value="">Select One</option>
                            '.$state_mark_up.'
                            </select>
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="affiliateCity">City *</label>
                            <input id="affiliateCity" '.$affiliateCity_error_class.' type="text" name="affiliateCity" value="'.$affiliateCity.'" required />
                            '.$affiliateCity_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="affiliateZipPostal">Zip / Postal Code *</label>
                            <input id="affiliateZipPostal" '.$affiliateZipPostal_error_class.' type="text" name="affiliateZipPostal" value="'.$affiliateZipPostal.'" required />
                            '.$affiliateZipPostal_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="affiliateStateProvMissing">State / Prov. Not Listed?</label>
                            <input id="affiliateStateProvMissing" '.$affiliateStateProvMissing_error_class.' type="text" name="affiliateStateProvMissing" value="'.$affiliateStateProvMissing.'"/>
                            '.$affiliateStateProvMissing_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="affiliateAddressType">Address Type</label>
                            <select id="affiliateAddressType" '.$affiliateAddressType_error_class.' name="affiliateAddressType" />
                            <option value="">Select One</option>
                            '.$address_types_mark_up.'
                            </select>
                        </div>
                    </div>
                    <h2 class="leftAlign">Shipping Address</h2>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="shippingFName">First Name *</label>
                            <input id="shippingFName" '.$shippingFName_error_class.' type="text" name="shippingFName" value="'.$shippingFName.'" required />
                            '.$shippingFName_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="shippingLName">Last Name *</label>
                            <input id="shippingLName" '.$shippingLName_error_class.' type="text" name="shippingLName" value="'.$shippingLName.'" required />
                            '.$shippingLName_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="shippingPhone">Phone *</label>
                            <input id="shippingPhone" '.$shippingPhone_error_class.' type="tel" name="shippingPhone" value="'.$shippingPhone.'" required />
                            '.$shippingPhone_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="shippingAddress">Address *</label>
                            <input id="shippingAddress" '.$shippingAddress_error_class.' type="text" name="shippingAddress" value="'.$shippingAddress.'" required />
                            '.$shippingAddress_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="shippingCountry">Country *</label>
                            <select id="shippingCountry" '.$shippingCountry_error_class.' name="shippingCountry" required />
                            <option value="">Select One</option>
                            '.$shippingCountry_mark_up.'
                            </select>
                        </div>
                        <div class="inputField form-group">
                            <label for="shippingStateProv">State / Province *</label>
                            <select id="shippingStateProv" '.$shippingStateProv_error_class.' name="shippingStateProv" required />
                            <option value="">Select One</option>
                            '.$shippingStateProv_mark_up.'
                            </select>
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="shippingCity">City *</label>
                            <input id="shippingCity" '.$shippingCity_error_class.' type="text" name="shippingCity" value="'.$shippingCity.'" required />
                            '.$shippingCity_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="shippingZipPostal">Zip / Postal Code *</label>
                            <input id="shippingZipPostal" '.$shippingZipPostal_error_class.' type="text" name="shippingZipPostal" value="'.$shippingZipPostal.'" required />
                            '.$shippingZipPostal_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="shippingStateProvMissing">State / Prov. Not Listed?</label>
                            <input id="shippingStateProvMissing" '.$shippingStateProvMissing_error_class.' type="text" name="shippingStateProvMissing" value="'.$shippingStateProvMissing.'"/>
                            '.$shippingStateProvMissing_error.'
                        </div>

                        <div class="inputField form-group">
                            <label for="shippingAddressType">Address Type</label>
                            <select id="shippingAddressType" '.$shippingAddressType_error_class.' name="shippingAddressType" />
                            <option value="">Select One</option>
                            '.$shippingAddress_types_mark_up.'
                            </select>
                        </div>
                    </div>

                    <h2 class="leftAlign">Optional Information</h2>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="heardAbout">Heard About Us?</label>
                            <textarea id="heardAbout" type="text" name="heardAbout" '.$heardAbout_error_class.'/>'.$heardAbout.'</textarea>
                            '.$heardAbout_error.'
                        </div>
                    </div>
                    <p class="terms">By completing this form, you are agreeing to the following <a href="'.get_home_url().'/terms">Terms &amp Conditions.</a></p>

                    <button class="contactSubmit button button-primary button-large" type="submit">Submit</button>
                </form>
            </div>';

        return $contactForm;
    }

    public static function wholesale_form_generate()
    {
        if(!empty($_POST)) {
            Process::wholesale_form();
        }

        $errors = [];
        $wholesalerCompany = '';
        $wholesalerAddress = '';
        $wholesalerWebsite = '';
        $wholesalerName = '';
        $wholesalerEmail = '';
        $wholesalerPhone = '';

        $questionHeardAbout = '';
        $questionInterest = '';
        $questionProducts = '';
        $questionYourProducts = '';
        $questionBestSeller = '';
        $questionYears = '';
        $questionAudience = '';
        $questionChiro = '';
        $questionPromo = '';
        $questionCompete = '';
        $questionModel = '';
        $questionOnline = '';
        $questionCompetitor = '';
        $questionDistributor = '';
        $questionSelling = '';

        $error_message = '';
        $utm_campaign = '';
        $utm_term = '';
        $utm_source = '';
        $utm_medium = '';
        $utm_content = '';

        foreach($_GET as $key => $value) {
            $$key = $value;
        }

        $yesno = array('Yes', 'No');

        $heard_about_options = array(
            'In a MaxLiving Clinic',
            'MaxLiving.com',
            'MaxLiving Clinic Website',
            'MaxLiving Patient',
            'MaxLiving Magazine',
            'Internet Search',
            'Other'
        );

        $questionHeardAbout_markup = '';
        foreach($heard_about_options as $ha) {
            if($ha == $questionHeardAbout) {
                $questionHeardAbout_markup .= "<option value=\"$ha\" selected>$ha</option>";
                continue;
            }
            $questionHeardAbout_markup .= "<option value=\"$ha\">$ha</option>";
        }

        $questionCompete_markup = '';
        foreach($yesno as $yn) {
            if($yn == $questionCompete) {
                $questionCompete_markup .= "<option value=\"$yn\" selected>$yn</option>";
                continue;
            }
            $questionCompete_markup .= "<option value=\"$yn\">$yn</option>";
        }

        $questionModel_markup = '';
        foreach($yesno as $yn) {
            if($yn == $questionModel) {
                $questionModel_markup .= "<option value=\"$yn\" selected>$yn</option>";
                continue;
            }
            $questionModel_markup .= "<option value=\"$yn\">$yn</option>";
        }

        $questionOnline_markup = '';
        foreach($yesno as $yn) {
            if($yn == $questionOnline) {
                $questionOnline_markup .= "<option value=\"$yn\" selected>$yn</option>";
                continue;
            }
            $questionOnline_markup .= "<option value=\"$yn\">$yn</option>";
        }

        $questionDistributor_markup = '';
        foreach($yesno as $yn) {
            if($yn == $questionDistributor) {
                $questionDistributor_markup .= "<option value=\"$yn\" selected>$yn</option>";
                continue;
            }
            $questionDistributor_markup .= "<option value=\"$yn\">$yn</option>";
        }

        $questionSellingOptions = [
            "Just sell at my location",
            "Just use the MaxLiving Online Affiliate Program",
            "Both"
        ];
        $questionSelling_markup = '';
        foreach($questionSellingOptions as $opt) {
            if($opt == $questionSelling) {
                $questionSelling_markup .= "<option value=\"$opt\" selected>$opt</option>";
                continue;
            }
            $questionSelling_markup .= "<option value=\"$opt\">$opt</option>";
        }

        //Pulls in assets for this form
        global $contactFormScripts;
        $contactFormScripts = true;

        $send_us_a_message_description = '';
//        if(get_field('send_us_a_message_description', 'contact_options')) {
//            $send_us_a_message_description = '<p>' . get_field('send_us_a_message_description', 'contact_options') . '</p>';
//        }

        $wholesalerCompany_error = '';
        $wholesalerCompany_error_class = '';
        if(in_array('wholesalerCompany', $errors)) {
            $wholesalerCompany_error = "<div class=\"errorMsg\">Field is required.</div>";
            $wholesalerCompany_error_class = 'class="error"';
        }

        $wholesalerAddress_error = '';
        $wholesalerAddress_error_class = '';
        if(in_array('wholesalerAddress', $errors)) {
            $wholesalerAddress_error = "<div class=\"errorMsg\">Field is required.</div>";
            $wholesalerAddress_error_class = 'class="error"';
        }

        $wholesalerWebsite_error = '';
        $wholesalerWebsite_error_class = '';
        if(in_array('wholesalerWebsite', $errors)) {
            $wholesalerWebsite_error = "<div class=\"errorMsg\">Field is required.</div>";
            $wholesalerWebsite_error_class = 'class="error"';
        }

        $wholesalerName_error = '';
        $wholesalerName_error_class = '';
        if(in_array('wholesalerName', $errors)) {
            $wholesalerName_error = "<div class=\"errorMsg\">Field is required.</div>";
            $wholesalerName_error_class = 'class="error"';
        }

        $wholesalerEmail_error = '';
        $wholesalerEmail_error_class = '';
        if(in_array('wholesalerEmail', $errors)) {
            $wholesalerEmail_error = "<div class=\"errorMsg\">Field is required.</div>";
            $wholesalerEmail_error_class = 'class="error"';
        }

        $wholesalerPhone_error = '';
        $wholesalerPhone_error_class = '';
        if(in_array('wholesalerPhone', $errors)) {
            $wholesalerPhone_error = "<div class=\"errorMsg\">Field is required.</div>";
            $wholesalerPhone_error_class = 'class="error"';
        }

        $questionHeardAbout_error = '';
        $questionHeardAbout_error_class = '';
        if(in_array('questionHeardAbout', $errors)) {
            $questionHeardAbout_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionHeardAbout_error_class = 'class="error"';
        }

        $questionInterest_error = '';
        $questionInterest_error_class = '';
        if(in_array('questionInterest', $errors)) {
            $questionInterest_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionInterest_error_class = 'class="error"';
        }

        $questionProducts_error = '';
        $questionProducts_error_class = '';
        if(in_array('questionProducts', $errors)) {
            $questionProducts_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionProducts_error_class = 'class="error"';
        }

        $questionYourProducts_error = '';
        $questionYourProducts_error_class = '';
        if(in_array('questionYourProducts', $errors)) {
            $questionYourProducts_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionYourProducts_error_class = 'class="error"';
        }

        $questionBestSeller_error = '';
        $questionBestSeller_error_class = '';
        if(in_array('questionBestSeller', $errors)) {
            $questionBestSeller_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionBestSeller_error_class = 'class="error"';
        }

        $questionYears_error = '';
        $questionYears_error_class = '';
        if(in_array('questionYears', $errors)) {
            $questionYears_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionYears_error_class = 'class="error"';
        }

        $questionAudience_error = '';
        $questionAudience_error_class = '';
        if(in_array('questionAudience', $errors)) {
            $questionAudience_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionAudience_error_class = 'class="error"';
        }

        $questionChiro_error = '';
        $questionChiro_error_class = '';
        if(in_array('questionChiro', $errors)) {
            $questionChiro_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionChiro_error_class = 'class="error"';
        }

        $questionPromo_error = '';
        $questionPromo_error_class = '';
        if(in_array('questionPromo', $errors)) {
            $questionPromo_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionPromo_error_class = 'class="error"';
        }

        $questionCompete_error = '';
        $questionCompete_error_class = '';
        if(in_array('questionCompete', $errors)) {
            $questionCompete_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionCompete_error_class = 'class="error"';
        }

        $questionModel_error = '';
        $questionModel_error_class = '';
        if(in_array('questionModel', $errors)) {
            $questionModel_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionModel_error_class = 'class="error"';
        }

        $questionOnline_error = '';
        $questionOnline_error_class = '';
        if(in_array('questionOnline', $errors)) {
            $questionOnline_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionOnline_error_class = 'class="error"';
        }

        $questionCompetitor_error = '';
        $questionCompetitor_error_class = '';
        if(in_array('questionCompetitor', $errors)) {
            $questionCompetitor_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionCompetitor_error_class = 'class="error"';
        }

        $questionDistributor_error = '';
        $questionDistributor_error_class = '';
        if(in_array('questionDistributor', $errors)) {
            $questionDistributor_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionDistributor_error_class = 'class="error"';
        }

        $questionSelling_error = '';
        $questionSelling_error_class = '';
        if(in_array('questionSelling', $errors)) {
            $questionSelling_error = "<div class=\"errorMsg\">Field must be a series of alphanumeric characters.</div>";
            $questionSelling_error_class = 'class="error"';
        }

        $contactForm = '
        <div class="contactFormContainer container">
            <div class="contactFormIntro">
                <h2 class="leftAlign">General Info</h2>
                  '.$send_us_a_message_description.'
                  '.$error_message.'
                </div>
                <form id="wholesalerForm" action="" method="post">
                    <input type="hidden" name="utm_campaign" value="'.$utm_campaign.'"/>
                    <input type="hidden" name="utm_term" value="'.$utm_term.'"/>
                    <input type="hidden" name="utm_source" value="'.$utm_source.'"/>
                    <input type="hidden" name="utm_medium" value="'.$utm_medium.'"/>
                    <input type="hidden" name="utm_content" value="'.$utm_content.'"/>
                    <input type="hidden" name="delivery_email" value="resources@maxliving.com"/>
                    '.wp_nonce_field( 'csrf' ).'
                    <div class="websiteIDField">
                        <input title="websiteID" type="text" name="websiteID" value=""/>
                    </div>
                    <input type="hidden" name="form_name" value="'.get_the_title().' - Wholesaler Form">
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="wholesalerCompany">Company Name *</label>
                            <input id="wholesalerCompany" '.$wholesalerCompany_error_class.' type="text" name="wholesalerCompany" value="'.$wholesalerCompany.'" required />
                            '.$wholesalerCompany_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="wholesalerAddress">Company Address *</label>
                            <input id="wholesalerAddress" '.$wholesalerAddress_error_class.' type="text" name="wholesalerAddress" value="'.$wholesalerAddress.'" required />
                            '.$wholesalerAddress_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="wholesalerWebsite">Company Website *</label>
                            <input id="wholesalerWebsite" '.$wholesalerWebsite_error_class.' type="url" name="wholesalerWebsite" value="'.$wholesalerWebsite.'" required />
                            '.$wholesalerWebsite_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="wholesalerName">Contact Name *</label>
                            <input id="wholesalerName" '.$wholesalerName_error_class.' type="text" name="wholesalerName" value="'.$wholesalerName.'" required />
                            '.$wholesalerName_error.'
                        </div>
                    </div>
                    <div class="inputGroup">
                        <div class="inputField form-group">
                            <label for="wholesalerEmail">Contact Email *</label>
                            <input id="wholesalerEmail" '.$wholesalerEmail_error_class.' type="email" name="wholesalerEmail" value="'.$wholesalerEmail.'" required />
                            '.$wholesalerEmail_error.'
                        </div>
                        <div class="inputField form-group">
                            <label for="wholesalerPhone">Contact Phone *</label>
                            <input id="wholesalerPhone" '.$wholesalerPhone_error_class.' type="tel" name="wholesalerPhone" value="'.$wholesalerPhone.'" required />
                            '.$wholesalerPhone_error.'
                        </div>
                    </div>

                    <h2>Questions</h2>
                    <div class="inputField form-group">
                        <label for="questionHeardAbout">How did you hear about MaxLiving?</label>
                        <select id="questionHeardAbout" '.$questionHeardAbout_error_class.' name="questionHeardAbout">
                            <option value="">Select One</option>
                            '.$questionHeardAbout_markup.'
                        </select>
                        '.$questionHeardAbout_error.'
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionInterest">What made you interested when MaxLiving was referred to you?</label>
                            <textarea id="questionInterest" '.$questionInterest_error_class.' type="text" name="questionInterest"/>'.$questionInterest.'</textarea>
                            '.$questionInterest_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionProducts">What MaxLiving product(s) are you most interested in selling or promoting?</label>
                            <textarea id="questionProducts" '.$questionProducts_error_class.' type="text" name="questionProducts"/>'.$questionProducts.'</textarea>
                            '.$questionProducts_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionYourProducts">Please provide a description of what products or services you offer?</label>
                            <textarea id="questionYourProducts" '.$questionYourProducts_error_class.' type="text" name="questionYourProducts"/>'.$questionYourProducts.'</textarea>
                            '.$questionYourProducts_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionBestSeller">What are your top selling products or services?</label>
                            <textarea id="questionBestSeller" '.$questionBestSeller_error_class.' type="text" name="questionBestSeller"/>'.$questionBestSeller.'</textarea>
                            '.$questionBestSeller_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionYears">How long have you been in business?</label>
                            <textarea class="short" id="questionYears" '.$questionYears_error_class.' type="text" name="questionYears"/>'.$questionYears.'</textarea>
                            '.$questionYears_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionAudience">Who is your target audience?</label>
                            <textarea class="short" id="questionAudience" '.$questionAudience_error_class.' type="text" name="questionAudience"/>'.$questionAudience.'</textarea>
                            '.$questionAudience_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionChiro">How do you feel your products or services relate to chiropractic, health, or fitness?</label>
                            <textarea id="questionChiro" '.$questionChiro_error_class.' type="text" name="questionChiro"/>'.$questionChiro.'</textarea>
                            '.$questionChiro_error.'
                        </div>
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionPromo">How are you gaining interest in your products or services?</label>
                            <textarea id="questionPromo" '.$questionPromo_error_class.' type="text" name="questionPromo"/>'.$questionPromo.'</textarea>
                            '.$questionPromo_error.'
                        </div>
                    </div>
                    <div class="inputField form-group">
                        <label for="questionCompete">Do you sell any products that compete with any MaxLiving products?</label>
                        <select id="questionCompete" name="questionCompete" '.$questionCompete_error_class.'>
                            <option value="">Select One</option>
                            '.$questionCompete_markup.'
                        </select>
                        '.$questionCompete_error.'
                    </div>
                    <div class="inputField form-group">
                        <label for="questionModel">Is your business model set up to sell direct, through distributors or both?</label>
                        <select id="questionModel" name="questionModel" '.$questionModel_error_class.'>
                            <option value="">Select One</option>
                            '.$questionModel_markup.'
                        </select>
                        '.$questionModel_error.'
                    </div>
                    <div class="inputField form-group">
                        <label for="questionOnline">Do you currently sell online?</label>
                        <select id="questionOnline" name="questionOnline" '.$questionOnline_error_class.'>
                            <option value="">Select One</option>
                            '.$questionOnline_markup.'
                        </select>
                        '.$questionOnline_error.'
                    </div>
                    <div class="inputGroup inputGroup-full">
                        <div class="inputField form-group">
                            <label for="questionCompetitor">Who are your biggest competitors?</label>
                            <textarea id="questionCompetitor" '.$questionCompetitor_error_class.' type="text" name="questionCompetitor"/>'.$questionCompetitor.'</textarea>
                            '.$questionCompetitor_error.'
                        </div>
                    </div>
                    <div class="inputField form-group">
                        <label for="questionDistributor">Are you currently working with other distributors/dealers?</label>
                        <select id="questionDistributor" name="questionDistributor" '.$questionDistributor_error_class.'>
                            <option value="">Select One</option>
                            '.$questionDistributor_markup.'
                        </select>
                        '.$questionDistributor_error.'
                    </div>
                    <h2>Our Program</h2>
                    <p class="bottomText">The Maximized Living Online Affiliate Program is designed to compensate you for online sales
                    originated from your online sales efforts. It is also a risk-free way of making a profit by selling ML-branded products to your customers without having to physically stock product, or use your own money to purchase it.</p>
                    <div class="inputField form-group">
                        <label for="questionSelling">Do you plan to purchase products to sell at:</label>
                        <select id="questionSelling" name="questionSelling" '.$questionSelling_error_class.'>
                            <option value="">Select One</option>
                            '.$questionSelling_markup.'
                        </select>
                        '.$questionSelling_error.'
                    </div>

                    <p class="terms">By completing this form, you are agreeing to the following <a href="'.get_home_url().'/terms">Terms &amp Conditions.</a></p>

                    <button class="contactSubmit button button-primary button-large" type="submit">Submit</button>
                </form>
            </div>';

        return $contactForm;
    }

    public static function get_affiliate_id() {

        $current_blog_id = get_current_blog_id();

        $locations_api = \getenv("LOCATIONS_API_URL");

        $response = \wp_remote_get($locations_api . "graphql?query=query+query{locations(vanity_website_id:$current_blog_id){user_group{id}}}");

        if (\is_wp_error($response)) {
            error_log($response->get_error_message());
        }

        $location = json_decode( $response["body"] );

        if(isset($location->data->locations[0]->user_group[0]->id)) {
            return $location->data->locations[0]->user_group[0]->id;
        }

        //return a zero if we couldn't find any associated affiliate_id
        return 0;
    }

    private static function countries_array() {
        return array(
            'US'=>'UNITED STATES',
            'CA'=>'CANADA'
        );
    }

    private static function state_provinces_array() {
        return array(
            'AL'=>'ALABAMA',
            'AK'=>'ALASKA',
            'AS'=>'AMERICAN SAMOA',
            'AZ'=>'ARIZONA',
            'AR'=>'ARKANSAS',
            'CA'=>'CALIFORNIA',
            'CO'=>'COLORADO',
            'CT'=>'CONNECTICUT',
            'DE'=>'DELAWARE',
            'DC'=>'DISTRICT OF COLUMBIA',
            'FM'=>'FEDERATED STATES OF MICRONESIA',
            'FL'=>'FLORIDA',
            'GA'=>'GEORGIA',
            'GU'=>'GUAM',
            'HI'=>'HAWAII',
            'ID'=>'IDAHO',
            'IL'=>'ILLINOIS',
            'IN'=>'INDIANA',
            'IA'=>'IOWA',
            'KS'=>'KANSAS',
            'KY'=>'KENTUCKY',
            'LA'=>'LOUISIANA',
            'ME'=>'MAINE',
            'MH'=>'MARSHALL ISLANDS',
            'MD'=>'MARYLAND',
            'MA'=>'MASSACHUSETTS',
            'MI'=>'MICHIGAN',
            'MN'=>'MINNESOTA',
            'MS'=>'MISSISSIPPI',
            'MO'=>'MISSOURI',
            'MT'=>'MONTANA',
            'NE'=>'NEBRASKA',
            'NV'=>'NEVADA',
            'NH'=>'NEW HAMPSHIRE',
            'NJ'=>'NEW JERSEY',
            'NM'=>'NEW MEXICO',
            'NY'=>'NEW YORK',
            'NC'=>'NORTH CAROLINA',
            'ND'=>'NORTH DAKOTA',
            'MP'=>'NORTHERN MARIANA ISLANDS',
            'OH'=>'OHIO',
            'OK'=>'OKLAHOMA',
            'OR'=>'OREGON',
            'PW'=>'PALAU',
            'PA'=>'PENNSYLVANIA',
            'PR'=>'PUERTO RICO',
            'RI'=>'RHODE ISLAND',
            'SC'=>'SOUTH CAROLINA',
            'SD'=>'SOUTH DAKOTA',
            'TN'=>'TENNESSEE',
            'TX'=>'TEXAS',
            'UT'=>'UTAH',
            'VT'=>'VERMONT',
            'VI'=>'VIRGIN ISLANDS',
            'VA'=>'VIRGINIA',
            'WA'=>'WASHINGTON',
            'WV'=>'WEST VIRGINIA',
            'WI'=>'WISCONSIN',
            'WY'=>'WYOMING',
            'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
            'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
            'AP'=>'ARMED FORCES PACIFIC',
            '--'=> '---PROVINCES---',
            'AB'=>'ALBERTA',
            'BC'=>'BRITISH COLUMBIA',
            'MB'=>'MANITOBA',
            'NB'=>'NEW BRUNSWICK',
            'NL'=>'NEWFOUNDLAND AND LABRADOR',
            'NS'=>'NOVA SCOTIA',
            'NT'=>'NORTHWEST TERRITORIES',
            'NU'=>'NUNAVUT',
            'ON'=>'ONTARIO',
            'PE'=>'PRINCE EDWARD ISLAND',
            'QC'=>'QUEBEC',
            'SK'=>'SASKATCHEWAN',
            'YT'=>'YUKON'
        );
    }

    private static function address_types_array() {
        return array(
            'RESIDENTIAL' => 'RESIDENTIAL',
            'COMMERCIAL' => 'COMMERCIAL'
        );
    }
}
