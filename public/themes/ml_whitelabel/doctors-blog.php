<?php
/* Template Name: Doctor's Blog */
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
$heroImage = get_template_directory_uri() . "/images/WhiteLabel_HealthyArticles_Hero.jpg";
$childsite_url = home_url();
if (has_post_thumbnail()) :
    $heroImage = get_the_post_thumbnail_url(get_the_ID(), 'full');
endif;

?>
<div class="hero doctorsBlogHero" style="background-image:url('<?php echo $heroImage; ?>');" id="content">
    <div class="heroContent centerAlign container container-sm">
        <h1 class="heroHeadline">Doctor's Blog</h1>
        <p class="heroDescription">
            No matter your personal wellness goals — to eliminate pain, overcome illness, or improve your overall health
            — we provide you with the latest information and chiropractic updates to help you balance your health.'
        </p>
    </div>
</div>

<section class="articleListContainer container">
    <div class="articleListIntro">
        <h2>Latest Articles from our Team</h2>
    </div>
    <div class="articleList">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'posts_per_page' => 5,
            'paged' => $paged
        );

        $custom_query = new WP_Query($args);

        while ($custom_query->have_posts()) :
            $custom_query->the_post();
            $post_link = $childsite_url . '/healthy-recipes/' . get_post()->post_name;
            $category_name = "";
            $taxonomy = 'recipe_categories';
            $postType = 'recipe';
            if (get_post()->post_type === 'article') {
                $taxonomy = 'article_categories';
                $postType = 'article';
                $post_link = $childsite_url . '/healthy-articles/' . get_post()->post_name;
            }
                get_template_part('template-parts/category');
            ?>
            <article class="archiveListItem">
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
                    <a title="<?php the_title(); ?>" href="<?php echo $post_link; ?>"></a>
                </div>
                <div class="articlePreviewContent">
                    <?php if (!empty($category_name)) : ?>
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
                    <a class="articleLink link-leftDash" title="<?php the_title(); ?>" href="<?php echo $post_link; ?>">Read
                        More</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
    <?php

    restore_current_blog();

    $p_args = array(
        'base'               => get_site_url().'/doctors-blog%_%',
        'format'             => '/page/%#%',
        'total'              => $custom_query->max_num_pages,
        'current'            => $paged,
        'show_all'           => false,
        'end_size'           => 1,
        'mid_size'           => 2,
        'prev_next'          => true,
        'prev_text'          => '<span class="icon-arrowLeft">',
        'next_text'          => '<span class="icon-arrowRight">',
        'type'               => 'plain',
        'add_args'           => false,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => ''
    );

    echo "<div class=\"pagination\">".paginate_links($p_args)."</div>";

    ?>
</section>

<?php
get_footer();
