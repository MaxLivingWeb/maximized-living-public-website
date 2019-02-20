<?php
global $location;
global $locationTitle;
$metaDesc = 'Search for MaxLiving chiropractic locations in a city near you. Healthy living is simple when you align your health with MaxLiving.';
$title = get_bloginfo('name');
if (get_query_var('locationTitle')) {
    $title = get_query_var('locationTitle');
}
if(is_array($location->locations[0]) ) {
    if (array_key_exists('addresses', $location->locations[0])) {
        $location_info = $location->locations[0];
        $locationName = $location_info->name;
        $locationCity = $location_info->addresses[0]->city[0]->name;
        $locationState = $location_info->addresses[0]->city[0]->region[0]->name;
        $locationCountry = $location_info->addresses[0]->city[0]->region[0]->country[0]->name;
        if ($location_info->addresses[0]->city[0]->region[0]->country[0]->abbreviation === "US") {// Add "The" for USA
            $locationCountry = "The " . $locationCountry;
        }
        if (get_query_var('locationTemplate') === 'results') {//if location results

            $url = $_SERVER["REQUEST_URI"];
            $url = trim($url, "/");
            $url_array = explode('/', $url);

            if (count($url_array) === 2) {//if locations/* (country)
                $metaDesc = 'MaxLiving offers quality chiropractic services across ' . $locationCountry . '. Visit one of our locations and let us help you obtain the healthy lifestyle you\'re after.';
            }
            if (count($url_array) === 3) {//if locations/*/* (region)
                $metaDesc = 'If you live in ' . $locationState . ', you\'re probably near a MaxLiving clinic! Visit one of our chiropractors and take the first step to a healthy lifestyle.';
            }
            if (count($url_array) === 4) {//if locations/*/*/* (city)
                $metaDesc = 'MaxLiving chiropractors are passionate about their community — find our nearest ' . $locationCity . ' location and take the first step to health and wellness.';
            }
        }
    }
}
if (get_query_var('locationTemplate') === 'details') {//if location details
    $metaDesc = 'Find one of our trusted chiropractors at ' . $locationName . ' serving the ' . $locationCity . ' area. Healthy living is simple with MaxLiving.';
}
echo '<!-- Start Locations Meta Data -->';
echo '<meta name="description" content="' . $metaDesc . '"/>';
echo '<meta property="og:locale" content="en_US" />';
echo '<meta property="og:type" content="website" />';
echo '<meta property="og:title" content="' . $title . '" />';
echo '<meta property="og:description" content="' . $metaDesc . '" />';
echo '<meta property="og:url" content="' . get_home_url() . $_SERVER['REQUEST_URI'] . '" />';
echo '<meta property=”og:image” content="'.get_template_directory_uri() . '/images/placeholder.jpeg" />';
echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />';
echo '<meta name="twitter:card" content="summary" />';
echo '<meta name="twitter:description" content="' . $metaDesc . '" />';
echo '<meta name="twitter:title" content="' . $title . '" />';
echo '<!-- End Locations Meta Data -->';

?>
