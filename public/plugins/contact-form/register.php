<?php
/*
Plugin Name: Contact Form
Plugin URI:
Description: Handles the contact form submissions on ML childsites
Version: 1.0.0
Author: Arcane
Author URI: https://arcane.ws/
Copyright: Arcane
*/

namespace MaxLiving\ContactForm;

/**
 * Register Shortcode
 */
add_shortcode('contact_form', __NAMESPACE__.'\FrontEnd\Shortcode::contact_form_generate');
add_shortcode('generic_form', __NAMESPACE__.'\FrontEnd\Shortcode::generic_form_generate');
add_shortcode('my_future_form', __NAMESPACE__.'\FrontEnd\Shortcode::my_future_form_generate');
add_shortcode('affiliate_form', __NAMESPACE__.'\FrontEnd\Shortcode::affiliate_form_generate');
add_shortcode('wholesale_form', __NAMESPACE__.'\FrontEnd\Shortcode::wholesale_form_generate');
add_shortcode('corporate_wellness_form', __NAMESPACE__.'\FrontEnd\Shortcode::corporate_wellness_form_generate');
