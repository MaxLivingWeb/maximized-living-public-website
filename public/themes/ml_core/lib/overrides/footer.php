<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-09
 */

function removeFooterScripts()
{
    wp_deregister_script('wp-embed');
}

add_action('wp_footer', 'removeFooterScripts');