<?php
/**
 * Template for Article Details
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header(); ?>

    <article>

        <header>
            <?php if (!empty(get_the_title())) { ?>
                <h1><?php the_title(); ?></h1>
            <?php }
            if (!empty(get_the_date())) { ?>
                <div>
                    <span class="icon-calendar"></span>
                    <time datetime="<?php echo get_the_date('Y-m-d H:i'); ?>"><?php the_date(); ?></time>
                </div>
            <?php } ?>
        </header>

        <?php if (has_post_thumbnail($post->ID)) {
            $id = get_post_thumbnail_id($post->ID);
            $image = wp_get_attachment_image_src($id, 'full');
            $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
            ?>
            <div class="fullImage bg-image" style="background-image: url('<?php echo $image[0]; ?>')">
                <img class="image" src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>">
            </div>
        <?php } ?>

        <aside class="socialSidebar socialSticky">
            <?php get_template_part('template-parts/share'); ?>
        </aside>

        <?php if (!empty(get_the_content())) { ?>
            <div>
                <?php the_content(); ?>
            </div>
        <?php } ?>

        <div>
            <h2>For MaxLiving Media Inquiries</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, adipisci autem consectetur dignissimos dolorem doloribus et ex illo illum iure, laudantium officia quidem quis recusandae repudiandae rerum velit voluptas! Quisquam.</p>
            <a href="" class="button-large">Contact Us</a>
        </div>
    </article>

    <?php
        $previousNextName = 'Article';
        include(get_template_directory().'/template-parts/previousNext.php');
    ?>

    <aside>
        <h2>Releated Releases</h2>
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page' => 3,
            'post_type' => 'post',
            'paged' => $paged
        );
        $custom_query = new WP_Query($args);
        while ($custom_query->have_posts()) :
            $custom_query->the_post();
            ?>

            <article class="card card-third card-underlineHover-brandGreen">
                <div>
                    <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('full'); ?>" alt=""></a>
                </div>
                <div class="borderText border-brandGreen"><?php the_category(); ?></div>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p>
                    <?php the_excerpt(); ?>
                </p>

                <div>

                    <a href="<?php the_permalink(); ?>" class="link-leftDash">Read More</a>
                </div>

            </article>


        <?php endwhile; ?>
    </aside>


<?php
get_footer();
