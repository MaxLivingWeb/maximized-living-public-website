<?php

function sem_landing_page_save() {
    $screen = get_current_screen();
    if (strpos($screen->id, 'landing-page') == true) {

        $vanity_website_id = get_current_blog_id();
        $desc = get_field('desc','landing-page');
        $id_param = "vanity_website_id:$vanity_website_id,sem_page_desc:\"$desc\"";

        //hit the api
        $update_endpoint = \getenv("LOCATIONS_API_URL") . "graphql?query=mutation+mutation{updateLocationSEMPageDesc($id_param){name}}";

        $response = \wp_remote_post($update_endpoint, array('method' => "POST"));

        if (\is_wp_error($response)) {
            \error_log($response->get_error_message());
        }

    }
}
add_action('acf/save_post', 'sem_landing_page_save', 20);
