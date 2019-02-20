<?php
global $faqScripts;
$faqScripts = true;

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

<section class="faq flexible-fullWidth flexibleContentItem smoothScroll <?php echo $sectionBackground." "; echo $bottomWave; ?>" id="<?php echo $smoothScrollID; ?>">
    <div class="container container-sm centerAlign">
        <?php if(get_sub_field('bordered_title')):?>
        <span class="category borderText border-brandGrey"><?php the_sub_field('bordered_title'); ?></span>
        <?php endif; ?>
        <h2 class="title"><?php the_sub_field('title'); ?></h2>
        <div class="description"><?php the_sub_field('description'); ?></div>

        <?php if (have_rows('faqs')): ?>
            <div class="faqList leftAlign">

                <?php while (have_rows('faqs')): the_row(); ?>
                    <div class="faqItem">
                        <h3 class="faqTitle"><?php the_sub_field('faq_title'); ?></h3>
                        <div class="faqContent">
                            <?php the_sub_field('faq_answer'); ?>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
        <?php endif; ?>

        <?php if (get_sub_field('section_button')): ?>
            <a class="button button-tertiary" href="<?php the_sub_field('button_link'); ?>" class=""
                title="<?php the_sub_field('button_text'); ?>"><?php the_sub_field('button_text'); ?></a>
            <?php endif; ?>
        </div>
    </section>
