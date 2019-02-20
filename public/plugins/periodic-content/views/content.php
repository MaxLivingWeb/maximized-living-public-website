<?php
/**
 * Created by PhpStorm.
 * User: tomeastwood
 * Date: 2017-11-27
 * Time: 5:00 PM
 */

namespace MaxLiving\PeriodicContent\Views;

class Content
{
    public static function create_content()
    {
      include('partials/create-content.php');
    }

    public static function my_events_drafts()
    {
        $url = admin_url() . 'edit.php?post_type=event&post_status=draft';
        wp_redirect($url);
        exit;
    }

    public static function my_recipes_drafts()
    {
        $url = admin_url() . 'edit.php?post_type=recipe&post_status=draft';
        wp_redirect($url);
        exit;
    }

    public static function my_articles_drafts()
    {
        $url = admin_url() . 'edit.php?post_type=article&post_status=draft';
        wp_redirect($url);
        exit;
    }

    public static function pending_recipes()
    {
        $url = admin_url() . 'edit.php?post_type=recipe&post_status=pending';
        wp_redirect($url);
        exit;
    }

    public static function pending_articles()
    {
        $url = admin_url() . 'edit.php?post_type=article&post_status=pending';
        wp_redirect($url);
        exit;
    }

    public static function corporate_recipes()
    {
        $url = admin_url() . 'edit.php?post_type=recipe&corporate_only=true';
        wp_redirect($url);
        exit;
    }

    public static function corporate_articles()
    {
        $url = admin_url() . 'edit.php?post_type=article&corporate_only=true';
        wp_redirect($url);
        exit;
    }

    public static function submitted_recipes()
    {
        $url = admin_url() . 'edit.php?post_type=recipe&submitted=true';
        wp_redirect($url);
        exit;
    }

    public static function submitted_articles()
    {
        $url = admin_url() . 'edit.php?post_type=article&submitted=true';
        wp_redirect($url);
        exit;
    }
}
