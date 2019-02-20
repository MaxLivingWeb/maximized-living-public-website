<?php
/**
* Template for Event Details
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package MaxLiving
*/

get_header();

global $taxonomy;
global $category_name;
$taxonomy = 'event_categories';
get_template_part('template-parts/category');

?>

<article>
<article class="container">
    <header class="singlePostIntro centerAlign">
        <?php if ( !empty($category_name) ) : ?>
            <div class="borderText border-brandGreen"><?php echo $category_name; ?></div>
        <?php endif;
        if (!empty(get_the_title())) : ?>
            <h1><?php the_title(); ?></h1>
        <?php endif;
        if (get_field('event_start_date')) :
            $start = strtotime(get_field('event_start_date'));
            //if only a start date
            $startDate = date('F jS, Y', $start);
            $endDate = '';

            if (get_field('event_end_date')) :
                $end = strtotime(get_field('event_end_date'));
                //if also an end date
                $startDate = date('F jS', $start);
                $endDate = date('jS, Y', $end);

                if (date('F', $start) !== date('F', $end)) :
                    //if end date is in a different month
                    $startDate = date('F jS', $start);
                    $endDate = date('F jS, Y', $end);
                endif;
                if (date('Y', $start) !== date('Y', $end)) :
                    //if end date is in a different year
                    $startDate = date('F jS, Y', $start);
                    $endDate = date('F jS, Y', $end);
                endif;
            endif;
            $time = "";
            $startTime = "";
            $endTime = "";
            if(get_field('start_time') && get_field('end_time')) :
                $startTime = date('g:iA', strtotime(get_field('start_time')));
                $endTime = date('g:iA', strtotime(get_field('end_time')));
                $time = " (" . $startTime . " - " . $endTime . ")";
            endif; ?>
            <p class="date icon-calendar iconDetail">
                <time datetime="<?php echo date('Y-m-d H:i', strtotime(date('F j, Y', $start) . $startTime)); ?>"><?php echo $startDate; ?> </time>
                <?php if(!empty($end)) : ?>
                    <time datetime="<?php echo date('Y-m-d H:i', strtotime(date('F j, Y', $end) . $endTime)); ?>"> - <?php echo $endDate; ?></time>
                <?php endif ?>
                <?php echo $time; ?>
            </p>
        <?php endif;
        if (get_field('event_address_city') || get_field_object('event_address_state')) : ?>
            <p class="date icon-outlinedPin iconDetail">
                <?php the_field('event_address_city');?>, <?php the_field('event_address_state');?> <?php the_field('event_address_country'); ?> <?php the_field('event_address_postal_code'); ?>
            </p>
        <?php endif;
            if (get_field('register_now_button_link')) : ?>
            <div class="eventHeroButton">
                <div class="link">
                    <a class="button button-tertiary button-large" href="<?php the_field('register_now_button_link'); ?>" target="_blank">Register Now!</a>
                </div>
            </div>
            <?php endif; ?>
    </header>

    <?php
    if (has_post_thumbnail($post->ID)) :
        $id = get_post_thumbnail_id($post->ID);
        $image = wp_get_attachment_image_src($id, 'featured-image');
        $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
        ?>
        <div class="fullImage bg-image" style="background-image: url('<?php echo $image[0]; ?>')">
            <img class="image" src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>">
        </div>
    <?php endif; ?>
    <div class="singlePostContainer">
        <aside class="socialSidebar socialSticky">
            <?php get_template_part('template-parts/share'); ?>
        </aside>
        <div class="singlePostContent">
            <?php
                if(!empty(get_the_content())): ?>
                    <div class="overview singlePostContentGroup">
                        <h2>The Event</h2>
                        <div class="content" id="content">
                            <?php
                            $content = get_the_content();
                            $content = apply_filters( 'the_content', $content );
                            $content = str_replace( ']]>', ']]&gt;', $content );
                            $content = str_replace("<blockquote>", "<blockquote class=\"quote\">", $content);
                            echo $content;
                            ?>
                        </div>
                    </div>
                <?php endif;
            if (get_field('event_details_description')) : ?>
                <div class="overview singlePostContentGroup">
                    <h2>Event Details</h2>
                    <div class="content">
                        <?php the_field('event_details_description') ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (get_field('event_start_date') || get_field('event_venue_name') || get_field('event_address_street') || get_field('event_address_city')) : ?>
                <div class="articleTable singlePostContentGroup">
                    <div class="tableSection">
                        <h3 class="tableTitle">Date &amp; Time</h3>
                        <div class="tableContent tableContent-small">
                            <p>
                                <time datetime="<?php echo date('Y-m-d H:i', strtotime(date('F j, Y', $start) . $startTime)); ?>">
                                    <?php echo date('D, F j, Y', $start);  if ($startTime) : echo ", ".$startTime; endif; ?>
                                </time>
                                <?php if(!empty($end)) : ?>
                                    - <br>
                                    <time datetime="<?php echo date('Y-m-d H:i', strtotime(date('F j, Y', $end) . $endTime)); ?>">
                                        <?php echo date('D, F j, Y', $end);  if ($endTime) : echo ", ".$endTime; endif; ?>
                                    </time>
                                <?php endif ?>
                            </p>
                            <a href="#" target="_blank">Add to Calendar</a>
                        </div>
                    </div>
                    <div class="tableSection">
                        <h3 class="tableTitle">Location</h3>
                        <div class="tableContent tableContent-small">
                            <p><?php the_field('event_venue_name'); ?></p>
                            <p><?php the_field('event_address_street'); ?></p>
                            <p>
                                <?php the_field('event_address_city');?>, <?php the_field('event_address_state');?> <?php the_field('event_address_country'); ?>
                            </p>
                            <?php

                            $locationDirections = str_replace(' ', '+', get_field('event_address_street')).'+'.str_replace(' ', '+',get_field('event_address_city')).'+'.str_replace(' ', '+',get_field('event_address_state')).'+'.str_replace(' ', '+',get_field('event_address_country'));

                            ?>
                            <a href="https://www.google.com/maps?daddr=<?php echo $locationDirections; ?>" target="_blank">Get Directions</a>
                        </div>
                    </div>
                </div>

            <?php endif;
                if (get_field('register_for_event_description') || get_field('register_now_button_link')) : ?>
                <footer class="callout centerAlign">
                    <h2>Register for Event</h2>
                        <?php if (get_field('register_for_event_description')) : ?>
                    <div class="content">
                        <p><?php the_field('register_for_event_description'); ?></p>
                    </div>
                        <?php endif;
                        if (get_field('register_now_button_link')) : ?>
                        <div class="link">
                            <a class="button button-tertiary button-large" href="<?php the_field('register_now_button_link'); ?>" target="_blank">Register Now!</a>
                        </div>
                        <?php endif; ?>
                </footer>
                <?php endif; ?>
            </div>
        </div>
