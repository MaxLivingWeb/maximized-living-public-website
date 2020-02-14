<?php
/*
Template Name: Event - Conference
Template Post Type: event
*/

/**
 * Template for Event Details
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
global $blankHeader;
$blankHeader = true;

global $youtubeScripts;
$youtubeScripts = true;

global $mapScripts;
$mapScripts = true;

get_header();
?>

    <article>
        <a id="eventRegisterCTA" href="#eventRegister" class="smoothScroll button button-primary">Register
            <span>Now</span></a>
        <?php
        $backgroundImage = get_template_directory_uri() . '/images/placeholder.jpg';
        if ( has_post_thumbnail( $post->ID ) ) {
            $id              = get_post_thumbnail_id( $post->ID );
            $image           = wp_get_attachment_image_src( $id, 'featured-image' );
            $backgroundImage = $image[0];
        }
        ?>
        <header class="hero eventConferenceHero wave wave-multi"
                style="background-image:url('<?php echo $backgroundImage; ?>');" id="content">
            <span class="heroBackgroundOverlay"></span>
            <div class="heroEventDetails">
                <?php
                if ( get_field( 'event_start_date' ) ) :
                    $start = strtotime( get_field( 'event_start_date' ) );
                    //if only a start date
                    $startDate = date( 'F j, Y', $start );
                    $endDate   = '';

                    if ( get_field( 'event_end_date' ) ) :
                        $end = strtotime( get_field( 'event_end_date' ) );
                        //if also an end date
                        $startDate = date( 'F j', $start );
                        $endDate   = date( 'j, Y', $end );

                        if ( date( 'F', $start ) !== date( 'F', $end ) ) :
                            //if end date is in a different month
                            $startDate = date( 'F j', $start );
                            $endDate   = date( 'F j, Y', $end );
                        endif;
                        if ( date( 'Y', $start ) !== date( 'Y', $end ) ) :
                            //if end date is in a different year
                            $startDate = date( 'F j, Y', $start );
                            $endDate   = date( 'F j, Y', $end );
                        endif;
                    endif;
                    $time      = "";
                    $startTime = "";
                    $endTime   = "";
                    if ( get_field( 'start_time' ) && get_field( 'end_time' ) ) :
                        $startTime = date( 'g:iA', strtotime( get_field( 'start_time' ) ) );
                        $endTime   = date( 'g:iA', strtotime( get_field( 'end_time' ) ) );
                        $time      = " (" . $startTime . "-" . $endTime . ")";
                    endif; ?>
                    <p class="heroEventDate">
                        <time datetime="<?php echo date( 'Y-m-d H:i', strtotime( date( 'F j, Y', $start ) . $startTime ) ); ?>"><?php echo $startDate; ?> </time>
                        <?php if ( ! empty( $end ) ) : ?>
                            <time datetime="<?php echo date( 'Y-m-d H:i', strtotime( date( 'F j, Y', $end ) . $endTime ) ); ?>">
                                - <?php echo $endDate; ?></time>
                        <?php endif ?>
                        <?php echo $time; ?>
                    </p>
                <?php endif;
                ?>
                <p class="heroEventLocation">
                    <?php the_field( 'event_venue_name' ); ?> in <?php the_field( 'event_address_city' ); ?>
                </p>
            </div>
            <div class="heroContent centerAlign container">
                <div class="heroEventDescription">
                    <?php
                    if ( get_field( 'header_icon' ) ) :
                        ?>
                        <span class="eventConferenceIcon bg-image"
                              style="background-image: url('<?php echo get_field( 'header_icon' )['url']; ?>')"></span>
                    <?php endif; ?>

                    <?php if ( ! empty( get_the_title() ) ) : ?>
                        <p class="heroLeading">Join us at</p>
                        <h1 class="heroHeadline">
                            <?php the_title(); ?></h1>
                    <?php endif; ?>
                    <div class="heroDescription container container-xs">
                        <?php the_field( 'header_description' ); ?>
                    </div>

                    <div class="heroEventCTA">
                        <?php if ( have_rows( 'header_buttons' ) ):
                            $count = 1;
                            while ( have_rows( 'header_buttons' ) ) :
                                the_row();
                                if ( $count % 2 ) {
                                    $buttonColor = '';
                                } else {
                                    $buttonColor = 'button-primary';
                                }
                                $count ++;
                                ?>
                                <a class="button <?php echo $buttonColor ?>"
                                   href="<?php the_sub_field( 'button_link' ); ?>"
                                   title="<?php the_sub_field( 'button_text' ); ?>" <?php if(get_sub_field('open_link_in_new_tab')) {echo 'target="_blank"';} ?>><?php the_sub_field( 'button_text' ); ?></a>
                            <?php endwhile;
                        endif; ?>
                    </div>
                </div>
            </div>
        </header>
        <?php
        if ( get_field( 'event_promotion_ribbon' ) ):
            ?>
            <div class="eventPromoRibbon container">

                <?php
                if ( have_rows( 'image_video' ) ):
                    while ( have_rows( 'image_video' ) ) : the_row();
                        if ( get_sub_field( 'video_iv' ) )://video
                            $url = get_sub_field( 'video_iv' );
                            parse_str( parse_url( $url, PHP_URL_QUERY ), $video_id );
                            $id      = $video_id['v'];
                            $content = file_get_contents( "http://youtube.com/get_video_info?video_id=" . $id );
                            parse_str( $content, $ytarr );
                            ?>

                            <div class="ribbonImageContainer">
                                <div class="videoContainer">
                                    <div class="videoPlayer" data-id="<?php echo $id; ?>"
                                         data-name="<?php echo htmlspecialchars( $ytarr['title'] ); ?>"></div>
                                </div>
                            </div>

                        <?php else: //image ?>

                            <div class="ribbonImageContainer">
                                <div class="ribbonImage"
                                     style="background-image:url('<?php echo get_sub_field( 'image' )['url']; ?>');">
                                    <img class="image"
                                         src="<?php echo get_sub_field( 'image_iv' )['url']; ?>"
                                         alt="<?php echo get_sub_field( 'image_iv' )['alt']; ?>"/>
                                </div>
                            </div>

                        <?php
                        endif;
                    endwhile;
                endif;
                ?>
            </div>
            <section class="eventPromoDescription">
                <div class="flexible-leftRightContent">
                    <div class="container">
                        <div class="leftRightRow">
                            <h2 class="title"><?php the_field( 'section_title' ); ?></h2>
                            <?php if ( get_field( 'body_content_left' ) || get_field( 'body_content_right' ) ): ?>
                                <div class="contentContainer">
                                    <div class="content content-left">
                                        <?php the_field( 'body_content_left' ); ?>
                                    </div>
                                    <div class="content content-right">
                                        <?php the_field( 'body_content_right' ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="flexible-contentWithImage">
                    <div class="container">
                        <div class="contentRow">
                            <div class="contentContainer">
                                <h3 class="title"><?php the_field( 'title' ); ?></h3>
                                <div class="content">
                                    <?php the_field( 'content' ); ?>
                                </div>
                                <?php if(get_field( 'button_link' )){ ?>
                                <a class="button button-primary"
                                   href="<?php the_field( 'button_link' ); ?>"
                                   target="_blank"
                                   title="<?php the_field( 'button_text' ); ?>"><?php the_field( 'button_text' ); ?></a>

                                <?php } if(get_field( 'button_text' ) && !get_field( 'button_link' )) { ?>
                                    <div class="button button-primary"><?php the_field( 'button_text' ); ?></div>
                                <?php } ?>


                            </div>
                            <div class="imageContainer">
                                <div class="imageContent bg-image"
                                     style="background-image: url('<?php echo get_field( 'image' )['url']; ?>');">
                                    <img class="image"
                                         src="<?php echo get_field( 'image' )['url']; ?>"
                                         alt="<?php echo get_field( 'image' )['alt']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif;
        if ( get_field( 'show_section_speakers' ) ): ?>
            <section class="eventKeynoteSpeakers bg-darkGrey bg-pattern bg-pattern-circle" id="speakers">
                <div class="eventKeynoteSpeakersIntro container container-sm">
                    <h2 class="title"><?php the_field( 'title_speakers' ); ?></h2>
                    <div class="description">
                        <?php the_field( 'description_speakers' ); ?>
                    </div>
                </div>
                <?php
                if ( have_rows( 'speakers' ) ):
                    $speakerCount = count( get_field( 'speakers' ) );

                    ?>
                    <div class="eventKeynoteSpeakersContainer container<?php if ( $speakerCount === 4 ) {
                        echo ' fourSpeakers';
                    } ?>">
                        <?php
                        while ( have_rows( 'speakers' ) ) : the_row();
                            ?>
                            <div class="eventKeynoteSpeaker">
                                <div class="eventKeynoteSpeakerImage bg-image"
                                     style="background-image: url('<?php echo get_sub_field( 'image' )['url']; ?>');">
                                    <img class="image"
                                         src="<?php echo get_sub_field( 'image' )['url']; ?>"
                                         alt="<?php echo get_sub_field( 'image' )['alt']; ?>">
                                </div>
                                <h3 class="name"><?php if ( get_sub_field( 'speaker_link' ) ): ?><a
                                            href="<?php the_sub_field( 'speaker_link' ); ?>" target="_blank" style="text-decoration: underline;"><?php endif;
                                        the_sub_field( 'name' );
                                        if ( get_sub_field( 'speaker_link' ) ): ?></a><?php endif; ?></h3>

                                <p class="description"><?php the_sub_field( 'speaker_description' ); ?></p>
                            </div>
                        <?php
                        endwhile; ?>
                    </div>
                <?php
                endif;
                ?>
                <?php if ( get_field( 'speakers_button_text' )): ?>
                    <div class="eventKeynoteSpeakersCTA container">
                        <?php if ( get_field( 'speakers_button_link' )) { ?>
                        <a class="button button-primary" href="<?php the_field( 'speakers_button_link' );  ?>" target="_blank"
                           title="<?php the_field( 'speakers_button_text' ); ?>"><?php the_field( 'speakers_button_text' ); ?></a>
                        <?php } if(get_field( 'speakers_button_text' ) && !get_field( 'speakers_button_link' )) { ?>
                        <div class="button button-primary"><?php the_field( 'speakers_button_text' ); ?></div>
                        <?php } ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
        <section class="eventConferenceFeatured flexible-contentWithImage">
            <div class="container">

                <?php
                if ( have_rows( 'content_with_image' ) ):
                    while ( have_rows( 'content_with_image' ) ) : the_row(); ?>

                        <div class="contentRow">
                            <div class="contentContainer">
                                <span class="category borderText border-brandTeal"><?php the_sub_field( 'category' ); ?></span>
                                <h2 class="title"><?php the_sub_field( 'content_title' ); ?></h2>
                                <div class="content">
                                    <?php the_sub_field( 'content' ); ?>
                                </div>
                                <?php if(get_sub_field('show_cta')):?>
                                <a class="button button-primary" href="<?php the_sub_field( 'cta_link' ); ?>"
                                   title="<?php the_sub_field( 'cta_title' ); ?>"><?php the_sub_field( 'cta_title' ); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="imageContainer">
                                <div class="imageContent bg-image"
                                     style="background-image: url('<?php echo get_sub_field( 'image' )['url']; ?>');">
                                    <img class="image"
                                         src="<?php echo get_sub_field( 'image' )['url']; ?>"
                                         alt="<?php echo get_sub_field( 'image' )['alt']; ?>">
                                </div>
                            </div>
                            <?php if(get_sub_field('show_cta')):?>
                            <div class="mobileCTA">
                                <a class="button button-primary"
                                   href="<?php the_sub_field( 'cta_link' ); ?>"
                                   title="<?php the_sub_field( 'cta_title' ); ?>"
                                   aria-hidden="true"
                                   target="_blank"
                                ><?php the_sub_field( 'cta_title' ); ?></a>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php
                    endwhile;
                endif;
                $map = get_field( 'map_section' );
                if ( $map['show_section'] ): ?>
                    <div class="contentRow" id="eventConferenceMap">
                        <div class="contentContainer">
                            <h2 class="title"><?php echo $map['title']; ?></h2>
                            <div class="content">
                                <?php echo $map['description']; ?>
                            </div>
                            <a class="button button-primary"
                               href="<?php echo $map['cta_link']; ?>"
                               target="_blank"
                               title="<?php echo $map['cta_title']; ?>"><?php echo $map['cta_title']; ?></a>
                        </div>
                        <div class="imageContainer mapContainer">
                            <script>
                                var mapCenterLat = <?php echo $map['venue_latitude']; ?>;
                                var mapCenterLng = <?php echo $map['venue_longitude']; ?>;
                            </script>
                            <div class="imageContent" id="map"></div>
                        </div>
                        <div class="mobileCTA">
                            <a class="button button-primary"
                               href="<?php echo $map['cta_link']; ?>"
                               title="<?php echo $map['cta_title']; ?>"
                               aria-hidden="true"
                               target="_blank"
                            ><?php echo $map['cta_title']; ?></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </article>
<?php
if ( get_field( 'eventbrite_id' ) ):
    ?>
    <section class="eventConferenceRegistration bg-faintGrey">
        <div class="container">
            <div id="eventRegister" class="eventConferenceRegistrationHeader">
                <h2 class="registrationTitle">Event Registration</h2>
            </div>
                <div id="eventbrite-widget-container-<?php the_field( 'eventbrite_id' ); ?>"></div>
            <div id="IframeDivId"></div>
              <script>
                (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)){ return; }
                js = d.createElement(s); js.id = id;
                js.onload = function(){
                  showForm("IframeDivId", "<?php the_field( "eventbrite_id" ); ?>");
                };
                js.src = "https://go.regform.com/_assets/scripts/expo.js";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'expo_js'));
              </script>
        </div>
    </section>
<?php endif; ?>
    <script type='application/ld+json'>
    {
      "@context": "http://www.schema.org",
      "@type": "Event",
      "name": "<?php if ( ! empty( get_the_title() ) ) {
            the_title();
        } else {
            echo "MaxLiving Event";
        } ?>",
      "url": "<?php if ( ! empty( get_the_permalink() ) ) {
            echo get_the_permalink();
        } else {
            echo get_site_url();
        } ?>",
      "description": "<?php if ( ! empty( get_the_excerpt() ) ) {
            the_excerpt();
        } ?>",
      "image": "<?php echo $backgroundImage; ?>",
      "startDate": "<?php if ( get_field( 'event_start_date' ) ) {
            the_field( 'event_start_date' );
        } ?>",
      "endDate": "<?php if ( get_field( 'event_end_date' ) ) {
            the_field( 'event_end_date' );
        } ?>",
      "location": {
        "@type": "Place",
        "name": "<?php if ( ! empty( get_field( 'event_venue_name' ) ) ) {
            the_field( 'event_venue_name' );
        } ?>",
        "sameAs": "<?php if ( ! empty( get_site_url() ) ) {
            echo get_site_url();
        } ?>",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "<?php if ( ! empty( get_field( 'event_address_street' ) ) ) {
            the_field( 'event_address_street' );
        } ?>",
          "addressLocality": "<?php if ( ! empty( get_field( 'event_address_city' ) ) ) {
            the_field( 'event_address_city' );
        } ?>",
          "addressRegion": "<?php if ( ! empty( get_field( 'event_address_state' ) ) ) {
            the_field( 'event_address_state' );
        } ?>",
          "postalCode": "<?php if ( ! empty( get_field( 'event_address_postal_code' ) ) ) {
            the_field( 'event_address_postal_code' );
        } ?>",
          "addressCountry": "<?php if ( ! empty( get_field( 'event_address_country' ) ) ) {
            the_field( 'event_address_country' );
        } ?>"
        }
      },
      "offers": {
        "@type": "Offer",
        "description": "<?php if ( ! empty( get_the_excerpt() ) ) {
            echo get_the_excerpt();
        } ?>",
        "url": "<?php if ( ! empty( get_field( 'register_now_button_link' ) ) ) {
            the_field( 'register_now_button_link' );
        } ?>",
        "price": "<?php if ( ! empty( get_field( 'register_event_price' ) ) ) {
            echo "$" . the_field( 'register_event_price' );
        } ?>"
      }
    }

    </script>

<?php
get_footer();
