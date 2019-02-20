<?php
global $blog_id;
global $affiliate_id;
restore_current_blog();
$disclaimer = '';
if (get_option('stylesheet') !== 'ml_whitelabel') {
    switch_to_blog(1);
    $corporate = home_url();
    // Check for Corporates social profiles.
    $socialFacebook = get_field('facebook', 'footer');
    $socialTwitter = get_field('twitter', 'footer');
    $socialInstagram = get_field('instagram', 'footer');
    $socialPinterest = get_field('pinterest', 'footer');
    $socialYouTube = get_field('youtube', 'footer');
    $disclaimer = get_field('disclaimer', 'footer');
    restore_current_blog();
}
?>
<div class="footerTop container">
    <div class="footerNavigationContainer">
        <?php
        get_template_part('template-parts/footer-navigation');
        ?>
    </div>
    <div class="footerContent">
        <?php
        // If Clinic site has own profiles (otherwise keep corporates above)
        if (get_field('facebook', 'footer') || get_field('twitter', 'footer') || get_field('instagram', 'footer')) :
            ?>
            <div class="footerSocial">
                <ul>
                    <?php if (get_field('facebook', 'footer')) : ?>
                        <li>
                            <a href="<?php echo get_field('facebook', 'footer'); ?>" target="_blank" rel="noopener"
                               class="socialIcon icon-facebook icon-footer"
                               title="Facebook">
                                <span class="invisible">Facebook</span>
                            </a>
                        </li>
                    <?php endif;
                    if (get_field('twitter', 'footer')) : ?>
                        <li>
                            <a href="<?php echo get_field('twitter', 'footer'); ?>" target="_blank" rel="noopener"
                               class="socialIcon icon-twitter icon-footer" title="Twitter">
                                <span class="invisible">Twitter</span>
                            </a>
                        </li>
                    <?php endif;
                    if (get_field('instagram', 'footer')) : ?>
                        <li>
                            <a href="<?php echo get_field('instagram', 'footer'); ?>" target="_blank" rel="noopener"
                               class="socialIcon icon-instagram icon-footer"
                               title="Instagram">
                                <span class="invisible">Instagram</span>
                            </a>
                        </li>
                      <?php endif;
                      if (get_field('pinterest', 'footer')) : ?>
                          <li>
                              <a href="<?php echo get_field('pinterest', 'footer'); ?>" target="_blank" rel="noopener"
                                 class="socialIcon icon-pinterest icon-footer"
                                 title="Pinterest">
                                  <span class="invisible">Pinterest</span>
                              </a>
                          </li>
                        <?php endif;
                        if (get_field('youtube', 'footer')) : ?>
                            <li>
                                <a href="<?php echo get_field('youtube', 'footer'); ?>" target="_blank" rel="noopener"
                                   class="socialIcon icon-youtube icon-footer"
                                   title="YouTube">
                                    <span class="invisible">YouTube</span>
                                </a>
                            </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="footerCredit">
            <div class="footerCreditContent">
                <?php get_template_part('template-parts/footer-credit'); ?>
            </div>
            <?php
            if (get_field('disclaimer', 'footer')) {
                $disclaimer = get_field('disclaimer', 'footer');
            }
            if ($disclaimer) : ?>
                <div class="footerCreditContent">
                    <p><strong>Disclaimer:</strong> <?php echo $disclaimer; ?> </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
// Sub Footer Links
get_template_part('template-parts/sub-footer');
?>
