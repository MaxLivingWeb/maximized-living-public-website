<?php
/* Template Name: Archive - Events */
/**
 * The template for displaying event archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();
global $taxonomy;
global $category_name;
$taxonomy = 'event_categories';
$postType = 'event';
$categorySortScripts = true;
?>


    <div class="hero hero-archive wave wave-multi" style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/hero-events.jpg');'" id="content">
        <div class="heroContent centerAlign container">
            <h1 class="heroHeadline">Our Events</h1>
            <p class="heroDescription">
                Our professional seminars and training sessions for chiropractic doctors and students support continued elevation of the profession. Our community and patient workshops teach you how to balance your health naturally.
            </p>
            <span class="icon-lineWave"></span>
        </div>
    </div>

    <section class="articleListContainer container">
        <div class="articleListIntro">
            <h2>Upcoming Events</h2>
            <div class="categoryFilter inputField">
                <form>
                    <label class="invisible" for="categoryFilter">Filter by Category</label>
                    <?php
                    switch_to_blog(1);
                    if( $terms = get_terms( $taxonomy ) ) :
                        echo '<select id="categoryFilter" class="categoryDropdown" name="categoryFilter"><option>Filter by Category</option>';
                        foreach ( $terms as $term ) :
                            $option =  strtolower(str_replace(' ','-',$term->name));
                            $selected='';
                            if(isset($_GET['category'])) {
                                if ( $option === $_GET['category'] ) {
                                    $selected = ' selected';
                                }
                            }
                            echo '<option value="' . $option . '"'.$selected.'>' . $term->name . '</option>';
                        endforeach;
                        echo '</select>';
                    endif;
                    restore_current_blog();
                    ?>
                </form>
            </div>
        </div>
        <div class="articleList">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                'posts_per_page' => 5,
                'post_type' => 'event',
                'paged' => $paged,
                'post__not_in'   => array(get_queried_object_id() ),
                'order'				=> 'ASC',
                'orderby'			=> 'meta_value',
                'meta_key'			=> 'event_start_date',
                'meta_value'             => date('Y-m-d', strtotime(' -1 day')),
                'meta_compare'           => '>=',
                'meta_type'			=> 'DATETIME'
            );

            if(isset($_GET['category'])) {
                    $args = array(
                        'posts_per_page' => 5,
                        'post_type'      => $postType,
                        'paged'          => $paged,
                        'post__not_in'   => array( get_queried_object_id() ),
                        'order'          => 'ASC',
                        'orderby'        => 'meta_value',
                        'meta_key'       => 'event_start_date',
                        'meta_value'     => date( 'Y-m-d H:i:s' ),
                        'meta_compare'   => '>=',
                        'meta_type'      => 'DATETIME',
                        'tax_query'      => array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field'    => 'name',
                                'terms'    => str_replace( '-', ' ', $_GET['category'] )
                            )
                        )
                    );
            }

//            $cache = 'event-archive-'.get_current_blog_id();//cache name
//            $custom_query = get_site_transient($cache);//get cache?
//            if ($custom_query === false) {//no cache
//                $custom_query = new WP_Query($args);//run query
//                set_site_transient( $cache, $custom_query, HOUR_IN_SECONDS );//set query cache for 1 hour
//            }
//            else {//there is cache!
//                $custom_query = get_site_transient($cache);//get cache
//            }

            $custom_query = new WP_Query($args);//run query


            while ($custom_query->have_posts()) :
                $custom_query->the_post();
                $category_name="";
                get_template_part('template-parts/category');

                ?>
                <article class="archiveListItem">
                    <div class="articleImage">
                        <div class="image bg-image">

                              <?php if( get_field('upcoming_events_page_image') ): ?>

                              	<img src="<?php the_field('upcoming_events_page_image'); ?>" />

                              <?php endif; ?>


                        </div>
                        <a title="<?php the_title(); ?>"  href="<?php the_permalink(); ?>">
                            <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                        </a>
                    </div>
                    <div class="articlePreviewContent">
                        <?php if ( !empty($category_name) ): ?>
                            <span class="articleCategory borderText border-brandGreen"><?php echo $category_name; ?></span>
                        <?php endif; ?>
                        <h3 class="articleTitle">
                            <a title="<?php the_title(); ?>"  href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <div class="articlePublished">
                            <?php
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
                            <?php endif; ?>
                            <?php if (get_field('event_address_city') && get_field('event_address_state')) : ?>
                                <p class="iconDetail icon-outlinedPin"><?php the_field('event_address_city'); ?>, <?php the_field('event_address_state'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="articleExcerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a class="articleLink link-leftDash" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">Event Details</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php if (function_exists("pagination")) {
            pagination($custom_query);
        } ?>
    </section>

<?php
get_footer();
