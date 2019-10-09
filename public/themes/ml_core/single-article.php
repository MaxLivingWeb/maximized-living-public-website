<?php
/**
 * Template for Article Details
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();
global $blog_id;
$childsite_id = $blog_id;
$childsite_base_url = home_url();

global $taxonomy;
global $category_name;
$taxonomy = 'article_categories';
switch_to_blog(1);
get_template_part('template-parts/category');
restore_current_blog();
?>

    <article class="container">
        <header class="singlePostIntro centerAlign">
            <?php if (!empty($category_name)) : ?>
                <div class="borderText border-brandTeal"><?php echo $category_name; ?></div>
            <?php endif;
            if (!empty(get_the_title())) : ?>
                <h1><?php the_title(); ?></h1>
            <?php endif;
            if (!empty(get_the_date())) : ?>
                <p class="date icon-calendar iconDetail">
                    <time datetime="<?php echo date('Y-m-d', strtotime(get_the_date())); ?>">
                        <?php echo get_the_date(); ?>
                    </time>
                </p>
            <?php endif; ?>
            <!-- <div class="link">
                <?php
                $text = "Shop Now";
                $link = "https://store.maxliving.com/";
                if ($childsite_id != 1) {
                    $text = "Shop Now";
                    $link = "https://store.maxliving.com/";
                }
                ?>
                <a class="button button-tertiary button-large" href="<?php echo $link; ?>"><?php echo $text; ?></a>
            </div> -->
        </header>

        <?php
        switch_to_blog(1);
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
                <div class="overview singlePostContentGroup">
                    <div class="content">
                        <?php if (!empty(the_content())): ?>
                                <div class="overview singlePostContentGroup">
                                    <div class="content" id="content">
                                        <?php
                                        $content = the_content();
                                        $content = apply_filters('the_content', $content);
                                        $content = str_replace(']]>', ']]&gt;', $content);
                                        $content = str_replace("<blockquote>", "<blockquote class=\"quote\">", $content);
                                        echo $content;
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>

                <?php get_template_part('template-parts/author-footer'); ?>

            </div>
        </div>
    </article>
<?php restore_current_blog();
if (get_current_blog_id() === 1 && 1 === 2): ?>
    <div class="singlePostPreviousNext container">
        <?php
        $previousNextName = 'Article';
        include(locate_template('template-parts/previousNext.php'));
        ?>
    </div>
<?php endif;

//this one will work for corporate
$args = array(
    'posts_per_page' => 3,
    'post_type' => 'article',
    'post__not_in' => array(get_queried_object_id()),
    'meta_query' => array(
        array(
            'key' => 'distribution_reach',
            'value' => '1'
        ),
    ),
);

//for childsites
if ($childsite_id !== 1) {
    $args = array(
        'posts_per_page' => 3,
        'post_type' => 'article',
        'post__not_in' => array(get_queried_object_id())
    );
}
$custom_query = new WP_Query($args);
if ($custom_query->have_posts()):
    ?>
    <aside class="singlePostRelated container">
        <h2 class="centerAlign">Related Articles</h2>
        <div class="articleList">
            <?php
            while ($custom_query->have_posts()) :
                $custom_query->the_post();
                get_template_part('template-parts/category');

                ?>

                <article class="archiveListItem card card-underlineHover-brandTeal card-shadowHover">
                    <div class="articleImage">
                        <div class="image bg-image" style="background-image: url('<?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail_url('archive-image-top');
                        } else {
                            echo get_template_directory_uri() . '/images/placeholder.jpeg';
                        }
                        ?>')"></div>
                        <a
                            <?php if (!empty(get_the_title())): ?>
                                title="<?php the_title(); ?>"
                            <?php endif; ?>
                                href="<?php echo $childsite_base_url . "/healthy-articles/" . get_post_field('post_name', get_post()); ?>"
                        >
                            <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                        </a>
                    </div>
                    <div class="articlePreviewContent">
                        <?php if (!empty($category_name)): ?>
                            <div><span
                                    class="articleCategory borderText border-brandTeal"><?php echo $category_name; ?></span>
                            </div><?php endif ?>
                        <?php if (!empty(get_the_title())): ?>
                            <h3 class="articleTitle">
                                <a title="<?php the_title(); ?>"
                                   href="<?php echo $childsite_base_url . "/healthy-articles/" . get_post_field('post_name', get_post()); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                        <?php endif; ?>
                    </div>
                    <a
                            class="articleLink link-leftDash"
                        <?php if (!empty(get_the_title())): ?>
                            title="<?php the_title(); ?>"
                        <?php endif; ?>
                            href="<?php echo $childsite_base_url . "/healthy-articles/" . get_post_field('post_name', get_post()); ?>"
                    >Read More</a>
                </article>
            <?php endwhile; ?>
        </div>
    </aside>

<?php
endif;
get_footer();
