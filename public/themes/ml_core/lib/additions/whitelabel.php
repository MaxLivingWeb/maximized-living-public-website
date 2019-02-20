<?php
/**
 * Theme Switch
 */
function theme_switch()
{
    switch (get_option('stylesheet')) {
        case 'ml_clinic':
            clinic_theme();
            break;
        case 'ml_whitelabel':
            whitelabel_theme();
            break;
    }
}

add_action('after_switch_theme', 'theme_switch');

/**
 * Switching to Clinic Theme
 */
function clinic_theme()
{
    //Enable Clinic Specific Pages
    update_clinic_pages('publish');

    //Updating whitelabel status
    update_whitelabel_status(0);
}

/**
 * Switching to White Label Theme
 */
function whitelabel_theme()
{
    //Disable Clinic Specific Pages
    update_clinic_pages('draft');

    //Updating whitelabel status
    update_whitelabel_status(1);
}

/**
 * @param $whitelabel_status
 * White Label API Status Update Function
 */
function update_whitelabel_status($whitelabel_status)
{

    $vanity_website_id = get_current_blog_id();

    //hit the api
    $update_endpoint = \getenv("LOCATIONS_API_URL") . "graphql?query=mutation+mutation{updateLocationWhitelabel(vanity_website_id:$vanity_website_id,whitelabel:$whitelabel_status){name}}";

    $response = \wp_remote_post($update_endpoint, array('method' => "POST"));

    if (\is_wp_error($response)) {
        \error_log($response->get_error_message());
    }

    return;
}

/**
 * @param $status
 * Updating Clinic site pages depending on white label status
 */
function update_clinic_pages($status)
{

	if (get_option('initial_theme')) {
		update_option('initial_theme',false);
		return;
	}

	//Updating Home Page Title
    if (get_option('page_on_front')) {
        $post_id = get_option('page_on_front');
        $title = get_the_title($post_id);
        if ($status === 'draft') {//White label
            $title = str_replace(' | MaxLiving', '', $title);
        } else { // ML Branded
            $title .= ' | MaxLiving';
        }
        $post = array(
            'ID' => $post_id,
            'post_title' => $title
        );
        wp_update_post($post);
    }

    //Updating Our Team Page Title
    if (get_page_by_path('our-team')) {
        $post_id = get_page_by_path('our-team')->ID;
        $title = get_the_title($post_id);
        if ($status === 'draft') {//White label
            $title = str_replace(' | MaxLiving', '', $title);
        } else { // ML Branded
            $title .= ' | MaxLiving';
        }
        $post = array(
            'ID' => $post_id,
            'post_title' => $title
        );
        wp_update_post($post);
    }

    $pages = array(
        'home-care-videos',
        'power-of-chiropractic',
        'success-stories',
        'information-for-patients',
        'five-essentials',
        'five-essentials/core-chiropractic',
        'five-essentials/nutrition',
        'five-essentials/mindset',
        'five-essentials/oxygen-and-exercise',
        'five-essentials/minimize-toxins'
    );

    foreach ($pages as $page) {
        if (get_page_by_path($page)) {
            $post = array(
                'ID' => get_page_by_path($page)->ID,
                'post_status' => $status
            );
            wp_update_post($post);
        }
    }
    return;
}