</article>

<div class="singlePostPreviousNext container">
    <?php
        $previousNextName = 'Event';
        include(locate_template('template-parts/previousNext.php'));
    ?>
</div>

<script type='application/ld+json'>
    {
      "@context": "http://www.schema.org",
      "@type": "Event",
      "name": "<?php if (!empty(get_the_title())) {
        the_title();
    } else {
        echo "MaxLiving Event";
    } ?>",
      "url": "<?php if (!empty(get_the_permalink())) {
        echo get_the_permalink();
    } else {
        echo get_site_url();
    } ?>",
      "description": "<?php if (!empty(get_the_excerpt())) {
        the_excerpt();
    } ?>",
      "image": "<?php echo $image[0]; ?>",
      "startDate": "<?php if (get_field('event_start_date')) {
        the_field('event_start_date');
    } ?>",
      "endDate": "<?php if (get_field('event_end_date')) {
        the_field('event_end_date');
    } ?>",
      "location": {
        "@type": "Place",
        "name": "<?php if (!empty(get_field('event_venue_name'))) {
        the_field('event_venue_name');
    } ?>",
        "sameAs": "<?php if (!empty(get_site_url())) {
        echo get_site_url();
    } ?>",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "<?php if (!empty(get_field('event_address_street'))) {
        the_field('event_address_street');
    } ?>",
          "addressLocality": "<?php if (!empty(get_field('event_address_city'))) {
        the_field('event_address_city');
    } ?>",
          "addressRegion": "<?php if (!empty(get_field('event_address_state'))) {
        the_field('event_address_state');
    } ?>",
          "postalCode": "<?php if (!empty(get_field('event_address_postal_code'))) {
        the_field('event_address_postal_code');
    } ?>",
          "addressCountry": "<?php if (!empty(get_field('event_address_country'))) {
        the_field('event_address_country');
    } ?>"
        }
      },
      "offers": {
        "@type": "Offer",
        "description": "<?php if (!empty(get_the_excerpt())) {
        echo get_the_excerpt();
    } ?>",
        "url": "<?php if (!empty(get_field('register_now_button_link'))) {
        the_field('register_now_button_link');
    } ?>",
        "price": "<?php if (!empty(get_field('register_event_price'))) {
        echo "$".the_field('register_event_price');
    } ?>"
      }
    }

</script>

    <?php

    $args = array(
        'posts_per_page' => 3,
        'post_type' => 'event',
        'post__not_in'   => array(get_queried_object_id() ),
        'order'				=> 'ASC',
        'orderby'			=> 'meta_value',
        'meta_key'			=> 'event_start_date',
        'meta_value'             => date('Y-m-d H:i:s'),
        'meta_compare'           => '>=',
        'meta_type'			=> 'DATETIME'
    );
    $custom_query = new WP_Query($args);

    if($custom_query->have_posts()):
    ?>


<aside class="singlePostRelated container">
    <h2 class="centerAlign">Upcoming Events</h2>
    <div class="articleList">
        <?php
        while ($custom_query->have_posts()) :
            $custom_query->the_post();
            get_template_part('template-parts/category');

            ?>

            <article class="archiveListItem card card-underlineHover-brandTeal card-shadowHover">
                    <div class="articleImage">
                        <div class="image bg-image">    <?php if( get_field('upcoming_events_page_image') ): ?>

                              <img src="<?php the_field('upcoming_events_page_image'); ?>" />

                            <?php endif; ?></div>
                        <a
                            <?php if(!empty(get_the_title())): ?>
                                title="<?php the_title(); ?>"
                            <?php endif; ?>
                            href="<?php the_permalink(); ?>"
                        >
                            <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                        </a>
                    </div>
                <div class="articlePreviewContent">
                    <?php if ( !empty($category_name) ): ?><div><span class="articleCategory borderText border-brandTeal"><?php echo $category_name; ?></span></div><?php endif; ?>
                   <?php if(!empty(get_the_title())): ?>
                    <h3 class="articleTitle">
                        <a title="<?php the_title(); ?>"  href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                   <?php endif; ?>
                </div>
                <a
                    class="articleLink link-leftDash"
                    <?php if(!empty(get_the_title())): ?>
                        title="<?php the_title(); ?>"
                    <?php endif; ?>
                    href="<?php the_permalink(); ?>"
                >Read More</a>
            </article>
        <?php endwhile; ?>
    </div>
</aside>

<?php
endif;
get_footer();
