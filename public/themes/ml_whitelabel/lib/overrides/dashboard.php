<?php

/**
 * Hide Yoast Metabox and Category Metabox for Recipes/Articles
 */
function action_admin_head_post_new_php() {
    echo '<style>
    #article_categoriesdiv, #recipe_categoriesdiv, #yoast_internal_linking {display:none !important;}
</style>';
}
if (!current_user_can('manage_network')) {
    add_action('admin_head-post-new.php', 'action_admin_head_post_new_php', 10, 1);
}
