<?php
/**
* The template for displaying 404 pages (not found)
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
* @package MaxLiving
*/
get_header(); ?>

<section class="error-404 not-found" id="content">
	<div class="hero wave wave-multi" style="padding: 12rem 0;background-image:url('<?php echo get_template_directory_uri(); ?>/images/mainHero.jpg');">
        <div class="heroContent centerAlign">
            <h1 class="heroHeadline-large">
                Page Not Found
            </h1>
        </div>
	</div>
	<div class="container centerAlign" style="margin-bottom: 5rem">
		<p style="margin-bottom: 3rem">We're sorry! The page you're looking for can't be found.</p>
		<a href="<?php echo get_home_url(); ?>" class="button button-tertiary button-large">Return Home</a>
	</div>
</section>

<?php
get_footer();
