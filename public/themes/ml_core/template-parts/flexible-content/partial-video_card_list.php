<?php
global $youtubeScripts;
$youtubeScripts = true;
?>
<section class="flexible-videoCardList flexibleContentItem container">
    <h2 class="title centerAlign"><?php the_sub_field('title'); ?></h2>
    <div class="videoList cardContainer cardContainer-leftAlign">
        <?php if( have_rows('videos') ):

            while ( have_rows('videos') ) : the_row();
                $url = get_sub_field('video_url');
                parse_str( parse_url( $url, PHP_URL_QUERY ), $video_id );
                $id =  $video_id['v'];
                $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id);
                parse_str($content, $ytarr);
                ?>
                <div class="videoContainer card card-third card-shadowHover card-underlineHover-brandGrey">
                  <div class="embed-container">
                    <?php if(get_sub_field('video_url')) :?>
                        <?php the_sub_field('video_url'); ?>
                      <?php endif; ?>
                  </div>
                  <style>
    .embed-container {
        position: relative;
        padding-bottom: 56.25%;
        overflow: hidden;
        max-width: 100%;
        height: auto;
    }

    .embed-container iframe,
    .embed-container object,
    .embed-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
                    <div class="videoContent">
                        <?php if(get_sub_field('video_title')) :?>
                            <h3><?php the_sub_field('video_title'); ?></h3>
                        <?php endif; ?>
                        <?php if(get_sub_field('video_description')) :?>
                            <p><?php the_sub_field('video_description'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile;
        endif; ?>
    </div>
</section>
