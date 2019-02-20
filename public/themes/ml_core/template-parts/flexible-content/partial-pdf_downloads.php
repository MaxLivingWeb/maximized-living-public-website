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
<section class="flexibleContentItem smoothScroll <?php echo $sectionBackground; ?>" id="<?php echo $smoothScrollID; ?>">
    <div class="flexible-fullWidth container flexible-pdfDownloads">

        <?php
        if (!get_field('hide_default_paperwork', 'clinic_patient_paperwork_options')) :
            if (have_rows('files')):
                while (have_rows('files')) : the_row(); ?>

                    <div class="fileItem">
                        <a class="fileIcon" target="_blank" href="<?php the_sub_field('file'); ?>"></a>
                        <a class="fileTitle" target="_blank"
                           href="<?php the_sub_field('file'); ?>"><?php the_sub_field('title'); ?></a>
                    </div>

                <?php
                endwhile;
            endif;
        endif;
        if (get_current_blog_id() != 1):
        if (have_rows('files', 'clinic_patient_paperwork_options')):
            while (have_rows('files', 'clinic_patient_paperwork_options')) : the_row(); ?>
                <div class="fileItem">
                    <a class="fileIcon" target="_blank" href="<?php the_sub_field('file'); ?>"></a>
                    <a class="fileTitle" target="_blank"
                       href="<?php the_sub_field('file'); ?>"><?php the_sub_field('title'); ?></a>
                </div>

            <?php
            endwhile;
        endif; endif; ?>


    </div>
</section>
<?php if ($bottomWave): ?>
    <div class="<?php echo $bottomWave; ?>"></div>
<?php endif; ?>
