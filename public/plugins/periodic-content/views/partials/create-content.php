<?php
if (get_option('stylesheet') !== 'ml_whitelabel') :
?>
<div class="wrap">
    <h1>Create New Content</h1>
    <hr>
    <p>Recipes and Articles are submitted to MaxLiving Corporate for review and can be distributed to your website,
        other MaxLiving Clinic websites in your region or network wide across all MaxLiving clinic websites.</p>
    <p>The Event content type is displayed on your website only.</p>
    <p>
        <a class="button-primary" href="<?php echo admin_url('post-new.php?post_type=recipe'); ?>">New Recipe</a>
        <a class="button-primary" href="<?php echo admin_url('post-new.php?post_type=article'); ?>">New Article</a>
        <a class="button-primary" href="<?php echo admin_url('post-new.php?post_type=event'); ?>">New Event</a>
    </p>
</div>
    <?php
    else :
        ?>
        <div class="wrap">
            <h1>Create New Content</h1>
            <hr>
            <p>Recipes and Articles are submitted to MaxLiving Corporate for review, once approved the content will display on your website.</p>
            <p>
                <a class="button-primary" href="<?php echo admin_url('post-new.php?post_type=recipe'); ?>">New Recipe</a>
                <a class="button-primary" href="<?php echo admin_url('post-new.php?post_type=article'); ?>">New Article</a>
            </p>
        </div>
<?php endif; ?>
