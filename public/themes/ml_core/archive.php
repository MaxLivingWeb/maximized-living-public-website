<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header(); ?>
    <div class="hero" style="background-image:url('http://maximized-living-pubic.dev/app/../uploads/2017/11/calm_squirrel.jpeg');">
        <div class="wave wave-multi"></div>
        <div class="heroContent centerAlign container">
            <h1 class="heroHeadline">Healthy Articles</h1>
            <p class="heroDescription">
                No matter your personal wellness goals — to eliminate pain, overcome illness, or improve your overall health — we provide you with the latest information and chiropractic updates to help you balance your health.'
            </p>
            <span class="icon-lineWave"></span>
        </div>
    </div>

    <section class="articleListContainer container">
        <div class="articleListIntro">
            <h2>Latest Articles</h2>
            <div class="categoryFilter inputField">
                <label class="invisible" for="categoryFilter">Filter by Category</label>
                <select id="categoryFilter" class="categoryDropdown" name="categoryFilter">
                    <option value="">Filter by Category</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                </select>
            </div>
        </div>
        <div class="articleList">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                'posts_per_page' => 5,
                'post_type' => 'event',
                'paged' => $paged
            );

            $custom_query = new WP_Query($args);
            while ($custom_query->have_posts()) :
                $custom_query->the_post();
                ?>
                <article class="archiveListItem">
                    <div class="articleImage">
                        <div class="image bg-image" style="background-image: url('<?php the_post_thumbnail_url('full'); ?>')"></div>
                        <a title="<?php the_title(); ?>"  href="<?php the_permalink(); ?>"></a>
                    </div>
                    <div class="articlePreviewContent">
                        <span class="articleCategory borderText border-brandGreen"><?php the_category(); ?></span>
                        <h3 class="articleTitle">
                            <a title="<?php the_title(); ?>"  href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="articleExcerpt">
                            <?php the_excerpt(); ?>
                        </p>
                        <a class="articleLink link-leftDash" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">Event Details</a>
                    </div>
                </article> <!-- end posts -->
            <?php endwhile; ?>
        </div>
        <?php if (function_exists("pagination")) {
            pagination($custom_query);
        } ?>
    </section>

<?php
get_footer();
