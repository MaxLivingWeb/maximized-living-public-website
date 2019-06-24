<?php
/**
 * Template Name: Clinic - Homepage
 *
 * The Clinic Homepage template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

$api_call = new \MaxLiving\Location\FrontEnd\Functions();

$location = $api_call->get_location_by_site_id(get_current_blog_id());
$location_info = $location->locations[0];

//Location General Info
$locationName = $location_info->name;
$locationTelephone = $location_info->telephone;
$locationTelephoneExt = $location_info->telephone_ext;
$locationFax = $location_info->fax;
$locationEmail = $location_info->email;
$clinicEmail = $location_info->email;;

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
$locationWebsite = get_home_url();
$locationWebsite = preg_replace('#^https?://#', '', rtrim($locationWebsite, '/'));

//Directions Link
$locationDirections = 'https://www.google.com/maps?daddr='.str_replace(' ', '+', $locationAddress1) . '+' . str_replace(' ', '+', $locationCity) . '+' . str_replace(' ', '+', $locationState) . '+' . str_replace(' ', '+', $locationZipPostalCode);

if (get_field('google_maps_direction','clinic_home_options')) {
    $locationDirections = get_field('google_maps_direction','clinic_home_options');
}

//Clinic Image
$clinicImage = get_template_directory_uri() . "/images/placeholder.jpeg";

switch_to_blog(1);
if(get_field('image', 'sitewide_content')) {
    $clinicImage = get_field('image', 'sitewide_content');
}
restore_current_blog();
if (get_field('image', 'clinic_home_options')) {
    $clinicImage = get_field('image', 'clinic_home_options');
}

$teamSection = get_field('team_section', 'clinic_home_options');
$appointmentLink = get_home_url() . '/sign-up';

$mapScripts = true;
global $smoothScrollScripts;
$smoothScrollScripts = true;
global $locationHoursScripts;
$locationHoursScripts = true;

$childsite_url = home_url();
get_header(); ?>

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

    <section class="clinicHomeHeader wave wave-faintGrey" id="content">
        <div class="hero wave wave-multi" style="background-image:url('<?php echo get_template_directory_uri() . '/images/clinic-header.jpg';?>');">
            <div class="heroContent centerAlign">
                <span>
                    <span class="invisible">Transform Your Health</span>
                    Transform Your Health
                </span>
                <?php if ($locationName) : ?>
                    <div class="heroHeadline-large"><?php echo $locationName; ?></div>
                <?php endif; ?>
                <p class="heroDescription">We want to educate people about the power of chiropractic and empower them to live longer, healthier lives.</p>

                <?php if ( get_field( 'homecare_cert', 'clinic_options' ) ): ?>

                <p class="tooltip">

                  <img id="homeCert" src="https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162552/Core_1_white2.png"
                      onmouseover="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13165113/Core_11.png'"
                      onmouseout="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162552/Core_1_white2.png'"
                      border="0" alt="Spinal Corrective Process Homecare Certification" title="Spinal Corrective Process Homecare Certification"/>

                  <span class="tooltiptext"><strong>Spinal Corrective Process Homecare Certification</strong><br>Certifies completion of the MaxLiving Spinal Corrective Process for Homecare protocols; qualified in examining and prescribing homecare treatment, including traction, isometrics, body weighting for safe and effective spinal molding practices.</span>

                </p>

                <?php else: ?>

                <?php endif; ?>

                <?php if ( get_field( 'homecare_cert_lvl1', 'clinic_options' ) ): ?>

                <p class="tooltip-middle">

                  <img id="homeCert" src="https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162559/Core_2_white2.png"
                      onmouseover="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13165120/Core_21.png'"
                      onmouseout="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162559/Core_2_white2.png'"
                      border="0" alt="Spinal Corrective Process Level 1 Certification" title="Spinal Corrective Process Level 1 Certification"/>

                  <span class="tooltiptext"><strong>Spinal Corrective Process Level 1 Certification</strong><br>Certifies completion of Level 1 training in the MaxLiving Spinal Corrective Process; qualified to use enhanced office procedures, including, pre-adjusting therapy, specific chiropractic adjusting protocols, and post adjusting exercises to improve patient outcomes.</span>

                </p>

                <?php else: ?>

                <?php endif; ?>

                <?php if ( get_field( 'homecare_cert_lvl2', 'clinic_options' ) ): ?>

                <p class="tooltip-middle">

                  <img id="homeCert" src="https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162606/Core_3_white2.png"
                      onmouseover="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13165127/Core_31.png'"
                      onmouseout="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162606/Core_3_white2.png'"
                      border="0" alt="Spinal Corrective Process Level 2 Certification" title="Spinal Corrective Process Level 2 Certification"/>

                  <span class="tooltiptext"><strong>Spinal Corrective Process Level 2 Certification</strong><br>Certifies completion of Level 2 advanced training in the MaxLiving Spinal Corrective Process, including strong competencies in spinal correction and protocols; qualified in using diverse arrangements of enhanced in-office and homecare procedures and activities to improve patient outcomes.</span>

                </p>

                <?php else: ?>

                <?php endif; ?>

                <?php if ( get_field( 'nutrition_cert', 'clinic_options' ) ): ?>

                <p class="tooltip-middle">

                  <img id="homeCert" src="https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162613/Nutrition_1_white2.png"
                      onmouseover="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13165135/Nutrition_11.png'"
                      onmouseout="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162613/Nutrition_1_white2.png'"
                      border="0" alt="Nutrition Certification" title="Nutrition Certification"/>

                  <span class="tooltiptext"><strong>Nutrition Certification</strong><br>Certifies completion of training on the MaxLiving Nutrition Plan; qualified to counsel patients on dietary and nutrient intake and provide other nutritional strategies to maintaining and improving their health.</span>


                </p>

                <?php else: ?>

                <?php endif; ?>

                <?php if ( get_field( 'nutrition_cert_lvl1', 'clinic_options' ) ): ?>

                <p class="tooltip-middle">

                  <img id="homeCert" src="https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162620/Nutrition_2_white2.png"
                      onmouseover="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13165106/Nutrition_21.png'"
                      onmouseout="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162620/Nutrition_2_white2.png'"
                      border="0" alt="Nutrition Certification Level 1"/>

                  <span class="tooltiptext"></span>

                </p>

                <?php else: ?>

                <?php endif; ?>

                <?php if ( get_field( 'nutrition_cert_lvl2', 'clinic_options' ) ): ?>

                <p class="tooltip-end">

                  <img id="homeCert" src="https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162625/Nutrition_3_white2.png"
                      onmouseover="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13165142/Nutrition_31.png'"
                      onmouseout="this.src='https://d23i5jq6adgv5h.cloudfront.net/production/uploads/2019/03/13162625/Nutrition_3_white2.png'"
                      border="0" alt="Nutrition Certification Level 2"/>

                  <span class="tooltiptext"></span>

                </p>

                <?php else: ?>

                <?php endif; ?>

            </div>
        </div>

        <div class="locationDetailsContainer container" id="contact">
            <div class="locationDetailsCard card card-noBorder card-shadow card-underline card-underline-brandGrey">
                <div class="locationDetailsLocation">
                <h1 style="text-align: center;"><?php echo $locationAddress1; ?><?php if ($locationAddress2):echo ', ' . $locationAddress2;endif; ?>
                    <br><?php echo $locationCity.', '; echo $locationState.', '; echo $locationZipPostalCode.' '; echo $locationCountry; ?></h1>
                </div>
                <div class="locationDetailsContent">
                    <div class="locationDetailsContentLeft">
                        <div class="locationDetailsContact">
                            <?php if ($locationTelephone) : ?>
                                <p class="iconContact icon-phone">Tel: <a href="tel:<?php echo $phone; ?>"
                                                                          class="phoneNumberAW"
                                                                          title="Call us at <?php echo $phoneFormatted; ?>" data-phone><?php echo $phoneFormatted; ?></a>
                                </p>
                            <?php endif; ?>

                            <?php if ($locationFax) : ?>
                                <p class="iconContact icon-fax">Fax: <?php echo $fax; ?></p>
                            <?php endif; ?>

                            <?php if ($locationEmail) : ?>
                                <p class="iconContact icon-email">Email: <a href="mailto:<?php echo $locationEmail; ?>"
                                                                            title="Email us at <?php echo $locationEmail; ?>"><?php echo $locationEmail; ?></a>
                                </p>
                            <?php endif; ?>

                            <?php if ($locationDirections !== NULL): ?>
                                <a class="directions link-leftDash"
                                   href="<?php echo $locationDirections; ?>"
                                   title="Get Directions" target="_blank" data-direction data-clinic-name="<?php if ($locationName) {echo $locationName;} ?>">Get Directions</a>
                            <?php endif; ?>
                        </div>
                        <div class="locationDetailsHours">
                            <div class="locationDetailTable">
                                <p class="hoursTitle">Hours of Operation</p>
                                <table>
                                    <tbody>
                                    <?php foreach ($locationHours as $key => $value) : ?>
                                        <?php if ($key === "Today") : ?>
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
                        </div>
                    </div>
                    <div id="requestAppointment" class="locationDetailsContentRight smoothScroll">
                        <p class="appointmentTitle">Request an Appointment</p>
                        <?= do_shortcode('[generic_form delivery_email="'.$clinicEmail.'"]'); ?>
                    </div>
                </div>
            </div>
        </div>
    <div id="map"></div>
</section>

    <div class="clinicHome-bg-icon bg-single-icon bg-single-icon-grey bg-single-icon-nutrition-white">

        <?php if(get_field('about_clinic_description', 'clinic_home_options')): ?>

        <section class="aboutClinic centerAlign">
            <div class="container">
                    <h3>About this <span class="bold">max</span>living clinic</h3>
                    <div class="aboutDescription"><?php echo get_field('about_clinic_description', 'clinic_home_options'); ?></div>
                    <div class="fullImage" style="background-image:url('<?php echo $clinicImage['url']; ?>');"><img
                                class="image" src="<?php echo $clinicImage['url']; ?>"
                                alt="<?php echo $locationName; ?>"></div>
                <?php if ($teamSection['show_about_team_section']) : ?>
                    <section class="aboutTeam centerAlign">
                        <h3>About our Team</h3>
                        <div><?php echo $teamSection['about_team_description']; ?></div>
                        <?php if ($teamSection['show_about_page_button']) : ?>
                            <div class="centerAlign">
                                <a href="<?php echo get_home_url().'/our-team';?>" class="button button-secondary">Learn More</a>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>
            </div>
        </section>

        <?php else: switch_to_blog(1); ?>

        <section class="aboutClinic centerAlign">
            <div class="container">
                    <h3>About this <span class="bold">max</span>living clinic</h3>
                    <div class="aboutDescription"><?php echo get_field('about_clinic_description_default_clinic', 'sitewide_content'); ?></div>
                    <div class="fullImage" style="background-image:url('<?php echo $clinicImage['url']; ?>');"><img
                                class="image" src="<?php echo $clinicImage['url']; ?>"
                                alt="<?php echo $locationName; ?>"></div>
            </div>
        </section>

        <?php restore_current_blog(); endif; ?>

        <?php if (have_rows('services_benefits', 'clinic_home_options')): ?>
            <section class="services centerAlign">
                <h2 class="borderText border-brandGrey">Services &amp; Benefits</h2>
                <div class="flexible-contentWithImage">
                    <div class="container">
                        <?php while (have_rows('services_benefits', 'clinic_home_options')): the_row(); ?>

                            <div class="contentRow leftAlign">
                                <div class="contentContainer">
                                    <h3><?php the_sub_field('title'); ?></h3>
                                    <div><?php the_sub_field('description'); ?></div>
                                    <?php if (have_rows('description_points_area', 'clinic_home_options')): ?>

                                        <ul>
                                            <?php while (have_rows('description_points_area', 'clinic_home_options')): the_row(); ?>
                                                <li><?php the_sub_field('description_point'); ?></li>
                                            <?php endwhile; ?>
                                        </ul>

                                    <?php endif; ?>

                                    <?php if (get_sub_field('show_request_appointment_button')): ?>
                                        <p>
                                            <a href="<?php echo $appointmentLink;?>" class="button button-tertiary button-large">Request
                                                Appointment</a>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="imageContainer">
                                    <?php

                                    $clinicImageUrl = get_template_directory_uri() . "/images/placeholder.jpeg";
                                    $clinicImageAlt = "";
                                    if (get_sub_field('image')) {
                                        $clinicImage = get_sub_field('image');
                                        $clinicImageUrl = wp_get_attachment_image_src($clinicImage['ID'], '')[0];
                                        $clinicImageAlt = $clinicImage['alt'];
                                    }

                                    ?>
                                    <div class="imageContent bg-image"
                                         style="background-image:url('<?php echo $clinicImageUrl; ?>');">
                                        <img class="image" src="<?php echo $clinicImageUrl; ?>" alt="<?php echo $clinicImageAlt ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        <?php else: switch_to_blog(1); ?>
        <?php if (have_rows('services_benefits_clinic', 'sitewide_content')): ?>
            <section class="services centerAlign">
                <h2 class="borderText border-brandGrey">Services &amp; Benefits</h2>
                <div class="flexible-contentWithImage">
                    <div class="container">
                        <?php while (have_rows('services_benefits_clinic', 'sitewide_content')): the_row(); ?>

                            <div class="contentRow leftAlign">
                                <div class="contentContainer">
                                    <h3><?php the_sub_field('title'); ?></h3>
                                    <div><?php the_sub_field('description'); ?></div>
                                    <?php if (have_rows('description_points_area')): ?>

                                        <ul>
                                            <?php while (have_rows('description_points_area')): the_row(); ?>
                                                <li><?php the_sub_field('description_point'); ?></li>
                                            <?php endwhile; ?>
                                        </ul>

                                    <?php endif; ?>

                                    <?php if (get_sub_field('show_request_appointment_button')): ?>
                                        <p>
                                            <a href="<?php echo $appointmentLink;?>" class="button button-tertiary button-large">Request
                                                Appointment</a>
                                        </p>
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
        <?php endif; ?>

        <?php restore_current_blog(); endif; ?>



    </div>

    <section class="clinicEssentialWrapper bg-faintGrey">
        <div class="essentials essentialsClinic centerAlign">
        <div class="container">
            <h2>Discover the 5 Essentials<sup>&trade;</sup></h2>
            <p>The 5 Essentials<sup>&trade;</sup> is a natural and effective way to align your health. By integrating chiropractic care
                with our four other powerful essentials —mindset, pure and simple nutrition, exercise, and minimizing
                toxins — MaxLiving gives you the tools you need for good health and longevity.</p>
        </div>
        <div class="essentialsContainer container">
            <div class="card card-fifth card-noBorder core">
                <a href="<?php echo $childsite_url . '/five-essentials/core-chiropractic'; ?>" class="essentialLink"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-coreSymbol text-brandGrey"></span>
                    <h3 class="essentialName uppercase">Core Chiropractic</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>The proper function of the nervous system through spinal correction is central to
                                chiropractic care.
                            </p>
                            <a href="<?php echo $childsite_url . '/five-essentials/core-chiropractic'; ?>"
                               class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-fifth card-noBorder nutrition">
                <a href="<?php echo $childsite_url . '/five-essentials/nutrition'; ?>" class="essentialLink"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-nutritionSymbol text-brandGreen"></span>
                    <h3 class="essentialName uppercase">Nutrition</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>Nutrition goes beyond weight loss — a healthy diet focused on natural foods improves your
                                body's composition and muscle-to-fat ratio, helping you achieve better health overall to
                                last a lifetime.
                            </p>
                            <a href="<?php echo $childsite_url . '/five-essentials/nutrition'; ?>"
                               class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-fifth card-noBorder mindset">
                <a href="<?php echo $childsite_url . '/five-essentials/mindset'; ?>" class="essentialLink"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-mindsetSymbol text-brandOrange"></span>
                    <h3 class="essentialName uppercase">Mindset</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>A healthy body starts with the right mindset. We believe a healthy lifestyle supports
                                nutrients for optimal brain function, stress management, and good sleep patterns.
                            </p>
                            <a href="<?php echo $childsite_url . '/five-essentials/mindset'; ?>"
                               class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-fifth card-noBorder oxygen">
                <a href="<?php echo $childsite_url . '/five-essentials/oxygen-and-exercise'; ?>" class="essentialLink"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-oxygenSymbol text-brandTeal"></span>
                    <h3 class="essentialName uppercase">Oxygen &amp; Exercise</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>Exercise helps your body increase oxygen levels and lean muscle, helping reduce fat and
                                improve performance while increasing your ability to fight stress, anxiety, and other
                                illnesses.
                            </p>
                            <a href="<?php echo $childsite_url . '/five-essentials/oxygen-and-exercise'; ?>"
                               class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card card-fifth card-noBorder toxins">
                <a href="<?php echo $childsite_url . '/five-essentials/minimize-toxins'; ?>" class="essentialLink"></a>
                <div class="cardContent">
                    <span class="essentialIcon icon-toxinsSymbol text-brandBrown"></span>
                    <h3 class="essentialName uppercase">Minimize Toxins</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>Minimize Toxins: Harmful chemicals surround us every day in our lives — our program
                                supports the body's natural ability to cleanse itself, resulting in long-lasting
                                positive effects.
                            </p>
                            <a href="<?php echo $childsite_url . '/five-essentials/minimize-toxins'; ?>"
                               class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave wave-white essentialWave"></div>
        </div>
    </section>
    <section class="featuredArticles doctorsBlog container">
        <h2 class="centerAlign">Doctor's Blog</h2>
        <p class="doctorsBlogIntro centerAlign">Hear from our leading experts on the topics of health, nutrition, and
            optimization.</p>
        <div class="articleCon">
            <article>
                <?php
                restore_current_blog();
                global $wpdb;
                $current_time = current_time( 'mysql' );
                $site_regions = get_field('site_option_region_selection','clinic_options');
                $region_string = "1111111,9999999".get_current_blog_id();
                foreach(get_field('site_option_region_selection','clinic_options') as $region) {
                    $region_string .= ",$region";
                }

                $recipe = $wpdb->get_results("
                    SELECT post_id
                    FROM mlpw_custom_post_meta
                    WHERE distribution_code IN ( $region_string )
                    AND post_type = 'recipe'
                    AND publish_date <= '$current_time'
                    ORDER BY publish_date DESC
                    LIMIT 1
                ");

                $recipe_post_id = '';
                if(isset($recipe[0]->post_id) ) {
                    $recipe_post_id = $recipe[0]->post_id;
                }
                switch_to_blog(1);
                $args = array(
                    'p' => $recipe_post_id,
                    'post_type' => 'recipe',
                    'post_status' => 'publish',
                    'posts_per_page' => 1
                );
                $custom_query = new WP_Query($args);
                while ($custom_query->have_posts()) :
                    $custom_query->the_post();
                    $post_link = $childsite_url . '/healthy-recipes/' . get_post()->post_name;
                    ?>
                    <div class="cardTop">
                        <p class="borderText border-brandGreen">Featured Recipe</p>
                        <a class="link-leftDash" href="<?php echo get_home_url().'/healthy-recipes';?>">More Recipes</a>
                    </div>
                    <div class="card card-noBorder card-shadowHover card-underlineHover-brandGreen">
                        <div class="cardContent">
                            <?php
                            $alt = "MaxLiving Recipe";
                            $id = get_post_thumbnail_id($post->ID);
                            $image = wp_get_attachment_image_src($id, 'home-image');
                            if (get_post_meta($id, '_wp_attachment_image_alt', true)) {
                                $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
                            } ?>
                            <div class="imageContainer">
                                <div class="imageContent bg-image"
                                     style="background-image:url('<?php
                                     if (has_post_thumbnail()) {
                                         echo $image[0];
                                     } else {
                                         echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                     }
                                     ?>');">
                                    <a href="<?php echo $post_link; ?>">
                                        <img class="image" src="<?php
                                        if (has_post_thumbnail()) {
                                            echo $image[0];
                                        } else {
                                            echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                        }
                                        ?>" alt="<?php echo $alt; ?>"></a>
                                </div>
                            </div>
                            <div class="cardBody">
                                <h4><a href="<?php echo $post_link; ?>">
                                        <?php the_title(); ?></a></h4>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php echo $post_link; ?>" class="link-leftDash bottomLink">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </article>

            <article>
                <?php

                $article = $wpdb->get_results("
                    SELECT post_id
                    FROM mlpw_custom_post_meta
                    WHERE distribution_code IN ( $region_string )
                    AND post_type = 'article'
                    AND publish_date <= '$current_time'
                    ORDER BY publish_date DESC
                    LIMIT 1
                ");

                $article_post_id = '';
                if(isset($article[0]->post_id) ) {
                    $article_post_id = $article[0]->post_id;
                }
                $args = array(
                    'p' => $article_post_id,
                    'post_type' => 'article',
                    'post_status' => 'publish',
                    'posts_per_page' => 1
                );
                $custom_query = new WP_Query($args);
                while ($custom_query->have_posts()) :
                    $custom_query->the_post();
                    $post_link = $childsite_url . '/healthy-articles/' . get_post()->post_name;
                    ?>
                    <div class="cardTop">
                        <p class="borderText border-brandOrange">Featured Article</p>
                        <a class="link-leftDash" href="<?php echo get_home_url().'/healthy-articles';?>">More Articles</a>
                    </div>
                    <div class="card card-noBorder card-shadowHover card-underlineHover-brandOrange">
                        <div class="cardContent">
                            <?php
                            $alt = "MaxLiving Article";
                            $id = get_post_thumbnail_id($post->ID);
                            $image = wp_get_attachment_image_src($id, 'home-image');
                            if (get_post_meta($id, '_wp_attachment_image_alt', true)) {
                                $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
                            }
                            ?>
                            <div class="imageContainer">
                                <div class="imageContent bg-image"
                                     style="background-image:url('<?php
                                     if (has_post_thumbnail()) {
                                         echo $image[0];
                                     } else {
                                         echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                     }
                                     ?>');">
                                    <a href="<?php echo $post_link; ?>">

                                        <img class="image" src="<?php
                                        if (has_post_thumbnail()) {
                                            echo $image[0];
                                        } else {
                                            echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                        }
                                        ?>" alt="<?php echo $alt; ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="cardBody">
                                <h4><a href="<?php echo $post_link; ?>">
                                        <?php the_title(); ?></a></h4>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php echo $post_link; ?>" class="link-leftDash bottomLink">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </article>
        </div>
    </section>
    <?php

get_footer();
