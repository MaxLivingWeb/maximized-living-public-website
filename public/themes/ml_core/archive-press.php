<?php
/* Template Name: Archive - Press Releases */
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */
get_header();

global $taxonomy;
global $category_name;
$taxonomy = 'press_categories';
$postType = 'press';
$categorySortScripts = true;
?>
    <div class="hero hero-archive wave wave-multi"
         style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/hero-new-patient.jpg');" id="content">
        <div class="heroContent centerAlign container container-xs">
            <p class="heroLeading">About us</p>
            <h1 class="heroHeadline">Press &amp; Media</h1>
            <span class="icon-lineWave"></span>
        </div>
    </div>

    <section class="articleListContainer wave wave-faintGrey">
        <div class="container">
            <div class="articleListIntro">
                <h2>Latest Press &amp; Media</h2>
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
                    'posts_per_page' => 6,
                    'post_type' => 'press',
                    'paged' => $paged
                );
                if (isset($_GET['category'])) {
                    $args = array(
                        'posts_per_page' => 5,
                        'post_type' => $postType,
                        'paged' => $paged,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field' => 'name',
                                'terms' => str_replace('-',' ',$_GET['category'])
                            )
                        )
                    );
                }
//                $cache = 'press-archive-'.get_current_blog_id();//cache name
//                $custom_query = get_site_transient($cache);//get cache?
//                if ($custom_query === false) {//no cache
//                    $custom_query = new WP_Query($args);//run query
//                    set_site_transient( $cache, $custom_query, HOUR_IN_SECONDS );//set query cache for 1 hour
//                }
//                else {//there is cache!
//                    $custom_query = get_site_transient($cache);//get cache
//                }

                $custom_query = new WP_Query($args);//run query


                $featureTop = true;
                while ($custom_query->have_posts()) :
                $custom_query->the_post();
                ?>
            <?php if ($featureTop == true) :
            $featureTop = false
            ?>
                <article class="archiveListItem single">
                    <div class="articleImage">
                        <div class="image bg-image" style=" background-image: url('<?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail_url('archive-image-top');
                        } else {
                            echo get_template_directory_uri() . '/images/placeholder.jpeg';
                        }
                        ?>')"></div>
                        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                            <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                        </a>
                    </div>
                    <div class="articlePreviewContent">
                        <div class="articlePublished date">
                            <p class="icon-calendar iconDetail">
                                <time datetime="<?php echo date('Y-m-d', strtotime(get_the_date())); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </p>
                        </div>
                        <h3 class="articleTitle">
                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <div class="articleExcerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a class="articleLink link-leftDash" title="<?php the_title(); ?>"
                           href="<?php the_permalink(); ?>">Read More</a>
                    </div>
                </article>
                <div class="cardContainer"><?php // starting cardContainer for cards
                    ?>
                    <?php else : ?>
                        <article class="archiveListItem card card-underlineHover-brandGrey card-shadowHover">
                            <?php if ((get_the_post_thumbnail_url())) : ?>
                                <div class="articleImage">
                                    <div class="image bg-image"
                                         style="background-image: url('<?php the_post_thumbnail_url('archive-image-small'); ?>')"></div>
                                    <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                        <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                                    </a>
                                </div>
                            <?php endif ?>
                            <div class="articlePreviewContent">
                                <div class="articlePublished date">
                                    <p class="icon-calendar iconDetail">
                                        <time datetime="<?php echo date('Y-m-d', strtotime(get_the_date())); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </p>
                                </div>
                                <h3 class="articleTitle">
                                    <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="articleExcerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                            <a class="articleLink link-leftDash" title="<?php the_title(); ?>"
                               href="<?php the_permalink(); ?>">Read More</a>
                        </article>
                    <?php endif; ?>
                    <?php endwhile; ?>
                </div> <?php // closing cardContainer ?>
                <?php if (function_exists("pagination")) {
                    pagination($custom_query);
                } ?>

            </div> <?php // closing articleList ?>
        </div>
    </section> <?php // closing articleListContainer ?>
    <div class="callout callout-archive centerAlign bg-faintGrey">
        <div class="container">
            <div class="noDivider">
                <p class="borderText border-brandGrey">Media Inquiries</p>
            </div>
            <span class="icon iconTwoTone twoTone-megaphone"></span>
            <h2>MaxLiving Media Inquiries</h2>
            <div class="content">
                <p>
                    Are you a member of the media looking for more information on MaxLiving? Our Corporate
                    Communications team is here to help. Contact us today and a member of our team will contact you <br>as
                    soon as possible.
                </p>
            </div>
            <div class="link">
                <a class="button button-tertiary button-large" href="<?php echo home_url() . '/contact'; ?>">Contact
                    Us</a>
            </div>
        </div>
    </div>

<?php
get_footer();
