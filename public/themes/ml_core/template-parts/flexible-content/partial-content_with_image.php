<?php
$sectionOptions = get_sub_field('section_options');
$img = get_sub_field('image');
$img_alt = $img['alt'];
$img_url = $img['sizes']['flexible-content-image'];
$sectionBackground = '';
if ($sectionOptions['background']) {
    $sectionBackground = $sectionOptions['background'];
}
$bottomWave = "";
if ($sectionOptions['bottom_wave']) {
    $bottomWave = $sectionOptions['bottom_wave'];
}
$smoothScrollID="";
if ($sectionOptions['smoothscroll_id']) {
    $smoothScrollID = $sectionOptions['smoothscroll_id'];
    global $smoothScrollScripts;
    $smoothScrollScripts = true;
}
?>

<section class="flexible-contentWithImage flexibleContentItem smoothScroll <?php echo $sectionBackground." "; echo $bottomWave; ?>" id="<?php echo $smoothScrollID; ?>">
    <div class="container">

        <?php if (get_sub_field('bordered_title')) : ?>
            <span class="category borderText aligncenter topBorderText"><?php the_sub_field('bordered_title'); ?></span>
        <?php endif; ?>

        <?php if (have_rows('content_with_image')):

            $item = 0;//power chiro image fix
            $imgAlt = array(
                'Person stretching',
                'Chiropractor with client',
                'Chiropractor adjusting client'
            );

            while (have_rows('content_with_image')): the_row(); ?>
                <div class="contentRow">
                    <div class="contentContainer">
                        <?php if (get_sub_field('category')) : ?>
                            <span class="category borderText"><?php the_sub_field('category'); ?></span>
                        <?php endif; ?>
                        <?php if (get_sub_field('content_title')) : ?>
                            <h3 class="title"><?php the_sub_field('content_title'); ?></h3>
                        <?php endif; ?>
                        <?php if (get_sub_field('content')) : ?>
                            <div class="content"><?php the_sub_field('content'); ?></div>
                        <?php endif; ?>
                        <?php if (get_sub_field('cta_link')) : ?>
                            <a class="button button-secondary" href="<?php the_sub_field('cta_link'); ?>"
                               title="<?php the_sub_field('cta_title'); ?>"><?php the_sub_field('cta_title'); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php
                    $img = get_sub_field('image');
                    $imgUrl = wp_get_attachment_image_src($img['ID'], 'flexible-content-image')[0];
                    if ( $post->post_name === 'power-of-chiropractic' && $item <= 2 && get_current_blog_id() != 1 ) {//power chiro image fix
                        $imgUrl = get_template_directory_uri() . '/lib/images/power-of-chiropractic/image' . $item . '.jpg';
                        $imgAlt = $imgAlt[ $item ];
                        $item ++;
                    }
                    ?>
                    <div class="imageContainer">
                        <?php if ($img) : ?>
                            <div class="imageContent bg-image"
                                 style="background-image: url('<?php echo $imgUrl; ?>');">
                                <img class="image" src="<?php echo $imgUrl; ?>" alt="<?php echo $imgAlt; ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile; ?>

        <?php endif; ?>

    </div>
</section>
