<?php /* Template Name: Clinic - About Page */
/**
 * Template for Team Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();

$heroImage = get_template_directory_uri() . '/images/WhiteLabel_OurTeam_Hero.jpg';
if (has_post_thumbnail()) :
    $heroImage = get_the_post_thumbnail_url(get_the_ID(), 'full');
endif;

?>
    <div class="hero" style="background-image:url('<?php echo $heroImage; ?>');" id="content">
        <div class="heroContent ourTeamHero centerAlign container container-xs">
            <h1 class="heroHeadline">Our Team</h1>
            <p>Meet the team of chiropractic doctors and professionals at our clinic. </p>
        </div>
    </div>
    <section class="clinicAbout bg-faintGrey">
        <div class="container">
            <div class="aboutHeader centerAlign">
                <h2>Meet the Doctors</h2>
                <div><?php echo get_field('meet_the_doctors_description', 'clinic_about_options'); ?></div>
            </div>
            <?php if (have_rows('doctors', 'clinic_about_options')): ?>
                <div class="doctorsList">
                    <?php while (have_rows('doctors', 'clinic_about_options')): the_row(); ?>
                        <div class="doctor">
                            <div class="teamPhoto">
                                <?php $doctorImage = get_sub_field('doctor_image'); ?>
                                <div class="image bg-image"
                                     style="background-image: url('<?php echo wp_get_attachment_image_src($doctorImage['ID'], 'clinic-doctor')[0]; ?>')">
                                    <img src="<?php echo wp_get_attachment_image_src($doctorImage['ID'], 'clinic-doctor')[0]; ?>"
                                         alt="<?php echo $doctorImage['alt']; ?>">
                                </div>
                            </div>
                            <div class="teamDesc">
                                <h3><?php the_sub_field('doctor_name'); ?></h3>
                                <p class="title"><?php the_sub_field('doctor_title'); ?></p>
                                <div class="bio"><?php the_sub_field('doctor_bio'); ?></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php if (have_rows('staff_cards', 'clinic_about_options')): ?>
    <section class="teamHeader bg-white container">
        <div class="teamIntro centerAlign">
            <h2 class="category borderText borderText-divider border-brandGrey">Our Staff</h2>
            <p>Our staff members work with our doctors every day to provide our patients with a professional and
                friendly experience.</p>
        </div>
        <div class="teamCardList">
            <?php while (have_rows('staff_cards', 'clinic_about_options')): the_row(); ?>
                <div class="teamCard card card-shadow">
                    <?php $staffImage = get_sub_field('staff_image'); ?>
                    <div class="teamPhoto bg-image"
                         style="background-image:url('<?php echo wp_get_attachment_image_src($staffImage['ID'], 'clinic-staff')[0]; ?>')">
                    </div>
                    <div class="teamDesc">
                        <h3><?php the_sub_field('staff_name'); ?></h3>
                        <p class="title"><?php the_sub_field('staff_title'); ?></p>
                        <div class="bio"><?php the_sub_field('staff_bio'); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif; ?>

    <section class="flexible-contentEssentialIcon aboutFooter container centerAlign">
        <div class="contentContainer">
            <div class="borderTextDivider essentialsOverviewDivider">
                <span class="borderText border-brandGrey">Appointments</span>
            </div>
            <h2 class="title">Book an appointment with a chiropractor</h2>
            <p class="content">Contact our clinic today to make an appointment.</p>
            <a class="button button-secondary" href="<?php echo get_home_url() . '/sign-up'; ?>"
               title="Request Appointment">Request an Appointment</a>
        </div>
    </section>

<?php
get_footer();
