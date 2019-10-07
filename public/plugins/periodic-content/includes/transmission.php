<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-28
 * Time: 4:19 PM
 */

namespace MaxLiving\PeriodicContent\Includes;

class Transmission
{
    /**
     *
     * Sent post from clinic to corporate
     *
     * @param $post_id
     */
    public static function send_to_corporate($post_id)
    {
        $post = get_post($post_id);

        if ($post->post_type !== "recipe" && $post->post_type !== "article") {
            return;
        }

        if (get_current_blog_id() === 1) {

            if($post->post_status != 'publish') {
                return;
            }

            //commenting out, already made database on prod, not dev
            //self::create_tables();
            global $wpdb;

            $wpdb->delete( "mlpw_custom_post_meta", [
                "post_id" => $post->ID
            ]);

            $post_meta = get_post_meta($post->ID);

            delete_post_meta($post->ID,'regional_distribution');

            $distributions = unserialize($post_meta['distribution'][0]);

            foreach($distributions as $d) {
                    add_post_meta($post->ID,'regional_distribution',$d);
            }

            switch($post_meta['distribution_reach'][0]) {
                case "0":
                    $distribution_code = '9999999'.$post_meta['siteOriginID'][0];
                    $wpdb->insert("mlpw_custom_post_meta", [
                            "post_id"           => $post->ID,
                            "post_type"         => $post->post_type,
                            "publish_date"      => $post->post_date,
                            "distribution_code" => $distribution_code
                        ]
                    );
                    break;
                case "1":
                    $distribution_code = '1111111';
                    $wpdb->insert("mlpw_custom_post_meta", [
                            "post_id"           => $post->ID,
                            "post_type"         => $post->post_type,
                            "publish_date"      => $post->post_date,
                            "distribution_code" => $distribution_code
                        ]
                    );
                    break;
                case "2":
                    $regions = unserialize($post_meta['distribution'][0]);
                    foreach($regions as $r) {
                        $wpdb->insert("mlpw_custom_post_meta", [
                                "post_id"           => $post->ID,
                                "post_type"         => $post->post_type,
                                "publish_date"      => $post->post_date,
                                "distribution_code" => $r
                            ]
                        );
                    }
                    break;
            }



            return;
        }

        if ($post->post_status === "pending") {


            //the post has been saved to the child site

            //copy the post to site 1 (main corporate site)
            self::copy_post_to_blog($post->ID, 1);

            //now delete the post from the child site
            wp_delete_post($post->ID, true);

            // Redirect to submitted page
            $redirect_url = admin_url('admin.php?page=content-submitted');
            wp_redirect($redirect_url);
            exit;
        }
    }

    /**
     *
     * Filter by corporate created recipes
     *
     * @param $query
     */
    public static function corporate_only_recipe($query)
    {
        if (!is_admin()) {
            return;
        }
        if (isset($_GET['corporate_only'])) {
            $query->set(
                'meta_query',
                array(
                    array(
                        'key' => 'siteOriginID',
                        'value' => 1
                    )
                )
            );
        }

    }

    /**
     *
     * Filter by submitted recipes
     *
     * @param $query
     */
    public static function submitted_recipes_sort($query)
    {
        if (!is_admin()) {
            return;
        }
        if (isset($_GET['submitted'])) {
            $query->set(
                'meta_query',
                array(
                    array(
                        'key' => 'siteOriginID',
                        'compare' => '!=',
                        'value' => 1
                    )
                )
            );
        }
    }

    /**
     *
     * Filter by corporate created articles
     *
     * @param $query
     */
    public static function corporate_only_article($query)
    {
        if (!is_admin()) {
            return;
        }
        if (isset($_GET['corporate_only'])) {
            $query->set(
                'meta_query',
                array(
                    array(
                        'key' => 'siteOriginID',
                        'value' => 1
                    )
                )
            );
        }
    }


    /**
     *
     * Filter by submitted articles
     *
     * @param $query
     */
    public static function submitted_articles_sort($query)
    {
        if (!is_admin()) {
            return;
        }
        if (isset($_GET['submitted'])) {
            $query->set(
                'meta_query',
                array(
                    array(
                        'key' => 'siteOriginID',
                        'compare' => '!=',
                        'value' => 1
                    )
                )
            );
        }
    }

