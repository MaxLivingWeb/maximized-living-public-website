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
<section class="flexibleContentItem <?php echo $sectionBackground;?> centerAlign smoothScroll" id="<?php echo $smoothScrollID; ?>">
    <div class="flexible-fullWidth container">
        <h2 class="title"><?php the_sub_field('full_width_title'); ?></h2>
        <div class="description"><?php the_sub_field('full_width_text'); ?></div>
        <?php if(get_sub_field('cta_link') && get_sub_field('cta_title')):?>
            <a class="button button-secondary" href="<?php the_sub_field('cta_link'); ?>" title="<?php the_sub_field('cta_title'); ?>"><?php the_sub_field('cta_title'); ?></a>
        <?php endif; ?>
    </div>
</section>
<?php if($bottomWave): ?>
<div class="<?php echo $bottomWave; ?>"></div>
<?php endif; ?>
