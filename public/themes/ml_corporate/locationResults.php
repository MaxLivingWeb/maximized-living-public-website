<?php
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
get_header();

global $location;
foreach ($location->locations as $locations) {
    if (array_key_exists('addresses', $locations)) {
        $locations->location_name = $locations->name;
        $locations->location_telephone = $locations->telephone;
        $locations->location_slug = $locations->slug;
        $locations->zip_postal_code = $locations->addresses[0]->zip_postal_code;
        $locations->latitude = $locations->addresses[0]->latitude;
        $locations->longitude = $locations->addresses[0]->longitude;
        $locations->address_1 = $locations->addresses[0]->address_1;
        $locations->address_2 = $locations->addresses[0]->address_2;
        $locations->city_name = $locations->addresses[0]->city[0]->name;
        $locations->city_slug = $locations->addresses[0]->city[0]->slug;
        $locations->region_code = strtolower($locations->addresses[0]->city[0]->region[0]->abbreviation);
        $locations->country_code = strtolower($locations->addresses[0]->city[0]->region[0]->country[0]->abbreviation);
        $locations->region_name = $locations->addresses[0]->city[0]->region[0]->name;
        $locations->location_business_hours = \MaxLiving\Location\FrontEnd\Functions::format_business_hours($locations->business_hours);
    }
    $locations->location_telephone_href = \MaxLiving\Location\FrontEnd\Functions::unformat_number($locations->location_telephone);
    $locations->location_telephone = \MaxLiving\Location\FrontEnd\Functions::format_telephone($locations->location_telephone);
}?>

<script>
    var mapCenterLat = 43.6532;
    var mapCenterLng = -79.3832;

    <?php if(isset($_GET['lat'])) : ?>
    mapCenterLat = <?php echo $_GET['lat']; ?>;
    <?php endif; ?>

    <?php if(isset($_GET['long'])) : ?>
    mapCenterLng = <?php  echo $_GET['long'];  ?>;
    <?php endif; ?>

    var GlobalMapLocations = <?php echo json_encode($location); ?>;
</script>

<section class="locationResults" id="content">
    <div id="map"></div>
    <div class="resultsList">
        <div class="searchArea">
            <form class="locationSearch" id="locationSearchForm">
                <label class="inputField" for="locationSearch">
                    <input class="locationInput" id="locationSearch" type="text" name="location" placeholder=""
                           required/>
                    <span class="locationSearchLabel">City or Zip/Postal Code</span>
                    <span class="locationSearchIcon"></span>
                </label>
            </form>
            <p class="resultsShown icon-outlinedPin iconDetail">Showing <strong
                        id="locationCount"><?php echo count($location->locations); ?></strong> MaxLiving
                Clinic Locations</p>
        </div>
        <div id="locationResultList">
            <?php foreach ($location->locations as $local) : ?>
                <div class="locationResultCard card">
                    <span class="latitude invisible" aria-hidden="true"><?php echo $local->latitude; ?></span>
                    <span class="longitude invisible" aria-hidden="true"><?php echo $local->latitude; ?></span>
                    <div class="cardFlag">
                        <img alt="White pin icon" src="<?php echo get_template_directory_uri(); ?>/images/icon-pin-white.svg">
                    </div>
                    <div class="cardContent">
                        <p class="locationName"><?php echo $local->location_name; ?></p>
                        <p class="locationText"><?php echo $local->address_1; ?>, <?php echo $local->address_2; ?></p>
                        <p class="locationText"><?php echo $local->city_name; ?>, <?php echo $local->region_name; ?> <?php echo $local->zip_postal_code; ?>, <?php echo strtoupper($local->country_code); ?></p>
                        <p class="locationText"><span>Tel: </span><a class="phoneNumberAW"
                                    href="tel:<?php echo $local->location_telephone_href; ?>" data-phone><?php echo $local->location_telephone; ?></a>
                        </p>
                        <p class="locationText">
                            <span>Today's Hours: </span><?php echo $local->location_business_hours['Today']; ?></p>
                        <a class="locationLink link link-leftDash"
                           href="<?php echo home_url(); ?>/locations/<?php echo $local->country_code; ?>/<?php echo $local->region_code; ?>/<?php echo $local->city_slug; ?>/<?php echo $local->location_slug; ?>">View
                            Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <script id="locationResultTemplate" type="text/x-handlebars-template">
            {{#each locations}}
            <div class="locationResultCard card">
                <span class="latitude invisible" aria-hidden="true">{{latitude}}</span>
                <span class="longitude invisible" aria-hidden="true">{{longitude}}</span>
                <div class="cardFlag"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-pin-white.svg">
                </div>
                <div class="cardContent">
                    <a href="<?php echo home_url(); ?>/locations/{{country_code}}/{{region_code}}/{{city_slug}}/{{location_slug}}">
                        <p class="locationName">{{location_name}}</p>
                    </a>
                    <p class="locationText">{{address_1}}, {{address_2}}</p>
                    <p class="locationText">{{city_name}}, {{region_name}} {{zip_postal_code}}, {{toUpperCase country_code}}</p>
                    <p class="locationText"><span>Tel: </span><a href="tel:{{location_telephone_href}}" data-phone class="phoneNumberAW">{{location_telephone}}</a>
                    </p>
                    <p class="locationText"><span>Hours: </span>{{location_business_hours.[Today]}}</p>
                    <a class="locationLink link link-leftDash"
                       href="<?php echo home_url(); ?>/locations/{{country_code}}/{{region_code}}/{{city_slug}}/{{location_slug}}">View
                        Details</a>
                </div>
            </div>
            {{/each}}
        </script>
    </div>
</section>
<?php get_footer(); ?>
