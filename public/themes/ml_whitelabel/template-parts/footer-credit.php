<?php
$api_call = new \MaxLiving\Location\FrontEnd\Functions();
$location = $api_call->get_location_by_site_id(get_current_blog_id());
$location_info = $location->locations[0];
?>
<p>&copy; Copyright <?php echo date('Y').' '.$location_info->name; ?>. All rights reserved.</p>
