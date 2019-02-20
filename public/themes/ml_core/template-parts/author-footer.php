<?php
$authorImage = get_template_directory_uri().'/images/placeholder.jpeg';
$authorSiteID = get_post_meta($post->ID, 'siteOriginID')[0];
$authorURL = get_home_url($authorSiteID);

$author = '';
if (get_the_author_meta('first_name') || get_the_author_meta('last_name')) {
    $author = get_the_author_meta('first_name')." ".get_the_author_meta('last_name');
}

switch_to_blog($authorSiteID);
$authorLocationName = get_bloginfo( 'name' );
restore_current_blog();
?>

<footer class="author">
    <div class="authorImage" style="background-image:url('<?php echo $authorImage; ?>')"></div>
    <p class="authorTitle"><?php echo $author; ?></p>
    <a href="<?php echo $authorURL; ?>" class="authorSubtitle"><?php echo $authorLocationName; ?></a>
</footer>
