<?php
$url = get_sub_field('video_url');
parse_str( parse_url( $url, PHP_URL_QUERY ), $video_id );
global $youtubeScripts;
$youtubeScripts = true;
?>

<section class="flexible-featuredVideoBlock flexibleContentItem">
    <?php if( get_sub_field('full_width_title') || get_sub_field('full_width_text')) : ?>
        <div class="flexible-fullWidth container centerAlign">
            <h2 class="title"><?php the_sub_field('full_width_title'); ?></h2>
            <div class="description"><?php the_sub_field('full_width_text'); ?></div>
        </div>
    <?php endif; ?>

    <div class="bubbleCardContainer">
        <div class="left bubbleBgContainer">
            <img alt="Decorative bubble portraits" src="<?php echo get_template_directory_uri(); ?>/images/BubbleBg-Left.png"/>
        </div>

        <?php if(get_sub_field('video_url')) :
            $id =  $video_id['v'];
            $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
            parse_str($content, $ytarr);
            ?>
            <div class="container">
                <div class="videoContainer card card-noBorder ">
                    <div class="videoPlayer" data-id="<?php echo $id; ?>" data-name="<?php echo htmlspecialchars($ytarr['title']);?>"></div>
                </div>
            </div>

        <?php endif; ?>
        <div class="right bubbleBgContainer">
            <img alt="Decorative bubble portraits" src="<?php echo get_template_directory_uri(); ?>/images/BubbleBg-Right.png"/>
        </div>
    </div>
</section>
