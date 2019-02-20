<?php
/* Template Name: Archive - Articles */
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
$taxonomy = 'article_categories';
$postType = 'article';
$categorySortScripts = true;
?>
    <div class="hero hero-archive wave wave-multi" style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/hero-healthy-articles.jpg');'" id="content">
        <div class="heroContent centerAlign container">
            <h1 class="heroHeadline">Healthy Articles</h1>
            <p class="heroDescription">
                No matter your personal wellness goals — to eliminate pain, overcome illness, or improve your overall health — we provide you with the latest information and chiropractic updates to help you balance your health.
            </p>
            <span class="icon-lineWave"></span>
        </div>
    </div>

    <section class="articleListContainer container">
        <div class="articleListIntro">
            <h2>Latest Articles</h2>
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
            global $paged;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                'posts_per_page' => 5,
                'post_type' => 'article',
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

//            $cache = 'article-archive-'.get_current_blog_id();//cache name
//            $custom_query = get_site_transient($cache);//get cache?
//            if ($custom_query === false) {//no cache
//                $custom_query = new WP_Query($args);//run query
//                set_site_transient( $cache, $custom_query, HOUR_IN_SECONDS);//set query cache for 1 hour
//            }
//            else {//there is cache!
//                $custom_query = get_site_transient($cache);//get cache
//            }

            $childsite_url = home_url();
            $custom_query = new WP_Query($args);//run query

            while ($custom_query->have_posts()) :
                $custom_query->the_post();
                $post_link = $childsite_url.'/healthy-articles/'.get_post()->post_name;
                $category_name="";
                get_template_part('template-parts/category');
                ?>
                <article class="archiveListItem">
                    <div class="articleImage">
                        <div class="image bg-image" style="background-image: url('<?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail_url( 'archive-image' );
                        }
                        else {
                            echo get_template_directory_uri() . '/images/placeholder.jpeg';
                        }
                        ?>')"></div>
                        <a title="<?php the_title(); ?>"  href="<?php echo $post_link; ?>">
                            <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                        </a>
                    </div>
                    <div class="articlePreviewContent">
                        <?php if ( !empty($category_name) ): ?>
                        <span class="articleCategory borderText border-brandGreen"><?php echo $category_name; ?></span>
                        <?php endif; ?>
                        <h3 class="articleTitle">
                            <a title="<?php the_title(); ?>"  href="<?php echo $post_link; ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <div class="articleExcerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a class="articleLink link-leftDash" title="<?php the_title(); ?>" href="<?php echo $post_link; ?>">Article Details</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php restore_current_blog() ?>
        <?php if (function_exists("pagination")) {
            pagination($custom_query);
        } ?>
    </section>

<?php
get_footer();
