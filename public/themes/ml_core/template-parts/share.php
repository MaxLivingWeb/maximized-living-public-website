<?php
$shareURL = get_permalink();
$shareTitle = get_the_title();
$shareExcerpt = get_the_excerpt();
?>
<a  href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareURL; ?>"
    data-share-link
    target="_blank"
    title="Share on Facebook">
    <span class="socialIcon icon-facebook"></span>
</a>
<a  href="https://twitter.com/intent/tweet/?text=<?php echo rawurlencode($shareTitle); ?>&url=<?php echo $shareURL; ?>&via=MaxLiving&hashtags=MaxLiving"
    data-share-link
    target="_blank"
    title="Share on Twitter">
    <span class="socialIcon icon-twitter"></span>
</a>
<a  href="https://plus.google.com/share?url=<?php echo $shareURL; ?>"
    data-share-link
    target="_blank"
    title="Share on Google+">
    <span class="socialIcon icon-googleplus"></span>
</a>
<a  href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $shareURL; ?>&title=<?php echo rawurlencode($shareTitle); ?>&source=<?php echo get_home_url(); ?>&summary=<?php echo rawurlencode($shareExcerpt); ?>"
    data-share-link
    target="_blank"
    title="Share on LinkedIn">
    <span class="socialIcon icon-linkedin"></span>
</a>
