<?php

$originID = get_post_meta( $post->ID, 'siteOriginID', true );

switch_to_blog($originID);
$originName = get_bloginfo( 'name' );
restore_current_blog();

$localText = '<a href="'.get_site_url($originID).'" target="_blank">'.$originName.'</a>';

?>

<p>This <?php echo get_post_type($post->ID);?> will only be displayed on the clinic <?php echo $localText; ?>.</p>
