<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();

global $post;

switch ($post->post_name) {
    case 'power-of-chiropractic':
        $heroImage = get_template_directory_uri() . '/images/Hero-AboutUs-PowerOfChiro.jpg';
        break;
    case 'success-stories':
        $heroImage = get_template_directory_uri() . '/images/Hero-AboutUs-PatientSuccessStories.jpg';
        break;
    case 'patient-paperwork':
        $heroImage = get_template_directory_uri() . '/images/hero-new-patient.jpg';
        break;
    default:
        $heroImage = get_template_directory_uri() . '/images/placeholder.jpeg';
        break;
}

if (has_post_thumbnail() && get_the_post_thumbnail_url()) :
    $heroImage = get_the_post_thumbnail_url(get_the_ID(), 'full');
endif;

$heroCategory = '';
if (get_field('header_category')) :
    $heroCategory = get_field('header_category');
endif;

$heroTitle = 'Maxliving';
if (get_the_title()) :
    $heroTitle = get_the_title();
endif;

if (get_field('header_title')) :
    $heroTitle = get_field('header_title');
endif;

$pageIcon = '';
if (get_field('page_background_icon')) :
    $pageIcon = 'bg-single-icon ' . get_field('page_background_icon') . ' bg-single-icon-white';
endif;

if (get_field('hide_newsletter_footer_section')) :
    $showNewsletter = false;
endif;

$introWave = false;
if (have_rows('flexible_content')) :
    $introWave = true;
endif;
?>

    <section class="flexHeader bg-faintGrey" id="content">
        <div class="hero wave wave-multi" style="background-image:url('<?php echo $heroImage; ?>');">
            <div class="heroContent centerAlign container container-xs">
                <?php if ($heroCategory): ?>
                    <p class="heroLeading"><?php echo $heroCategory; ?></p>
                <?php endif; ?>
                <h1 class="heroHeadline"><?php echo $heroTitle; ?></h1>
                <?php if (get_field('header_desc')): ?>
                    <p class="heroDescription">
                        <?php the_field('header_desc'); ?>
                    </p>
                <?php endif; ?>
                <span class="icon-lineWave"></span>
            </div>
        </div>
        <?php if (get_field('show_below_header_section')): ?>
            <div class="flexIntro centerAlign<?php if ($introWave) {
                echo ' wave wave-white';
            } ?>">
                <?php if (get_field('below_header_title') && get_field('below_header_body')): ?>
                    <div class="container">

                        <h2><?php the_field('below_header_title'); ?></h2>
                        <div><?php the_field('below_header_body'); ?></div>
                        <?php if (get_field('show_below_header_section_cta')): ?>
                            <a href="<?php the_field('below_header_cta_link'); ?>" class="button button-primary"
                               title="<?php the_field('below_header_cta_title'); ?>"><?php the_field('below_header_cta_title'); ?></a>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <div class="flexibleContentWrapper bg-white <?php echo $pageIcon; ?>">
        <?php

        /**
         * Loop through the Flexible Content for the page
         */
        while (the_flexible_field('flexible_content')):
            switch (get_row_layout()) {
                case 'full_width': // layout: Full Width Content Area
                    get_template_part('template-parts/flexible-content/partial', 'full_width');
                    break;
                case 'full_width_with_cards': // layout: Full Width Content with Cards
                    get_template_part('template-parts/flexible-content/partial', 'full_width_with_cards');
                    break;
                case 'left_right_content_areas': // layout: Left / Right Content Areas
                    get_template_part('template-parts/flexible-content/partial', 'left_right_content_areas');
                    break;
                case 'full_intro_with_alternating_image_content': // layout: Full Width Intro with Alternating Image / Content Below
                    get_template_part('template-parts/flexible-content/partial', 'full_intro_with_alternating_image_content');
                    break;
                case 'content_with_image': // layout: Content with Image
                    get_template_part('template-parts/flexible-content/partial', 'content_with_image');
                    break;
                case 'featured_video_block': // layout: Content with Featured Video Block
                    get_template_part('template-parts/flexible-content/partial', 'featured_video_block');
                    break;
                case 'video_card_list': // layout: Video Card List
                    get_template_part('template-parts/flexible-content/partial', 'video_card_list');
                    break;
                case 'faq_section': // layout: FAQ Section
                    get_template_part('template-parts/flexible-content/partial', 'faq_section');
                    break;
                case 'form': // layout: Form
                    get_template_part('template-parts/flexible-content/partial', 'forms');
                    break;
                case 'pdf_downloads': // layout: PDF Downloads
                    get_template_part('template-parts/flexible-content/partial', 'pdf_downloads');
                    break;
                case 'content_with_essentials_icons': // layout: Content with Essentials Icons
                    get_template_part('template-parts/flexible-content/partial', 'content_with_essentials_icons');
                    break;
                case 'event_promo': // layout: Event Promotion Section
                    get_template_part('template-parts/flexible-content/partial', 'event_promo');
                    break;
            }
        endwhile;
        ?>
    </div>
<?php
get_footer();
