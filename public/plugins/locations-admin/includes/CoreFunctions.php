<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-21
 * Time: 10:38 AM
 */

namespace MaxLiving\Location\Includes;

class CoreFunctions
{
    //create the site with our custom
    public static function create_site()
    {
        //format and sanitize inputs
        $domain = \str_replace(["http://", "https://"], "", home_url());
        $vanity_website_url = "/" . \filter_var($_POST['vanity_website_url'], FILTER_SANITIZE_STRING);
        $whitelabel = 0;//white label is disabled by default
        if (isset($_POST['whitelabel'])) {
            if (\filter_var($_POST['whitelabel'], FILTER_SANITIZE_STRING) === 'on') {
                $whitelabel = 1;//whitelabel is enabled
            }
        }

        $site_title = \filter_var($_POST['name'], FILTER_SANITIZE_STRING);

        //create the site
        \wpmu_create_blog($domain, $vanity_website_url, $site_title, get_current_user_id());

        //get the newly created sites id, which is the site id which will be used to tie the location to the site
        $site_id = \get_id_from_blogname($vanity_website_url);

        switch_to_blog($site_id);

        //Change default theme to ml_clinic
	    add_option('initial_theme',true);//initial theme
        switch_theme('ml_clinic_v2', 'ml_clinic');

        // Set permalink structure
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%');
        $wp_rewrite->flush_rules();

        // Find and delete the WP default 'Sample Page'
        $defaultPage = get_page_by_title('Sample Page');
        if ($defaultPage != NULL) {
            wp_delete_post($defaultPage->ID, $bypass_trash = true);
        }
        // Find and delete the WP default 'Hello world!' post
        $defaultPost = get_posts(array('title' => 'Hello World!'));
        if ($defaultPost != NULL) {
            wp_delete_post($defaultPost[0]->ID, $bypass_trash = true);
        }

        // Create clinic home page
        $home_page = array(
            'post_type' => 'page',
            'post_title' => ''.get_bloginfo( 'name' ). ' | MaxLiving',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => '',
            'page_template' => 'home.php'
        );
        $post_id = wp_insert_post($home_page);
        update_option('blog_public', '1');
        update_option('page_on_front', $post_id);
        update_option('show_on_front', 'page');

        // Create clinic about page
        $about_page = array(
            'post_type' => 'page',
            'post_title' => 'Our Team',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'our-team',
            'page_template' => 'about.php'
        );
        wp_insert_post($about_page);

        // Create doctors blog page
        $doctorsBlog_page = array(
            'post_type' => 'page',
            'post_title' => 'Doctor\'s Blog',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'doctors-blog',
            'page_template' => 'doctors-blog.php'
        );
        wp_insert_post($doctorsBlog_page);

        // Create Request Appointment page
        $signup_page = array(
            'post_type' => 'page',
            'post_title' => 'Request Appointment',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'sign-up',
            'page_template' => 'sign-up.php'
        );
        $post_id = wp_insert_post($signup_page);

        // Create privacy policy page
        $privacy_page = array(
            'post_type' => 'page',
            'post_title' => 'Security & Privacy',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'security-privacy',
            'page_template' => 'privacy-policy.php'
        );
        $post_id = wp_insert_post($privacy_page);
        update_post_meta($post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/security-privacy');
        update_post_meta($post_id, '_yoast_wpseo_title', 'Security & Privacy');

        // Create terms page
        $terms_page = array(
            'post_type' => 'page',
            'post_title' => 'Terms Of Service',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'terms',
            'page_template' => 'terms-conditions.php'
        );
        $post_id = wp_insert_post($terms_page);
        update_post_meta($post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/terms');
        update_post_meta($post_id, '_yoast_wpseo_title', 'Terms Of Service');

        // Create clinic thank you page
        $clinicThankYou_page = array(
            'post_type' => 'page',
            'post_title' => 'Thank You',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'thank-you',
            'page_template' => 'thank-you.php'
        );
        $post_id = wp_insert_post($clinicThankYou_page);
        update_post_meta($post_id, '_yoast_wpseo_meta-robots-noindex', '1');
        update_post_meta($post_id, '_yoast_wpseo_meta-robots-nofollow', '1');

        // Excluding from Sitemap
        $option = get_option("wpseo_xml");
        $option['excluded-posts'] = "$post_id";
        update_option('wpseo_xml', $option);

        // Create sitemap page
        $sitemap_page = array(
            'post_type' => 'page',
            'post_title' => 'Sitemap',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'sitemap',
            'page_template' => 'sitemap.php'
        );
        $post_id = wp_insert_post($sitemap_page);

        //Five Essentials
        $fiveEssential_page = array(
            'post_type' => 'page',
            'post_title' => 'Five Essentials',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'five-essentials',
            'page_template' => 'five-essentials.php'
        );
        $fiveEssentialsPost_ID = wp_insert_post($fiveEssential_page);
        update_post_meta($fiveEssentialsPost_ID, '_yoast_wpseo_canonical', get_home_url(1) . '/five-essentials');
        update_post_meta($fiveEssentialsPost_ID, '_yoast_wpseo_title', '5 Essentials - Our Holistic Approach To Health');

        //Five Essentials - Core
        $fiveEssentialCore_page = array(
            'post_type' => 'page',
            'post_title' => 'Core Chiropractic',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'core-chiropractic',
            'page_template' => 'essential-core-chiropractic.php',
            'post_parent' => $fiveEssentialsPost_ID
        );
        $post_id = wp_insert_post($fiveEssentialCore_page);
        update_post_meta($post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/five-essentials/core-chiropractic');
        update_post_meta($post_id, '_yoast_wpseo_title', 'Core Chiropractic - 5 Essentials To Healthy Living');

        //Five Essentials - Nutrition
        $fiveEssentialNutrition_page = array(
            'post_type' => 'page',
            'post_title' => 'Nutrition',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'nutrition',
            'page_template' => 'essential-nutrition.php',
            'post_parent' => $fiveEssentialsPost_ID
        );
        $post_id = wp_insert_post($fiveEssentialNutrition_page);
        update_post_meta($post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/five-essentials/nutrition');
        update_post_meta($post_id, '_yoast_wpseo_title', 'Nutrition - 5 Essentials To Healthy Living');

        //Five Essentials - Mindset
        $fiveEssentialMindset_page = array(
            'post_type' => 'page',
            'post_title' => 'Mindset',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'mindset',
            'page_template' => 'essential-mindset.php',
            'post_parent' => $fiveEssentialsPost_ID
        );
        $post_id = wp_insert_post($fiveEssentialMindset_page);
        update_post_meta($post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/five-essentials/mindset');
        update_post_meta($post_id, '_yoast_wpseo_title', 'Mindset - 5 Essentials To Healthy Living');

        //Five Essentials - Oxygen & Exercise
        $fiveEssentialOxygen_page = array(
            'post_type' => 'page',
            'post_title' => 'Oxygen & Exercise',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'oxygen-and-exercise',
            'page_template' => 'essential-oxygen-and-exercise.php',
            'post_parent' => $fiveEssentialsPost_ID
        );
        wp_insert_post($fiveEssentialOxygen_page);
        update_post_meta($post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/five-essentials/oxygen-and-exercise');
        update_post_meta($post_id, '_yoast_wpseo_title', 'Oxygen & Exercise - 5 Essentials To Healthy Living');

        //Five Essentials - Minimize Toxins
        $fiveEssentialToxin_page = array(
            'post_type' => 'page',
            'post_title' => 'Minimize Toxins',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'minimize-toxins',
            'page_template' => 'essential-minimize-toxins.php',
            'post_parent' => $fiveEssentialsPost_ID
        );
        $post_id = wp_insert_post($fiveEssentialToxin_page);
        update_post_meta($post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/five-essentials/minimize-toxins');
        update_post_meta($post_id, '_yoast_wpseo_title', 'Minimize Toxins - 5 Essentials To Healthy Living');

        // home-care-videos/
        $home_care_videos_page = array(
            'post_type' => 'page',
            'post_title' => 'Home Care Videos',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'home-care-videos',
            'page_template' => 'home-care-videos.php'
        );
        $home_care_videos_ID = wp_insert_post($home_care_videos_page);
        update_post_meta($home_care_videos_ID, '_yoast_wpseo_title', 'Home Care Videos | MaxLiving');

        // power-of-chiropractic/
        $power_of_chiropractic_post_id = 171;
        restore_current_blog();
        switch_to_blog(1);
        $post = get_post($power_of_chiropractic_post_id, ARRAY_A);
        if ($post) {

            $post['ID'] = ''; // empty id field, to tell wordpress that this will be a new post
            $meta = get_post_meta($power_of_chiropractic_post_id);
            restore_current_blog();

            switch_to_blog($site_id);

            $inserted_post_id = wp_insert_post($post); // insert the post

            //update post meta
            foreach ($meta as $key => $value) {
                update_post_meta($inserted_post_id, $key, $value[0]);
            }
        }
        update_post_meta($inserted_post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/power-of-chiropractic');
        update_post_meta($inserted_post_id, '_yoast_wpseo_title', 'The Power Of Chiropractic');

        switch_to_blog(1);
        //  image
        $imagePostId = get_post_meta($power_of_chiropractic_post_id)['_thumbnail_id'][0];
        $image = getenv('AWS_CLOUDFRONT_URL') . get_post_meta($imagePostId, 'amazonS3_info')[0]['key'];
        restore_current_blog();

        // sideload image returns an HTML image, not an ID
        $media = media_sideload_image($image, $inserted_post_id);

        // therefore we must find it so we can set it as featured ID
        if (!empty($media) && !is_wp_error($media)) {
            $args = array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_status' => 'any',
                'post_parent' => $inserted_post_id
            );

            // reference new image to set as featured
            $attachments = get_posts($args);

            if (isset($attachments) && is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    // grab source of full size images (so no 300x150 nonsense in path)
                    $image = wp_get_attachment_image_src($attachment->ID, 'full');
                    // determine if in the $media image we created, the string of the URL exists
                    if (strpos($media, $image[0]) !== false) {
                        // if so, we found our image. set it as thumbnail
                        set_post_thumbnail($inserted_post_id, $attachment->ID);
                        // only want one image
                        break;
                    }
                }
            }
        }
	    $pcImages = array(
		    'flexible_content_1_content_with_image_0_image',
		    'flexible_content_1_content_with_image_1_image' ,
		    'flexible_content_1_content_with_image_2_image',
		    'flexible_content_2_content_with_image_0_image'
	    );
	    require_once( ABSPATH . 'wp-admin/includes/image.php' ); // required for uploading image
	    foreach ( $pcImages as $corporate_image_field ) {
		    switch_to_blog( 1 );
		    $image_id = get_post_meta( 171, $corporate_image_field )[0];
		    $image    = getenv( 'AWS_CLOUDFRONT_URL' ) . get_post_meta( $image_id, 'amazonS3_info' )[0]['key'];
		    restore_current_blog();
		    // Setting variables
		    $page_id = get_page_by_path( 'power-of-chiropractic' )->ID;
		    $upload     = wp_upload_dir();
		    $image_data = file_get_contents( $image );
		    $filename   = basename( $image );
		    $file = $upload['basedir'] . '/' . $filename;
		    if ( wp_mkdir_p( $upload['path'] ) ) {
			    $file = $upload['path'] . '/' . $filename;
		    }
		    file_put_contents( $file, $image_data );
		    $file_type = wp_check_filetype( $filename );
		    $attachment = array(
			    'post_mime_type' => $file_type['type'],
			    'post_title'     => sanitize_file_name( $filename ),
			    'post_content'   => '',
			    'post_status'    => 'inherit'
		    );
		    // Create image
		    $attach_id   = wp_insert_attachment( $attachment, $file, $page_id );
		    update_post_meta( $page_id, $corporate_image_field, $attach_id );
	    }


        // success-stories/
        $success_stories_post_id = 208;
        restore_current_blog();
        switch_to_blog(1);
        $post = get_post($success_stories_post_id, ARRAY_A);
        if ($post) {

            $post['ID'] = ''; // empty id field, to tell wordpress that this will be a new post
            $meta = get_post_meta($success_stories_post_id);
            restore_current_blog();

            switch_to_blog($site_id);

            $inserted_post_id = wp_insert_post($post); // insert the post

            //update post meta
            foreach ($meta as $key => $value) {
                update_post_meta($inserted_post_id, $key, $value[0]);
            }
        }
        update_post_meta($inserted_post_id, '_yoast_wpseo_canonical', get_home_url(1) . '/success-stories');
        update_post_meta($inserted_post_id, '_yoast_wpseo_title', 'Patient Success Stories - The Power Of Chiropractic');

        switch_to_blog(1);
        //  image
        $imagePostId = get_post_meta($success_stories_post_id)['_thumbnail_id'][0];
        $image = getenv('AWS_CLOUDFRONT_URL') . get_post_meta($imagePostId, 'amazonS3_info')[0]['key'];
        restore_current_blog();

        // magic sideload image returns an HTML image, not an ID
        $media = media_sideload_image($image, $inserted_post_id);

        // therefore we must find it so we can set it as featured ID
        if (!empty($media) && !is_wp_error($media)) {
            $args = array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_status' => 'any',
                'post_parent' => $inserted_post_id
            );

            // reference new image to set as featured
            $attachments = get_posts($args);

            if (isset($attachments) && is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    // grab source of full size images (so no 300x150 nonsense in path)
                    $image = wp_get_attachment_image_src($attachment->ID, 'full');
                    // determine if in the $media image we created, the string of the URL exists
                    if (strpos($media, $image[0]) !== false) {
                        // if so, we found our image. set it as thumbnail
                        set_post_thumbnail($inserted_post_id, $attachment->ID);
                        // only want one image
                        break;
                    }
                }
            }
        }

        // Create patient paperwork page
        $patientPaperwork_page = array(
            'post_type' => 'page',
            'post_title' => 'Patient Paperwork',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'patient-paperwork',
            'page_template' => 'page.php'
        );
        $post_id = wp_insert_post($patientPaperwork_page);
        update_post_meta($post_id, '_yoast_wpseo_meta-robots-noindex', '1');
        update_post_meta($post_id, '_yoast_wpseo_meta-robots-nofollow', '1');
        update_post_meta($post_id, 'header_title', 'New Patients');
        update_post_meta($post_id, 'header_desc', 'Save time before your first appointment by completing our new patient paperwork.');
        update_post_meta($post_id, 'show_below_header_section', '1');
        update_post_meta($post_id, 'below_header_title', 'New Patient Paperwork');
        update_post_meta($post_id, 'below_header_body', 'New to our clinic? We offer our patient forms online so you can complete them in the convenience of your own home. Feel free to download, print, and complete the forms before your visit. Make sure all of your paperwork is filled out as thoroughly as possible — this helps us provide you with the best possible care. If you have any questions, don’t hesitate to contact our clinic for help.');
        update_post_meta($post_id, 'flexible_content', 'a:1:{i:0;s:13:"pdf_downloads";}');
        update_post_meta($post_id, '_flexible_content', 'field_5a00aa11259da');

        switch_to_blog(1);
        //  image
        $imagePostId = get_post_meta(get_page_by_path('patient-paperwork-clinic-site-template-protected-page')->ID)['_thumbnail_id'][0];
        $image = getenv('AWS_CLOUDFRONT_URL') . get_post_meta($imagePostId, 'amazonS3_info')[0]['key'];
        restore_current_blog();
        $inserted_post_id = $post_id;
        // magic sideload image returns an HTML image, not an ID
        $media = media_sideload_image($image, $inserted_post_id);

        // therefore we must find it so we can set it as featured ID
        if (!empty($media) && !is_wp_error($media)) {
            $args = array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_status' => 'any',
                'post_parent' => $inserted_post_id
            );

            // reference new image to set as featured
            $attachments = get_posts($args);

            if (isset($attachments) && is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    // grab source of full size images (so no 300x150 nonsense in path)
                    $image = wp_get_attachment_image_src($attachment->ID, 'full');
                    // determine if in the $media image we created, the string of the URL exists
                    if (strpos($media, $image[0]) !== false) {
                        // if so, we found our image. set it as thumbnail
                        set_post_thumbnail($inserted_post_id, $attachment->ID);
                        // only want one image
                        break;
                    }
                }
            }
        }

        // Adding default Event Categories
        wp_insert_term(
            'Community Education',
            'event_categories',
            array(
                'description' => '',
                'slug' => 'community-education'
            )
        );
        wp_insert_term(
            'Professional Development',
            'event_categories',
            array(
                'description' => '',
                'slug' => 'professional-development'
            )
        );

        if ($whitelabel === 1) { // Switch theme to white label if white label is selected
            switch_theme('ml_whitelabel', 'ml_whitelabel');
        }

        restore_current_blog();

        //redirect to the location creation page
        $redirect_url = \network_admin_url("admin.php?page=network-location-form&whitelabel=$whitelabel&vanity_website_url=" . urlencode($vanity_website_url) . "&site_id=" . urlencode($site_id) . "&action=create_location&form_submission=" . \urlencode('Create Location'));
        \header('Location: ' . $redirect_url);
    }

    /**
     * @param null $id
     * @return null|object
     */
    public static function get_location($vanity_website_id = null, $location_id = null)
    {
        if (empty($vanity_website_id) && empty($location_id)) {
            return null;
        }

        $locations_api = \getenv("LOCATIONS_API_URL");

        $query_param = "vanity_website_id:$vanity_website_id";
        if (!empty($location_id)) {
            $query_param = "id:$location_id";
        }


        $response = \wp_remote_get($locations_api . "graphql?query=query+query{locations($query_param){name,email,telephone,telephone_ext,fax,opening_date,closing_date,pre_open_display_date,daylight_savings_applies,vanity_website_id,whitelabel,vanity_website_url,business_hours,gmb_id,addresses{address_1,address_2,zip_postal_code,latitude,longitude,city{name,region{name,abbreviation,country{name,abbreviation}}}}}}");

        if (\is_wp_error($response)) {
            error_log($response->get_error_message());
        }

        $location = json_decode($response["body"]);

        if (!empty($location->data->locations)) {
            return (object)$location->data->locations[0];
        }

        return '';
    }

    //send the request to the API to update the location site id
    public static function update_location_site_id()
    {

        //format data into consumable graphql query
        $location_id = \filter_var($_POST['location_id'], FILTER_SANITIZE_NUMBER_INT);
        $vanity_website_id = \filter_var($_POST['vanity_website_id'], FILTER_SANITIZE_NUMBER_INT);
        $id_param = "id:$location_id,vanity_website_id:$vanity_website_id";

        //hit the api
        $update_endpoint = \getenv("LOCATIONS_API_URL") . "graphql?query=mutation+mutation{updateLocationSiteID($id_param){name}}";

        $response = \wp_remote_post($update_endpoint, array('method' => "POST"));

        if (\is_wp_error($response)) {
            \error_log($response->get_error_message());
        }

        $redirect_url = \get_bloginfo("url") . "/wp-admin/admin.php?page=location-details";

        //location_id is set, so that means it's an update from the network sites so redirect the user back there
        if (isset($location_id)) {
            $redirect_url = \get_bloginfo("url") . "/wp-admin/network/admin.php?page=network-location-form&action=update_location&form_submission=Update+Location&location_id=$location_id";
        }
        \header("Location: " . $redirect_url);
        exit;
    }

    //send the request to the API to update the location
    public static function update_location()
    {
        $name = '"' . self::sanitize_string($_POST['name']) . '"';
        $daylight_savings_applies = 0;
        if (!empty($_POST['daylight_savings_applies'])) {
            $daylight_savings_applies = \filter_var($_POST['daylight_savings_applies'], FILTER_SANITIZE_NUMBER_INT);
        }
        $telephone = '"' . self::sanitize_string($_POST['telephone']) . '"';
        $telephone_ext = '"' . self::sanitize_string($_POST['telephone_ext']) . '"';
        $fax = '"' . self::sanitize_string($_POST['fax']) . '"';
        $email = '"' . self::sanitize_string($_POST['email']) . '"';
        $vanity_website_url = '"' . self::sanitize_string($_POST['vanity_website_url']) . '"';
        $pre_open_display_date = '"' . self::sanitize_string($_POST['pre_open_display_date']) . '"';
        $opening_date = '"' . self::sanitize_string($_POST['opening_date']) . '"';
        $closing_date = '"' . self::sanitize_string($_POST['closing_date']) . '"';
        $vanity_website_id = \filter_var($_POST['vanity_website_id'], FILTER_SANITIZE_NUMBER_INT);

        $address = '[';
        foreach ($_POST['addresses'] as $address_info) {

            $latitude = 43.6532;//default value
            if (!empty($address_info['latitude'])) {
                $latitude = $address_info['latitude'];
            }

            $longitude = -79.3832;//default value
            if (!empty($address_info['longitude'])) {
                $longitude = $address_info['longitude'];
            }

            $locationName = \filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $locationCity = \filter_var($address_info['city'], FILTER_SANITIZE_STRING);

            $address .= '{';
            $address .= 'address_1:"' . self::sanitize_string($address_info['address1']) . '",address_2:"' . self::sanitize_string($address_info['address2']) . '",city:"' . self::sanitize_string($address_info['city']) . '",region:"' . self::sanitize_string($address_info['region']) . '",country:"' . self::sanitize_string($address_info['country']) . '",zip_postal_code:"' . self::sanitize_string($address_info['zip_postal_code']) . '",latitude:' . $latitude . ',longitude:' . $longitude . ',address_type:1';
            $address .= '}';
        }
        $address .= ']';

        $business_hours = self::format_business_hours();
        $business_hours = str_replace('"', '\"', $business_hours);
        $business_hours = '"' . $business_hours . '"';

        //format data into consumable graphql query
        //hardcoding an id that won't resolve to anything because it needs something in there
        $id_param = "id:0,vanity_website_id:$vanity_website_id";
        if (isset($_POST['location_id'])) {
            $location_id = filter_var($_POST['location_id'], FILTER_SANITIZE_NUMBER_INT);
            $id_param = "id:$location_id,vanity_website_id:$vanity_website_id";
        }

        $gmb_transmission = '';
        //if we want to remove the GMB association send a blank record for gmb_id
        if(!empty($_POST['gmb_id_remove']) ) {
            $gmb_transmission = 'gmb_id:""';
        } else { //if not send the existing gmb_id which is stored in a hidden input
            $gmb_transmission = 'gmb_id:"'.$_POST['gmb_id'].'"';
        }

        $query = "$id_param,name:$name,daylight_savings_applies:$daylight_savings_applies,telephone:$telephone,telephone_ext:$telephone_ext,fax:$fax,email:$email,vanity_website_url:$vanity_website_url,pre_open_display_date:$pre_open_display_date,opening_date:$opening_date,closing_date:$closing_date,$gmb_transmission,addresses:$address,business_hours:$business_hours";

        //hit the api
        $update_endpoint = \getenv("LOCATIONS_API_URL") . "graphql?query=mutation+mutation{updateLocation($query){name}}";

        $response = \wp_remote_post($update_endpoint, array('method' => "POST"));

        if (\is_wp_error($response)) {
            \error_log($response->get_error_message());
        }

        if ($vanity_website_id < 10000 && $vanity_website_id != 0) {
            update_post_meta(get_option( 'page_on_front' ), '_yoast_wpseo_metadesc', 'Welcome to ' . $locationName . ', ' . $locationCity . '! Trust our expert team with your chiropractic care and discover your wellness today.');
            $post_id = get_page_by_path('our-team')->ID;
            if (get_option('stylesheet') === 'ml_whitelabel') {
                update_post_meta($post_id, '_yoast_wpseo_metadesc', 'The team at ' . $locationName . ', ' . $locationCity . ' is here to help you live a life of health and wellness. Get started today.');
            } else {
                update_post_meta($post_id, '_yoast_wpseo_metadesc', 'The MaxLiving team at ' . $locationName . ', ' . $locationCity . ' is here to help you live a life of health and wellness. Get started today.');
            }
        }

        $redirect_url = \get_bloginfo("url") . "/wp-admin/admin.php?page=location-details";

        //location_id is set, so that means it's an update from the network sites so redirect the user back there
        if (isset($location_id)) {
            $redirect_url = \get_bloginfo("url") . "/wp-admin/network/admin.php?page=network-location-form&action=update_location&form_submission=Update+Location&location_id=$location_id";
        }
        \header("Location: " . $redirect_url);
        exit;
    }

    //send the call to the api to create a location
    public static function create_location()
    {
        $name = '"' . self::sanitize_string($_POST['name']) . '"';
        $daylight_savings_applies = 0;
        if (!empty($_POST['daylight_savings_applies'])) {
            $daylight_savings_applies = \filter_var($_POST['daylight_savings_applies'], FILTER_SANITIZE_NUMBER_INT);
        }
        $telephone = '"' . self::sanitize_string($_POST['telephone']) . '"';
        $telephone_ext = '"' . self::sanitize_string($_POST['telephone_ext']) . '"';
        $fax = '"' . self::sanitize_string($_POST['fax']) . '"';
        $email = '"' . self::sanitize_string($_POST['email']) . '"';
        $vanity_website_url = '"' . self::sanitize_string($_POST['vanity_website_url']) . '"';
        $pre_open_display_date = '"' . self::sanitize_string($_POST['pre_open_display_date']) . '"';
        $opening_date = '"' . self::sanitize_string($_POST['opening_date']) . '"';
        $closing_date = '"' . self::sanitize_string($_POST['closing_date']) . '"';
        $vanity_website_id = \filter_var($_POST['vanity_website_id'], FILTER_SANITIZE_NUMBER_INT);
        $whitelabel = \filter_var($_POST['whitelabel'], FILTER_SANITIZE_NUMBER_INT);

        $address = '[';
        foreach ($_POST['addresses'] as $address_info) {

            $latitude = 43.6532;//default value
            if (!empty($address_info['latitude'])) {
                $latitude = $address_info['latitude'];
            }

            $longitude = -79.3832;//default value
            if (!empty($address_info['longitude'])) {
                $longitude = $address_info['longitude'];
            }

            $address .= '{';
            $address .= 'address_1:"' . self::sanitize_string($address_info['address1']) . '",address_2:"' . self::sanitize_string($address_info['address2']) . '",city:"' . self::sanitize_string($address_info['city']) . '",region:"' . self::sanitize_string($address_info['region']) . '",country:"' . self::sanitize_string($address_info['country']) . '",zip_postal_code:"' . self::sanitize_string($address_info['zip_postal_code']) . '",latitude:' . $latitude . ',longitude:' . $longitude . ',address_type:1';
            $address .= '}';
        }
        $address .= ']';

        $business_hours = self::format_business_hours();
        $business_hours = str_replace('"', '\"', $business_hours);
        $business_hours = '"' . $business_hours . '"';

        //format data into consumable graphql query
        $query = "name:$name,daylight_savings_applies:$daylight_savings_applies,telephone:$telephone,telephone_ext:$telephone_ext,fax:$fax,email:$email,vanity_website_url:$vanity_website_url,vanity_website_id:$vanity_website_id,whitelabel:$whitelabel,pre_open_display_date:$pre_open_display_date,opening_date:$opening_date,closing_date:$closing_date,addresses:$address,business_hours:$business_hours";

        //hit the api
        $update_endpoint = \getenv("LOCATIONS_API_URL") . "graphql?query=mutation+mutation{addLocation($query){name}}";

        $response = \wp_remote_post($update_endpoint, array('method' => "POST"));

        if (\is_wp_error($response)) {
            \error_log($response->get_error_message());
        }

        $redirect_url = \network_admin_url("admin.php?page=location-done&new_site_id=" . $vanity_website_id);
        \header("Location: " . $redirect_url);
        exit;
    }

    public static function delete_location()
    {

        $location_id = filter_var($_POST['location_id'], FILTER_SANITIZE_NUMBER_INT);

        if (isset($_POST['delete-site']) && $_POST['delete-site'] === "1") {

            $location = self::get_location(null, $location_id);

            wpmu_delete_blog($location->vanity_website_id);
        }

        $delete_endpoint = \getenv("LOCATIONS_API_URL") . "graphql?query=mutation+mutation{deleteLocation(id:$location_id){name}}";

        $response = \wp_remote_post($delete_endpoint, array('method' => "POST"));

        //redirect to the location creation page
        $redirect_url = \network_admin_url("admin.php?page=location-details-landing&delete-location=true");
        \header('Location: ' . $redirect_url);

    }

    private static function format_business_hours()
    {

        if ($_POST['monday'][1]['open'] !== '' && $_POST['monday'][1]['closed'] !== '') {
            $monday = array('monday', $_POST['hoursMonday'], $_POST['monday']);
        } else {
            $monday = array('monday', $_POST['hoursMonday']);
        }

        if ($_POST['tuesday'][1]['open'] !== '' && $_POST['tuesday'][1]['closed'] !== '') {
            $tuesday = array('tuesday', $_POST['hoursTuesday'], $_POST['tuesday']);
        } else {
            $tuesday = array('tuesday', $_POST['hoursTuesday']);
        }

        if ($_POST['wednesday'][1]['open'] !== '' && $_POST['wednesday'][1]['closed'] !== '') {
            $wednesday = array('wednesday', $_POST['hoursWednesday'], $_POST['wednesday']);
        } else {
            $wednesday = array('wednesday', $_POST['hoursWednesday']);
        }

        if ($_POST['thursday'][1]['open'] !== '' && $_POST['thursday'][1]['closed'] !== '') {
            $thursday = array('thursday', $_POST['hoursThursday'], $_POST['thursday']);
        } else {
            $thursday = array('thursday', $_POST['hoursThursday']);
        }

        if ($_POST['friday'][1]['open'] !== '' && $_POST['friday'][1]['closed'] !== '') {
            $friday = array('friday', $_POST['hoursFriday'], $_POST['friday']);
        } else {
            $friday = array('friday', $_POST['hoursFriday']);
        }

        if ($_POST['saturday'][1]['open'] !== '' && $_POST['saturday'][1]['closed'] !== '') {
            $saturday = array('saturday', $_POST['hoursSaturday'], $_POST['saturday']);
        } else {
            $saturday = array('saturday', $_POST['hoursSaturday']);
        }

        if ($_POST['sunday'][1]['open'] !== '' && $_POST['sunday'][1]['closed'] !== '') {
            $sunday = array('sunday', $_POST['hoursSunday'], $_POST['sunday']);
        } else {
            $sunday = array('sunday', $_POST['hoursSunday']);
        }

        $business_hours = array($monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);

        return json_encode($business_hours);
    }

    private static function sanitize_string($string)
    {
        return \filter_var(urlencode($string), FILTER_SANITIZE_STRING);
    }

}
