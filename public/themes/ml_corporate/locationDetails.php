<?php
/**
 * Template for Location Details Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();

global $location;

$location_info = $location->locations[0];

//Location General Info
$locationName = $location_info->name;
$locationTelephone = $location_info->telephone;
$locationTelephoneExt = $location_info->telephone_ext;
$locationFax = $location_info->fax;
$locationEmail = $location_info->email;
$clinicEmail='';
if(WPENV === 'production'){
    $clinicEmail = $location_info->email;
}

//Location Address Info
$locationAddress1 = $location_info->addresses[0]->address_1;
$locationAddress2 = $location_info->addresses[0]->address_2;
$locationZipPostalCode = $location_info->addresses[0]->zip_postal_code;

$locationCity = $location_info->addresses[0]->city[0]->name;
$locationState = $location_info->addresses[0]->city[0]->region[0]->abbreviation;
$locationCountry = $location_info->addresses[0]->city[0]->region[0]->country[0]->abbreviation;
$locationLat = $location_info->addresses[0]->latitude;
$locationLng = $location_info->addresses[0]->longitude;

$locationHours = \MaxLiving\Location\FrontEnd\Functions::format_business_hours($location_info->business_hours);

//Fax Formatting
if ($locationFax) {
    $fax = $locationFax;
    $fax = preg_replace('/\D+/', '', $fax);
    $fax = '(' . substr($fax, 0, 3) . ') ' . substr($fax, 3, 3) . '-' . substr($fax, 6);
}

//Phone Formatting
if ($locationTelephone) {
    $phone =  \MaxLiving\Location\FrontEnd\Functions::unformat_number($locationTelephone);
    $phoneFormatted =  \MaxLiving\Location\FrontEnd\Functions::format_telephone($locationTelephone);
}

//Website URL Formatting
$siteID = $location_info->vanity_website_id;
$siteUrl = $location_info->vanity_website_url;

//Directions Link
$locationDirections = 'https://www.google.com/maps?daddr='.str_replace(' ', '+', $locationAddress1) . '+' . str_replace(' ', '+', $locationCity) . '+' . str_replace(' ', '+', $locationState) . '+' . str_replace(' ', '+', $locationZipPostalCode) . '+' . str_replace(' ', '+', $locationCountry);

if (get_field('google_maps_direction','clinic_home_options')) {
    $locationDirections = get_field('google_maps_direction','clinic_home_options');
}

global $corporateID;
$corporateID = get_current_blog_id();

switch_to_blog($siteID);

$appointmentLink = get_home_url() . '/sign-up';

$mapScripts = true;
global $smoothScrollScripts;
$smoothScrollScripts = true;
global $locationHoursScripts;
$locationHoursScripts = true;

?>

    <script>
        var mapCenterLat = 28.327612;
        var mapCenterLng = -81.524439;

        <?php if(isset($locationLat)) : ?>
        mapCenterLat = <?php echo $locationLat; ?>;
        <?php endif; ?>

        <?php if(isset($locationLng)) : ?>
        mapCenterLng = <?php echo $locationLng;  ?>;
        <?php endif; ?>

    </script>

    <section id="locationDetailsSection" class="locationDetailsHeader bg-faintGrey">
        <div class="wrapperMap wave wave-multi">
            <div id="map"></div>
        </div>

        <div class="locationDetailsContainer container">
            <div class="locationDetailsCard card card-noBorder card-shadow card-underline card-underline-brandGrey">
                <div class="locationDetailsLocation">
                    <?php if ($locationName): ?>
                        <h1><?php echo $locationName; ?></h1>
                    <?php endif; ?>
                    <a class="button button-secondary" href="#requestAppointment"
                       title="Request Appointment <?php if ($locationName): echo 'at ' . $locationName; endif; ?>">Request Appointment</a>
                </div>
                <div class="locationDetailsContent">
                    <div class="locationDetailsContentLeft">
                        <div class="locationDetailsContact">
                            <p class="address"><?php echo $locationAddress1; ?><?php if ($locationAddress2):echo ', ' . $locationAddress2;endif; ?>
                                <br><?php echo $locationCity.', '; echo $locationState.', '; echo $locationZipPostalCode.' '; echo $locationCountry; ?></p>
                            <?php if ($locationTelephone) : ?>
                                <p class="iconContact icon-phone">Tel: <a href="tel:<?php echo $phone; ?>"
                                                                          data-phone
                                                                          class="phoneNumberAW"
                                                                          title=""><?php echo $phoneFormatted; ?></a>
                                </p>
                            <?php endif;
                            if ($locationFax) : ?>
                                <p class="iconContact icon-fax">Fax: <?php echo $fax; ?></p>
                            <?php endif;
                            if ($locationEmail) : ?>
                                <p class="iconContact icon-email">Email: <a href="mailto:<?php echo $locationEmail; ?>"
                                                                            title=""><?php echo $locationEmail; ?></a>
                                </p>
                            <?php endif; if ($siteUrl) :  ?>

                            <p class="iconContact icon-arrowForward">
                                Web: <a href="<?php echo $siteUrl; ?>" title="Visit <?php echo $siteUrl; ?>"><?php echo $siteUrl; ?></a>
                            </p>

                            <?php endif; if ($locationDirections !== NULL): ?>
                                <a class="directions link-leftDash"
                                   href="<?php echo $locationDirections; ?>"
                                   title="Get Directions" target="_blank" data-direction data-clinic-name="<?php if ($locationName) {echo $locationName;} ?>">Get Directions</a>
                            <?php endif; ?>
                        </div>
                        <div class="locationDetailsHours">
                            <?php if($locationHours) : ?>
                                <div class="locationDetailTable">
                                    <p class="hoursTitle">Hours of Operation</p>
                                    <table>
                                        <tbody>
                                        <?php foreach($locationHours as $key => $value) : ?>
                                            <?php if($key === "Today") : ?>
                                                <tr class="today">
                                                    <td><?php echo $key; ?></td>
                                                    <td><?php echo $value; ?></td>
                                                </tr>
                                            <?php else : ?>
                                                <tr>
                                                    <td><?php echo $key; ?></td>
                                                    <td><?php echo $value; ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <span class="gradientOverlay"></span>
                                </div>
                                <div class="locationDetailHoursExpand centerAlign">
                                    <a class="link-leftDash">Expand to see hours</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="requestAppointment" class="locationDetailsContentRight smoothScroll">
                        <p class="appointmentTitle">Request an Appointment</p>
                        <?= do_shortcode('[generic_form show_affiliate_id=true delivery_email="'.$clinicEmail.'"]'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="clinicHome-bg-icon bg-single-icon bg-faintGrey bg-single-icon-nutrition-white bg-faintGrey">
        <section class=" aboutClinic centerAlign wave wave-white">
            <div class="container">
                <?php
                $doctors = array();
                if (have_rows('doctors', 'clinic_about_options')):
                    while (have_rows('doctors', 'clinic_about_options')): the_row();
                        $doctors[] = get_sub_field('doctor_name');
                    endwhile;
                endif;
                $count = count(get_field('doctors', 'clinic_about_options'));
                switch_to_blog(1);
                if (get_field('about_clinic_description', 'sitewide_content')) : ?>
                    <h3>About this <span class="bold">max</span>living clinic</h3>
                    <div class="aboutDescription"><?php

                        $clinic_desc = get_field('about_clinic_description', 'sitewide_content');

                        if ($count && 0 < $count && $clinic_desc) {
                            foreach ($doctors as $key => $doctor) {
                                echo $doctor . ', ';
                            }
                            echo $clinic_desc;
                        } else {
                            echo get_field('about_clinic_description_default', 'sitewide_content');
                        }
                        ?></div>

                    <?php
                    $clinicImageUrl = get_template_directory_uri() . "/images/placeholder.jpeg";
                    $clinicImageAlt = "";
                    if (get_field('image', 'sitewide_content')) {
                        $clinicImage = get_field('image', 'sitewide_content');
                        $clinicImageUrl = $clinicImage['url'];
                        $clinicImageAlt = $clinicImage['alt'];
                    }
                    restore_current_blog();
                    ?>
                    <div class="fullImage"
                         style="background-image:url('<?php echo $clinicImageUrl; ?>');background-size: cover;">
                        <img
                                class="image" src="<?php echo $clinicImage['url']; ?>"
                                alt="<?php echo $clinicImageAlt; ?>">
                    </div>
                <?php endif; ?>
            </div>
            </div>
        </section>

        <div class="clinicHome-bg-icon bg-single-icon bg-single-icon-white bg-single-icon-nutrition">
            <?php
            switch_to_blog(1); // Switch to base clinic template
            if (have_rows('services_benefits', 'sitewide_content')): ?>
                <section class="services centerAlign">
                    <h2 class="borderText border-brandGrey">Services &amp; Benefits</h2>
                    <div class="flexible-contentWithImage">
                        <div class="container">
                            <?php while (have_rows('services_benefits', 'sitewide_content')): the_row(); ?>

                                <div class="contentRow leftAlign">
                                    <div class="contentContainer">
                                        <h3><?php the_sub_field('title'); ?></h3>
                                        <div><?php the_sub_field('description'); ?></div>
                                        <?php if (have_rows('description_points_area', 'sitewide_content')): ?>

                                            <ul>

                                                <?php while (have_rows('description_points_area', 'sitewide_content')): the_row(); ?>

                                                    <li><?php the_sub_field('description_point'); ?></li>

                                                <?php endwhile; ?>

                                            </ul>
                                        <?php endif; ?>
                                        <?php if (get_field('show_request_appointment_button', 'sitewide_content')): ?>
                                            <div>
                                                <a href="#requestAppointment">Book an Appointment</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="imageContainer">
                                        <?php

                                        $clinicImageUrl = get_template_directory_uri() . "/images/placeholder.jpeg";
                                        $clinicImageAlt = "";
                                        if (get_sub_field('image')) {
                                            $clinicImage = get_sub_field('image');
                                            $clinicImageUrl = wp_get_attachment_image_src($clinicImage['ID'], 'flexible-content-image')[0];
                                            $clinicImageAlt = $clinicImage['alt'];
                                        }
                                        ?>
                                        <div class="imageContent bg-image"
                                             style="background-image:url('<?php echo $clinicImageUrl; ?>');">
                                            <img class="image" src="<?php echo $clinicImageUrl; ?>" alt="<?php echo $clinicImageAlt; ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                        </div>
                    </div>
                </section>
            <?php endif;
            restore_current_blog(); ?>
    </section>

    <section class="locationDetailsEssential flexible-contentEssentialIcon centerAlign bg-white">
        <div class="contentContainer container">
            <div class="borderTextDivider">
                <span class="category borderText border-brandGrey borderText-divider">Appointment</span>
            </div>
            <ul class="iconsList" aria-hidden="true">
                <li class="brandIcon icon-coreSymbol"></li>
                <li class="brandIcon icon-nutritionSymbol"></li>
                <li class="brandIcon icon-mindsetSymbol"></li>
                <li class="brandIcon icon-oxygenSymbol"></li>
                <li class="brandIcon icon-toxinsSymbol"></li>
            </ul>
            <h2 class="title">Find your best health with<br> the 5 Essentials<sup>&trade;</sup></h2>
            <div class="content">

            </div>
            <a class="button button-secondary" href="#requestAppointment" title="Request An
               Appointment">Request An
                Appointment</a>
        </div>
    </section>

<?php
restore_current_blog();

get_footer();
