<?php
$sectionOptions = get_sub_field('section_options');
$sectionBackground = '';
if ($sectionOptions['background']) {
    $sectionBackground = $sectionOptions['background'];
}
$titleHeader = 'h2';
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
<section class="flexible-leftRightContent flexibleContentItem smoothScroll <?php echo $sectionBackground; ?>" id="<?php echo $smoothScrollID; ?>">
    <div class="container">
        <?php if (have_rows('leftright_display')): ?>
            <?php while (have_rows('leftright_display')): the_row(); ?>
                <div class="leftRightRow">
                    <?php if(get_sub_field('category')) : ?>
                        <?php $titleHeader = 'h3'; ?>
                        <div class="category centerAlign">
                            <h2 class="borderText"><?php the_sub_field('category'); ?></h2>
                        </div>
                    <?php endif; ?>
                    <?php if(get_sub_field('content_title')) : ?>
                        <<?php echo $titleHeader; ?> class="title"><?php the_sub_field('content_title'); ?></<?php echo $titleHeader; ?>>
                    <?php endif; ?>
                    <div class="contentContainer">
                        <div class="content content-left"><?php the_sub_field('content_left'); ?></div>
                        <div class="content content-right"><?php the_sub_field('content_right'); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>
<?php if($bottomWave): ?>
    <div class="<?php echo $bottomWave; ?>"></div>
<?php endif; ?>
