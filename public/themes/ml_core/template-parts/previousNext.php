<?php
    if(empty($previousNextName)){
        $previousNextName = 'Article';
    }
    if ($previousNextName==='Article') {
        $link = $childsite_base_url.'/healthy-articles/';
    }
    else if ($previousNextName==='Recipe') {
        $link = $childsite_base_url.'/healthy-recipes/';
    }
?>
<div class="previousNext">
    <?php
    $prev_post = get_previous_post();
    if($prev_post) : ?>
        <?php $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title)); ?>
        <a class="previous link-leftDash" href="<?php echo $link.$prev_post->post_name; ?>" title="<?php echo $prev_title; ?>">Previous <span class="extra"><?php echo $previousNextName; ?></span></a>
    <?php endif; ?>
    <?php
    $next_post = get_next_post();
    if($next_post) : ?>
        <?php $next_title = strip_tags(str_replace('"', '', $next_post->post_title)); ?>
        <a class="next link-rightDash" href="<?php echo $link.$prev_post->post_name; ?>" title="<?php echo $next_title; ?>">Next <span class="extra"><?php echo $previousNextName; ?></span></a>
    <?php endif; ?>
</div>
