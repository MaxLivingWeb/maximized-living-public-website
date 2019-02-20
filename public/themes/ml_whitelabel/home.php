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
$clinicEmail = '';
if (WPENV === 'production') {
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
    $phone = \MaxLiving\Location\FrontEnd\Functions::unformat_number($locationTelephone);
    $phoneFormatted = \MaxLiving\Location\FrontEnd\Functions::format_telephone($locationTelephone);
}

//Website URL Formatting
$locationWebsite = get_home_url();
$locationWebsite = preg_replace('#^https?://#', '', rtrim($locationWebsite, '/'));

//Directions Link
$locationDirections = 'https://www.google.com/maps?daddr=' . str_replace(' ', '+', $locationAddress1) . '+' . str_replace(' ', '+', $locationCity) . '+' . str_replace(' ', '+', $locationState) . '+' . str_replace(' ', '+', $locationZipPostalCode) . '+' . str_replace(' ', '+', $locationCountry);

if (get_field('google_maps_direction', 'clinic_home_options')) {
    $locationDirections = get_field('google_maps_direction', 'clinic_home_options');
}

//Clinic Image
$clinicImage = get_template_directory_uri() . "/images/placeholder.jpeg";

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
$childsite_id = get_current_blog_id();
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

    <section class="clinicHomeHeader
        <?php if (get_field('about_clinic_description', 'clinic_home_options') || have_rows('services_benefits', 'clinic_home_options')): ?>
            wave wave-lightBrown
        <?php endif; ?>
    " id="content">
        <div class="hero"
             style="background-image:url('<?php echo get_template_directory_uri() . '/images/WhiteLabel_Home_Hero.jpg'; ?>');">
            <div class="heroContent centerAlign container">
                <?php if ($locationName) : ?>
                    <p class="heroLeading"><?php echo $locationName; ?></p>
                <?php endif; ?>
                <p class="heroHeadline-large">
                    Chiropractic Care
                </p>
                <p class="heroDescription">We want to help you live a longer, healthier life through chiropractic.
                </p>
                <a href="#requestAppointment">
                    <button class="button button-tertiary button-large"
                            title="Request Appointment <?php if ($locationName): echo 'at ' . $locationName; endif; ?>">
                        Request Appointment
                    </button>
                </a>
            </div>
        </div>

        <div class="locationDetailsContainer container" id="contact">
            <div class="locationDetailsCard card card-noBorder card-shadow card-underline card-underline-brandGrey">
                <div class="locationDetailsLocation">
                    <?php if ($locationName) : ?>
                        <h1><?php echo $locationName; ?></h1>
                    <?php endif; ?>
                </div>
                <div class="locationDetailsContent">
                    <div class="locationDetailsContentLeft">
                        <div class="locationDetailsContact">
                            <p class="address"><?php echo $locationAddress1; ?><?php if ($locationAddress2):echo ', ' . $locationAddress2;endif; ?>
                                <br><?php echo $locationCity . ', ';
                                echo $locationState . ', ';
                                echo $locationZipPostalCode . ' ';
                                echo $locationCountry; ?></p>
                            <?php if ($locationTelephone) : ?>
                                <p class="iconContact icon-phone">Tel: <a href="tel:<?php echo $phone; ?>"
                                                                          class="phoneNumberAW"
                                                                          title="Call us at <?php echo $phoneFormatted; ?>"
                                                                          data-phone><?php echo $phoneFormatted; ?></a>
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
                                   title="Get Directions" target="_blank" data-direction
                                   data-clinic-name="<?php if ($locationName) {
                                       echo $locationName;
                                   } ?>">Get Directions</a>
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
                        <?= do_shortcode('[generic_form show_affiliate_id=true delivery_email="' . $clinicEmail . '"]'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="map"></div>
    </section>
<?php if (get_field('about_clinic_description', 'clinic_home_options') || have_rows('services_benefits', 'clinic_home_options')): ?>

    <div class="clinicHomeAbout bg-faintGrey">

        <?php if (get_field('about_clinic_description', 'clinic_home_options')): ?>

            <section class="aboutClinic centerAlign">
                <div class="container">
                    <?php if (get_field('about_clinic_description', 'clinic_home_options')) : ?>
                        <h3>About <?php echo $locationName; ?></h3>
                        <div class="aboutDescription container container-sm">
                            <p>
                                <?php echo get_field('about_clinic_description', 'clinic_home_options'); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif;
        if (have_rows('services_benefits', 'clinic_home_options')): ?>
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

                                    <?php endif;
                                    if (get_sub_field('show_request_appointment_button')): ?>
                                        <p>
                                            <a href="<?php echo $appointmentLink; ?>"
                                               class="button button-tertiary button-large">Request
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
                                        <img class="image" src="<?php echo $clinicImageUrl; ?>"
                                             alt="<?php echo $clinicImageAlt ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php endif; ?>

    <section class="featuredArticles doctorsBlog container">
        <h2 class="centerAlign">Doctor's Blog</h2>
        <p class="doctorsBlogIntro centerAlign">Hear from our leading experts on the topics of health, nutrition, and
            optimization.</p>
        <div class="articleCon">
            <article>
                <?php
                $args = array(
                    'posts_per_page' => 1,
                    'post_type' => 'recipe',
                    'meta_key' => 'siteOriginID',
                    'meta_value' => $childsite_id
                );
                $custom_query = new WP_Query($args);
                while ($custom_query->have_posts()) :
                    $custom_query->the_post();
                    $post_link = $childsite_url . '/healthy-recipes/' . get_post()->post_name;
                    ?>
                    <div class="cardTop">
                        <p class="borderText border-brandGreen">Featured Recipe</p>
                        <a class="link-leftDash" href="<?php echo get_home_url() . '/healthy-recipes'; ?>">More
                            Recipes</a>
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
                                <h3><a href="<?php echo $post_link; ?>">
                                        <?php the_title(); ?></a></h3>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php echo $post_link; ?>" class="link-leftDash bottomLink">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </article>

            <article>
                <?php
                restore_current_blog();
                $args = array(
                    'posts_per_page' => 1,
                    'post_type' => 'article',
                    'meta_key' => 'siteOriginID',
                    'meta_value' => $childsite_id
                );
                $custom_query = new WP_Query($args);
                while ($custom_query->have_posts()) :
                    $custom_query->the_post();
                    $post_link = $childsite_url . '/healthy-articles/' . get_post()->post_name;
                    ?>
                    <div class="cardTop">
                        <p class="borderText border-brandOrange">Featured Article</p>
                        <a class="link-leftDash" href="<?php echo get_home_url() . '/healthy-articles'; ?>">More
                            Articles</a>
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
                                <h3><a href="<?php echo $post_link; ?>">
                                        <?php the_title(); ?></a></h3>
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
