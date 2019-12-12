<?php

function event_remove_media_buttons() {
    global $current_screen;
    if( 'event' === $current_screen->post_type ){
        remove_action('media_buttons', 'media_buttons');
    }
}
add_action('admin_head','event_remove_media_buttons');
