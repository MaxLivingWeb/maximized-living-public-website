<?php

$sectionOptions = get_sub_field( 'section_options' );

$img               = get_sub_field( 'image' );
$img_alt           = $img['alt'];
$img_url           = $img['sizes']['flexible-content-image'];
$sectionBackground = '';
if ( $sectionOptions['background'] ) {
    $sectionBackground = $sectionOptions['background'];
}
$bottomWave = "";
if ( $sectionOptions['bottom_wave'] ) {
    $bottomWave = $sectionOptions['bottom_wave'];
}
$squiggle = "";
if ( get_sub_field( 'squiggle_color' ) ) {
    $squiggle = get_sub_field( 'squiggle_color' );
}
$smoothScrollID = "";
if ( $sectionOptions['smoothscroll_id'] ) {
    $smoothScrollID = $sectionOptions['smoothscroll_id'];
    global $smoothScrollScripts;
    $smoothScrollScripts = true;
}
?>
<section
        class="flexible-introWithAlternatingContent flexibleContentItem smoothScroll <?php echo $sectionBackground . " ";
        echo $bottomWave; ?>" id="<?php echo $smoothScrollID; ?>">
    <div class="container">
        <?php if ( get_sub_field( 'full_width_title' ) || get_sub_field( 'full_width_text' ) ) : ?>
            <div class="intro centerAlign">
                <h2 class="introTitle"><?php the_sub_field( 'full_width_title' ); ?></h2>
                <p class="introContent"><?php the_sub_field( 'full_width_text' ); ?></p>
                <span class="introDivider icon-lineWave"
                      <?php if ( $squiggle ): ?>style="color: <?php echo $squiggle; ?>; "<?php endif; ?>></span>
            </div>
        <?php endif;
        if ( have_rows( 'content_with_image' ) ):
            while ( have_rows( 'content_with_image' ) ): the_row();
                $img = get_sub_field( 'image' );
                $imgUrl = wp_get_attachment_image_src($img['ID'], 'flexible-content-image')[0];
                if ( $post->post_name === 'power-of-chiropractic' && get_current_blog_id() != 1) {//power chiro image fix
                    $imgUrl = get_template_directory_uri() . '/lib/images/power-of-chiropractic/image3.jpg';
                    $img['alt'] = 'Chiropractor adjusting client';
                }
                ?>
                <div class="contentRow">
                    <div class="imageContainer">
                        <?php if ( $img ) : ?>
                            <div class="imageContent bg-image"
                                 style="background-image: url('<?php echo $imgUrl; ?>');">
                                <img class="image" src="<?php echo $imgUrl; ?>" alt="<?php echo $img['alt']; ?>">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="contentContainer">
                        <?php if ( get_sub_field( 'content_title' ) ) : ?>
                            <h3 class="title"><?php the_sub_field( 'content_title' ); ?></h3>
                        <?php endif; ?>
                        <?php if ( get_sub_field( 'content' ) ) : ?>
                            <div class="content"><?php the_sub_field( 'content' ); ?></div>
                        <?php endif; ?>
                        <?php if ( get_sub_field( 'cta_link' ) ) : ?>
                            <a class="button button-secondary" href="<?php the_sub_field( 'cta_link' ); ?>"
                               title="<?php the_sub_field( 'cta_title' ); ?>"><?php the_sub_field( 'cta_title' ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php
            endwhile;
        endif; ?>
    </div>

</section>
