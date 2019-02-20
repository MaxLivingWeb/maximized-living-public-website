<?php
$sectionOptions = get_sub_field('section_options');
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
<section class="flexible-fullWidthCards flexibleContentItem smoothScroll <?php echo $sectionBackground; ?>" id="<?php echo $smoothScrollID; ?>">
    <?php if( get_sub_field('full_width_title') || get_sub_field('full_width_text')) : ?>
    <div class="flexible-fullWidth centerAlign container">
        <h2 class="title"><?php the_sub_field('full_width_title'); ?></h2>
        <div class="description"><?php the_sub_field('full_width_text'); ?></div>
    </div>
    <?php endif; ?>

    <?php if (have_rows('cards')): ?>

        <div class="cardContainer">

            <?php
                $count = 0;
                $cardNumbers = '';
                while (have_rows('cards')) {
                    the_row();
                    $count++;
                }
                if($count == 2){
                    $cardNumbers = 'card-half';
                }
                if($count >= 3){
                    $cardNumbers = 'card-third';
                }
            ?>

            <?php while (have_rows('cards')): the_row(); ?>
                <div class="card card-shadow centerAlign <?php echo $cardNumbers; ?>">
                    <?php if(get_sub_field('icon')) :?>
                        <span class="image bg-image <?php the_sub_field('icon'); ?>"></span>
                    <?php endif; ?>
                    <?php if(get_sub_field('title')) :?>
                        <h3><?php the_sub_field('title'); ?></h3>
                    <?php endif; ?>
                    <?php if(get_sub_field('content')) :?>
                        <div><?php the_sub_field('content'); ?></div>
                    <?php endif; ?>
                    <?php if(get_sub_field('cta_link')) : ?>
                        <a class="button button-secondary" href="<?php the_sub_field('cta_link'); ?>" title="<?php the_sub_field('cta_title'); ?>"><?php the_sub_field('cta_title'); ?></a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

    <?php endif; ?>

</section>
<?php if($bottomWave): ?>
<div class="<?php echo $bottomWave; ?>"></div>
<?php endif; ?>
