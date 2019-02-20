<?php
/* Template Name: Archive - Recipes */
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
$taxonomy = 'recipe_categories';
$postType = 'recipe';
$categorySortScripts = true;
?>

    <div class="hero hero-archive wave wave-multi"
         style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/hero-healthy-recipes.jpg');" id="content">
        <div class="heroContent centerAlign container container-xs">
            <h1 class="heroHeadline">Healthy Recipes</h1>
            <p class="heroDescription">
                Diets that include whole foods will help you thrive — mentally and physically. That’s why we’ve put
                together recipes to help you stay on track with your health and enjoy your food at the same time.
            </p>
            <span class="icon-lineWave"></span>
        </div>
    </div>
    <section class="articleListContainer container">
        <div class="articleListIntro">
            <h2>Latest Recipes</h2>
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
                'posts_per_page' => 7,
                'post_type' => 'recipe',
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

//            $cache = 'recipe-archive-'.get_current_blog_id();//cache name
//            $custom_query = get_site_transient($cache);//get cache?
//            if ($custom_query === false) {//no cache
//                $custom_query = new WP_Query($args);//run query
//                set_site_transient( $cache, $custom_query, HOUR_IN_SECONDS);//set query cache for 1 hour
//            }
//            else {//there is cache!
//                $custom_query = get_site_transient($cache);//get cache
//            }

            $custom_query = new WP_Query($args);//run query


            $featureTop = true;
            while ($custom_query->have_posts()) :
            $custom_query->the_post();
            restore_current_blog();
            $childsite_url = home_url();
            switch_to_blog(1);

            $post_link = $childsite_url . '/healthy-recipes/' . get_post()->post_name;
            $category_name = "";
            global $post;
                get_template_part('template-parts/category');
            if ($featureTop == true) :
            $featureTop = false
            ?>
            <article class="archiveListItem single">
                <div class="articleImage">
                    <div class="image bg-image" style="background-image: url('<?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail_url( 'archive-image-top' );
                    }
                    else {
                        echo get_template_directory_uri() . '/images/placeholder.jpeg';
                    }
                    ?>')"></div>
                    <a title="<?php the_title(); ?>" href="<?php echo $post_link; ?>">
                        <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                    </a>
                </div>
                <div class="articlePreviewContent">
                    <?php if ($category_name): ?>
                        <span class="articleCategory borderText border-brandGreen"><?php echo $category_name; ?></span>
                    <?php endif; ?>
                    <h3 class="articleTitle">
                        <a title="<?php the_title(); ?>" href="<?php echo $post_link; ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <div class="articlePublished author author-inline">
                        <p class="authorTitle">By <?php the_author(); ?></p>
                    </div>
                    <div class="articleExcerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a class="articleLink link-leftDash" title="<?php the_title(); ?>" href="<?php echo $post_link; ?>">Read
                        More</a>
                </div>
            </article>
            <div class="cardContainer"><?php // starting cardContainer for cards
                ?>
                <?php else : ?>
                    <article class="archiveListItem card card-underlineHover-brandGreen card-shadowHover">
                            <div class="articleImage">
                                <div class="image bg-image"
                                     style="background-image: url('<?php
                                     if (has_post_thumbnail()) {
                                         the_post_thumbnail_url( 'archive-image' );
                                     }
                                     else {
                                         echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                     }
                                     ?>')"></div>
                                <a title="<?php the_title(); ?>" href="<?php echo $post_link; ?>">
                                    <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                                </a>
                            </div>
                        <div class="articlePreviewContent">
                            <?php if (!empty($category_name)): ?>
                                <span class="articleCategory borderText border-brandGreen"><?php echo $category_name; ?></span>
                            <?php endif; ?>
                            <h3 class="articleTitle">
                                <a title="<?php the_title(); ?>" href="<?php echo $post_link; ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="articleExcerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                        <a class="articleLink link-leftDash" title="<?php the_title(); ?>"
                           href="<?php echo $post_link; ?>">Read More</a>
                    </article>
                <?php endif; ?>
                <?php endwhile; ?>
            </div> <?php restore_current_blog()// closing cardContainer ?>
            <?php if (function_exists("pagination")) {
                pagination($custom_query);
            } ?>

        </div> <?php // closing articleList ?>
    </section> <?php // closing articleListContainer ?>
<?php
get_footer();
