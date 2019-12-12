<?php /* Template Name: Clinic - Request Appointment */
/**
 * Template for Clinic - Request Appointment
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();

$api_call = new \MaxLiving\Location\FrontEnd\Functions();

$location = $api_call->get_location_by_site_id(get_current_blog_id());
$location_info = $location->locations[0];

$locationTelephone = $location_info->telephone;
$clinicEmail='';
if(WPENV === 'production'){
    $clinicEmail = $location_info->email;
}

//Phone Formatting
if ($locationTelephone) {
    $phone = $locationTelephone;
    $phone = preg_replace('/\D+/', '', $phone);
    $phoneFormatted = '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
}

$heroImage = get_template_directory_uri() . "/images/hero-request-appt.jpg";
if (has_post_thumbnail()) :
    $heroImage = get_the_post_thumbnail_url(get_the_ID(),'full');
endif;

?>

<div class="hero wave wave-multi" style="background-image:url('<?php echo $heroImage; ?>');" id="content">
    <div class="heroContent signUpHero centerAlign container">
        <h1 class="heroHeadline">Request an Appointment</h1>
        <p class="heroDescription container container-xs">
            Start your journey to transform your health through the 5 Essentials<sup>&trade;</sup>. The first step is connecting with a MaxLiving doctor in your area.
        </p>
        <span class="icon-lineWave"></span>
    </div>
</div>

<section class="bookAppointment bg-white container container-sm">
    <div class="bookAppointmentIntro centerAlign">
        <h2>Contact Our Clinic</h2>
        <p>
            To request an appointment, please complete and submit the form below. Someone from our clinic will contact you soon to schedule your consultation.
        </p>
    </div>
    <?php echo do_shortcode('[contact-form-7 id="'.get_field('appointment_id', 'clinic-home-page-options').'" title="Request an Appointment"]'); ?>
</section>

<?php if ($locationTelephone && $clinicEmail) : ?>
<section class="appointmentCards flexible-fullWidthCards flexibleContentItem container container-xs">
    <div class="flexible-fullWidth centerAlign">
        <h2 class="title">Other Ways to Connect</h2>
        <div class="description">If you’d prefer, you can also request an appointment by phone or email.</div>
    </div>
    <div class="cardContainer">
        <div class="card card-shadow centerAlign card-half">
            <span class="image bg-image iconTwoTone twoTone-phoneCall"></span>
            <h3>Phone</h3>
            <p class="link"><a class="link-underlineOnHover" href="tel:<?php echo $phone; ?>" data-phone class="phoneNumberAW"><?php echo $phoneFormatted; ?></a></p>
        </div>
        <div class="card card-shadow centerAlign card-half">
            <span class="image bg-image iconTwoTone twoTone-email"></span>
            <h3>Email</h3>
            <p class="link"><a class="link-underlineOnHover" href="mailto:<?php echo $clinicEmail; ?>"><?php echo $clinicEmail; ?></a></p>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
get_footer();
