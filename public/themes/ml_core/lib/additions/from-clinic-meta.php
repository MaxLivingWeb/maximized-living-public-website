<?php
//Vars
global $blog_id;


/**
 *
 * Callback for post type metabox creation
 *
 * @param $post
 */
function add_metaboxes($post) {
    add_clinic_metabox($post);
}

/**
 *
 * Adding clinic request distribution metabox
 *
 * @param $post
 */
function add_clinic_metabox($post)
{
    $types = array('recipe', 'article');
    $metaTitle = 'Requested Distribution';
    global $blog_id;
    global $pagenow;
    if ($blog_id === 1) {
        $metaTitle = 'Suggested Distribution';
    }

    foreach ($types as $type) {
        if ($pagenow === 'post-new.php' && $blog_id !== 1) {
            add_meta_box(
                'from_Clinic',
                $metaTitle,
                'from_Clinic',
                $type,
                'side',
                'default'
            );
        }
        if ($pagenow === 'post.php') {
            $id = $_GET['post'];
            $siteOriginID = get_post_meta($id, 'siteOriginID', true);
            if ($siteOriginID != "1" && $siteOriginID != NULL) {
                if (get_post_meta($post->ID, 'whitelabel', true)) {
                    $whitelabelvalue = get_post_meta($post->ID, 'whitelabel', true)[0];
                }
                if (!empty($whitelabelvalue)) {
                    if ($whitelabelvalue == 1) {
                        $metaTitle = 'White Label Clinic';
                    }
                }
                add_meta_box(
                    'from_Clinic',
                    $metaTitle,
                    'from_Clinic',
                    $type,
                    'side',
                    'default'
                );
            }
        }
    }
}

/**
 *
 * Pulling template for the metabox
 *
 * @param $post
 */
function from_Clinic($post)
{
    // Add an nonce field so we can check for it later.
    wp_nonce_field('meta_box', 'meta_box_nonce');

    $whitelabelvalue = get_post_meta($post->ID, 'whitelabel', false);
    if (!empty($whitelabelvalue)) {
        if ($whitelabelvalue[0] == 1) {
            // Hide ACF distribution metabox
            echo '<style> #acf-group_5a2089785b3a0 {display: none !important;}</style>';
            //White label site distribution metabox
            get_template_part('template-parts/fromClinicWhiteLabel');
        } else {
            //Default metabox for clinic distribution request
            get_template_part('template-parts/fromClinicRadio');
        }
    } else {
        //Default metabox for clinic distribution request
        get_template_part('template-parts/fromClinicRadio');
    }
}

/**
 *
 * Saving site origin ID to postmeta
 *
 * @param $post_id
 * @param $post
 */
function save_site_origin_id($post_id, $post)
{
    $keyID = "siteOriginID";
    if ('revision' === $post->post_type) {
        return;
    }
    if (get_post_meta($post_id, $keyID, false)) {//Don't update region ID on publish of corporate site.
        return;
    }
    // If the custom field doesn't have a value, add it.
    add_post_meta($post_id, $keyID, get_current_blog_id());
}

if ($blog_id != 1) { // Only update requested region metabox on child sites.
    add_action('save_post', 'post_type_clinic_meta', 1, 2);
}
/**
 *
 * Set requested distribution region
 *
 * @param $post_id
 * @param $post
 */
function post_type_clinic_meta($post_id, $post)
{
    global $keyReach;
    $keyReach = "requestedPostDistribution";
    // Check if our nonce is set.
    if (!isset($_POST['meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (wp_verify_nonce($_POST['meta_box_nonce'], 'meta_box') === false) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if ('revision' === $post->post_type) {
        return;
    }

    // Sanitize user input.
    $distribution = (isset($_POST['distribution']) ? sanitize_html_class($_POST['distribution']) : '');

    if (get_post_meta($post_id, $keyReach, false)) {
        // If the custom field already has a value, update it.
        update_post_meta($post_id, $keyReach, $distribution);
    } else {
        // If the custom field doesn't have a value, add it.
        add_post_meta($post_id, $keyReach, $distribution);
    }
}

add_action('save_post', 'save_site_origin_id', 1, 2);


