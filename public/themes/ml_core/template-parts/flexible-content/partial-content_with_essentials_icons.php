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
<section class="<?php echo $sectionBackground; ?> smoothScroll" id="<?php echo $smoothScrollID; ?>">
<div class="flexible-contentEssentialIcon flexibleContentItem container centerAlign">
    <div class="contentContainer">
        <?php if(get_sub_field('category')): ?>
            <div class="borderTextDivider essentialsOverviewDivider">
                <span class="borderText border-brandGrey"><?php the_sub_field('category')?></span>
            </div>
        <?php endif; ?>
        <ul class="iconsList" aria-hidden="true">
            <li class="brandIcon icon-coreSymbol"></li>
            <li class="brandIcon icon-nutritionSymbol"></li>
            <li class="brandIcon icon-mindsetSymbol"></li>
            <li class="brandIcon icon-oxygenSymbol"></li>
            <li class="brandIcon icon-toxinsSymbol"></li>
        </ul>
        <h2 class="title"><?php the_sub_field('title')?></h2>
        <div class="content"><?php the_sub_field('content')?></div>
        <?php if(get_sub_field('cta_link') && get_sub_field('cta_title')):?>
        <a class="button button-secondary" href="<?php the_sub_field('cta_link'); ?>" title="<?php the_sub_field('cta_title'); ?>"><?php the_sub_field('cta_title'); ?></a>
        <?php endif; ?>
    </div>
</div>
</section>
<?php if($bottomWave): ?>
    <div class="<?php echo $bottomWave; ?>"></div>
<?php endif; ?>