    /**
     * grabbing posts from corporate site
     */
    public static function pre_corporate_post_list_query($query)
    {
        if (!is_admin()) {
            return;
        }

        if (isset($_GET['post_status'])) {
            if ($_GET['post_status'] === 'draft') {
                return;
            }
        }

        if (isset($_GET['post_type'])) {
            if ($_GET['post_type'] !== "recipe" && $_GET['post_type'] !== "article") {
                return;
            }
        }

        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));
        $admin_url = admin_url() . "edit.php";

        //only grab posts of the current user
        global $current_user;
        if (!current_user_can('edit_others_posts')) {
            $query->set(
                'meta_query',
                array(
                    array(
                        'key' => 'siteOriginID',
                        'value' => get_current_blog_id()
                    )
                )
            );
        }

        if ($current_url === $admin_url && isset($_GET['post_type'])) {
            if ($_GET['post_type'] === "recipe" || $_GET['post_type'] === "article") {
                switch_to_blog(1);
            }
        }
    }

    public static function post_corporate_post_list_query()
    {
        if ( ! is_admin() ) {
            return;
        }

        if (isset($_GET['post_status'])) {
            if ($_GET['post_status'] === 'draft') {
                return;
            }
        }

        if (isset($_GET['post_type'])) {
            if (($_GET['post_type'] === 'recipe' || $_GET['post_type'] === 'article') && get_current_blog_id() === 1) {
                restore_current_blog();
            }
        }
    }

    /**
     *
     * Copy the post, post meta, and post assets from clinic to corporate level
     *
     * @param $post_id
     * @param $target_blog_id
     */
    private static function copy_post_to_blog($post_id, $target_blog_id)
    {

        //Original Post
        $post = get_post($post_id, ARRAY_A);
        $meta = get_post_meta($post_id);

        //  image
        $imagePostId = get_post_meta($post['ID'])['_thumbnail_id'][0];
        $image = getenv('AWS_CLOUDFRONT_URL') . get_post_meta($imagePostId, 'amazonS3_info')[0]['key'];

        $whitelabel = false;
        if (get_option('stylesheet') === 'ml_whitelabel') {// Submission site is
            $whitelabel = true;
        }

        $post['ID'] = ''; // empty id field, to tell wordpress that this will be a new post

        switch_to_blog($target_blog_id); // switch to target blog
        global $inserted_post_id;
        $inserted_post_id = wp_insert_post($post); // insert the post

        //Update post meta
        foreach ($meta as $key => $value) {
            update_post_meta($inserted_post_id, $key, $value[0]);
        }

        if ($whitelabel) {//White label site post meta
            self::white_label_clinic_to_corporate_meta($inserted_post_id);
        }

        //Set Featured Image
        self::clinic_to_corporate_featured_image($image, $inserted_post_id);

        restore_current_blog();

        //Delete Image Post from Child Site.
        wp_delete_post($imagePostId, true);
    }

    /**
     *
     * Copy featured image from clinic to corporate level
     *
     * @param $image
     * @param $post_id
     */
    private static function clinic_to_corporate_featured_image($image, $post_id)
    {
        require_once(ABSPATH . 'wp-admin/includes/image.php'); // required for uploading image

        // Setting variables
        $upload = wp_upload_dir();
        $image_data = file_get_contents($image);
        $filename = basename($image);

        $file = $upload['basedir'] . '/' . $filename;
        if (wp_mkdir_p($upload['path'])) {
            $file = $upload['path'] . '/' . $filename;
        }

        file_put_contents($file, $image_data);

        $file_type = wp_check_filetype($filename);

        $attachment = array(
            'post_mime_type' => $file_type['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        // Create featured image
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($post_id, $attach_id);

    }

    /**
     *
     * Set whitelabel status and distribution reach to local
     *
     * @param $post_id
     */
    private static function white_label_clinic_to_corporate_meta($post_id)
    {
        //WhiteLabel distrubution
        if (get_post_meta($post_id, 'distribution_reach', false)) {
            // If the custom field already has a value, update it.
            update_post_meta($post_id, 'distribution_reach', '0');
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta($post_id, 'distribution_reach', '0');
        }
        //WhiteLabel Flag
        if (get_post_meta($post_id, 'whitelabel', false)) {
            // If the custom field already has a value, update it.
            update_post_meta($post_id, 'whitelabel ', true);
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta($post_id, 'whitelabel', true);
        }
    }

    private static function create_tables()
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $charset_collate = $wpdb->get_charset_collate();

        $post_meta = "CREATE TABLE mlpw_custom_post_meta (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            post_id bigint(20),
            post_type tinytext,
            publish_date tinytext NOT NULL,
            distribution_code tinytext,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        \dbDelta($post_meta);
    }

}
