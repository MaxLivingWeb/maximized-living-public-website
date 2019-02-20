<?php
global $affiliate_id;
$api_call = new \MaxLiving\Location\FrontEnd\Functions();

$location = $api_call->get_location_by_site_id(get_current_blog_id());
$location_info = $location->locations[0];

//Location General Info
$locationName = $location_info->name;
?>

dataLayer = [{
'locale': '<?php echo $locationName . ' - ' . $affiliate_id . ' - White Label Clinic'; ?>'
}];
