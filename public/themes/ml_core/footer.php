<?php
global $showNewsletter;
global $blog_id;
if ($showNewsletter === 123):
    $footerStyleIcon = "all";
    $footerStyleColour = "brandGrey";
    global $footerStyleTitle;
    if ($footerStyleTitle) :
        $footerStyleIcon = $footerStyleTitle;
        $footerStyleColour = $footerStyleTitle;
    endif;
    restore_current_blog();
    ?>
    <div class="footerCallout bg-pattern bg-pattern-<?php echo $footerStyleIcon; ?> <?php echo "bg-" . $footerStyleColour; ?>">
        <div class="footerCalloutContent">
            <h2>Get the Latest Updates</h2>
            <p>Sign up to get the latest <strong>news, resources,</strong> and <strong>exclusive offers</strong> from
                MaxLiving&nbsp;— <br/> straight to your inbox.</p>
            <a class="button" href="#">Subscribe Now</a>
        </div>
    </div>
<?php endif; ?>
</main><?php // End of main tag started in header -- do not delete! ?>

<?php
global $showFooter;
global $simpleFooter;
if ($showFooter === true): ?>
    <footer id="footer">
        <?php
        if ($simpleFooter !== true):
            get_template_part('template-parts/footer');
        else: ?>
            <div class="footerSimple container centerAlign">
                <p>&copy; Copyright <?php echo date('Y'); ?> MaxLiving. All Rights Reserved.</p>
            </div>
        <?php endif; ?>

    </footer>
<?php endif; ?>

<!--Scripts-->
<?php
get_template_part('template-parts/scripts');
wp_footer();
?>

</body>
</html>
