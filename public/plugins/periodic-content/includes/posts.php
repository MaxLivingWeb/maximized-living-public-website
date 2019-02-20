<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-12-03
 * Time: 12:56 PM
 */

namespace MaxLiving\PeriodicContent\Includes;

class Posts
{
    public static function event_table_head( $defaults ) {
        $defaults['Preview URL']  = 'Preview URL';
        $defaults['Status']  = 'Status';

        global $blog_id;
        if ($blog_id != 1) {
            $defaults['Request a Revision']  = '';
        }

        return $defaults;
    }

    public static function event_table_content( $column_name, $post_id ) {
        switch_to_blog(1);
        $post = get_post($post_id);

        if(!is_object($post)){
            return;
        }

        if ($column_name === 'Preview URL' && $post->post_status === 'publish') {
            $url =  get_site_url();
            $type = '';
            if(isset($_GET['post_type'])) {
                $type = $_GET['post_type'];
            }

            echo "<a href=\"$url/?post_type=$type&p=$post_id&preview=true\" target=\"_blank\">Preview ".ucfirst($type)."</a>";
        }

        if ($column_name === 'Request a Revision') {
            $url =  get_site_url();
            $type = '';
            if(isset($_GET['post_type'])) {
                $type = $_GET['post_type'];
            }
            $email = getenv('REVISION_EMAIL',"revisions@maxliving.com");
            $mailto = "?subject=Requested Revision for a $type&body=Revisions (Please make a list of requested changes): Post Information: $post->post_title here: ".get_permalink()."";


            echo "<a href='mailto:$email$mailto' class='button-secondary'>Request Revision</a>";
        }


        if ($column_name == 'Status') {
            echo $post->post_status;
        }
        restore_current_blog();
    }

    public static function hide_admin_filters() {
        if(!is_admin() ) {
            return;
        }

        if(get_current_blog_id() === 1) {
            return;
        }

        if(isset($_GET['post_type']) ) {
            if($_GET['post_type'] === "recipe" || $_GET['post_type'] === "article" ) {
                echo "
                <script>
                    filter = document.getElementsByClassName('subsubsub');
                    if(filter[0]) {
                        filter[0].style.display = 'none';
                    }
                </script>
                ";
            }
        }
    }

    public static function decline_post()
    {
        if(!isset($_GET['post_id'])) {
            return;
        }

        $post = get_post($_GET['post_id']);

        $updates = array(
            'ID'            => $post->ID,
            'post_status'   => 'declined'
        );

        wp_update_post($updates);

        $redirect_url = admin_url().'edit.php?post_type='.$post->post_type;
        wp_redirect( $redirect_url );
        exit;
    }

    public static function add_decline_options()
    {

        global $post;

        if (get_current_blog_id() !== 1) {
            return;
        }

        if (is_object($post)) {
            if ($post->post_status === 'auto-draft') {
                return;
            }
            if ($post->post_status === 'draft') {
                return;
            }
            $siteOriginID = get_post_meta($post->ID, 'siteOriginID',true);
            if ($siteOriginID != "1") {
                if ($post->post_type === 'recipe' || $post->post_type === 'article') {

                    if ($post->post_status === 'declined') {
                        echo '
                    <script>
                        var post = document.getElementById("post");
                        var parent = post.parentNode;
                        var declinedHeading = document.createElement("h2");

                        declinedHeading.setAttribute("id", "decline-heading");
                        declinedHeading.setAttribute("style", "color:red;");
        
                        parent.insertBefore(declinedHeading, post);
        
                        document.getElementById("decline-heading").innerHTML = "DECLINED";
                    </script>
                ';
                    }

                    echo '
              <script>
                var post = document.getElementById("post");
                var parent = post.parentNode;
                var insertForm = document.createElement("form");

                insertForm.setAttribute("action", "' . admin_url('admin-post.php') . '");
                insertForm.setAttribute("id", "decline-btn");
                insertForm.setAttribute("style", "float:right;margin-top:-30px;margin-right:175px;margin-left:50px");

                parent.insertBefore(insertForm, post);

                document.getElementById("decline-btn").innerHTML = "<input type=\"hidden\" name=\"action\" value=\"decline_post\"><input type=\"hidden\" name=\"post_id\" value=\"' . $post->ID . '\"><input type=\"submit\" class=\"button-secondary\" onclick=\"return confirm(\'Decline this '.$post->post_type.'?\')\" value=\"Decline Post\" style=\"background-color:red;color:white;border-color: red;box-shadow: 0 1px 0 red;\">";
              </script>
              ';
                }
            }
        }
    }

    /**
     *
     * Cache post object on save for articles/recipes
     *
     * @param $post_id
     */
    public static function cache_single_views( $post_id ) {

        //if not corporate site get out
        if(get_current_blog_id() !== 1) {
            return;
        }

        //if autosave return
        if (wp_is_post_autosave($post_id)) {
            return;
        }

        //get post type
        $post_type = get_post_type($post_id);

        //if not recipe or article return
        if ( $post_type !== 'recipe' && $post_type !== 'article' ){
            return;
        }

        //get post object
        $post = get_post($post_id);

        //if not published return
        if($post->post_status !== 'publish') {
            return;
        }

        $cacheTitle = 'single-/healthy-recipes/'.$post->post_name;
        if ($post_type === 'article') {
            $cacheTitle = 'single-/healthy-articles/'.$post->post_name;
        }

        // Set/Create cache
        set_site_transient( $cacheTitle, $post);

        return;

    }

}
