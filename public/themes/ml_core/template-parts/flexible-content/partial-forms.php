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
$smoothScrollID = "";
if ($sectionOptions['smoothscroll_id']) {
    $smoothScrollID = $sectionOptions['smoothscroll_id'];
    global $smoothScrollScripts;
    $smoothScrollScripts = true;
}
?>

<section class="<?php if(get_sub_field('form') == 1 || get_sub_field('form') == 2): ?>wholesalerAffiliateForm<?php endif; ?> flexible-fullWidth flexibleContentItem smoothScroll <?php if(get_sub_field('form') != 1 && get_sub_field('form') != 2){ echo $sectionBackground." "; echo $bottomWave;} ?>" id="<?php echo $smoothScrollID; ?>">
    <?php
    if(get_sub_field('form') == 1):
    echo do_shortcode('[affiliate_form]');
    endif;
    if(get_sub_field('form') == 2):
    echo do_shortcode('[wholesale_form]');
    endif;
    if(get_sub_field('form') == 3):
    echo do_shortcode('[generic_form show_affiliate_id=true delivery_email="'.get_sub_field('email').'"][/generic_form]');
    endif;
    if(get_sub_field('form') == 4):
    echo do_shortcode('[corporate_wellness_form delivery_email="'.get_sub_field('email').'"][/corporate_wellness_form]');
    endif;
    ?>
</section>
