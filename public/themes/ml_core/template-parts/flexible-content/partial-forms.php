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

<section class="">

    <div class="contactFormContainer container" style="margin-bottom: 0px;">
      <div class="contactFormIntro centerAlign">
                        <h2>Get Started Today</h2>
                        <p></p><p>Give yourself a competitive edge in the field with MaxU. Fill out the form below to learn more about the exciting opportunities at MaxLiving that await you after graduation. We’ll get back to you soon with more information.

</p>

                    </div>
                    <?php
                    if(get_sub_field('form') == 1):
                    echo do_shortcode('[contact-form-7 id="908" title="Student"]');
                    endif;
                    ?>
    </div>
</section>
