<?php
/**
 * Template for Press Details
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header(); ?>

    <article class="container">
        <header class="singlePostIntro centerAlign">
            <?php if (!empty(get_the_title())) : ?>
                <h1><?php the_title(); ?></h1>
            <?php endif;
            if (!empty(get_the_date())) : ?>
                <p class="date icon-calendar iconDetail">
                    <time datetime="<?php echo date('Y-m-d', strtotime(get_the_date())); ?>">
                        <?php echo get_the_date(); ?>
                    </time>
                </p>
            <?php endif; ?>
        </header>

        <?php
        switch_to_blog(1);
        if (has_post_thumbnail($post->ID)) :
            $id = get_post_thumbnail_id($post->ID);
            $image = wp_get_attachment_image_src($id, 'featured-image');
            $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
            restore_current_blog();
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
                    if (!empty(get_the_content())): ?>
                        <div class="overview singlePostContentGroup">
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
                    <?php endif; ?>

                <footer class="callout centerAlign">
                    <div class="borderTextDivider">
                        <p class="borderText border-brandGrey">Media Inquiries</p>
                    </div>
                    <span class="icon iconTwoTone twoTone-megaphone"></span>
                    <h2>MaxLiving Media Inquiries</h2>
                    <div class="content">
                        <p>
                            Are you a member of the media looking for more information on MaxLiving? Our Corporate Communications team is here to help. Contact us today and a member of our team will contact you <br>as soon as possible.
                        </p>
                    </div>
                    <div class="link">
                        <a class="button button-tertiary button-large" href="<?php echo home_url().'/contact';?>">Contact Us</a>
                    </div>
                </footer>
            </div>
        </div>
    </article>

    <div class="singlePostPreviousNext container">
        <?php
        $previousNextName = 'Release';
        include(locate_template('template-parts/previousNext.php'));
        ?>
    </div>


<?php
$args = array(
    'posts_per_page' => 3,
    'post_type' => 'press',
    'post__not_in'   => array(get_queried_object_id() )
);
$custom_query = new WP_Query($args);
if($custom_query->have_posts()):
?>

    <aside class="singlePostRelated container">
        <h2 class="centerAlign">Related Releases</h2>
        <div class="articleList">
            <?php
            while ($custom_query->have_posts()) :
                $custom_query->the_post();
                ?>

                <article class="archiveListItem card card-underlineHover-brandGrey card-shadowHover">
                        <div class="articleImage">
                            <div class="image bg-image"
                                 style="background-image: url('<?php
                                 if (has_post_thumbnail()) {
                                     the_post_thumbnail_url( 'archive-image-top' );
                                 }
                                 else {
                                     echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                 }
                                 ?>')"></div>
                            <a
                                <?php if (!empty(get_the_title())) : ?>
                                    title="<?php the_title(); ?>"
                                <?php endif; ?>
                                href="<?php the_permalink(); ?>">
                                <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                            </a>
                        </div>
                    <div class="articlePreviewContent">
                        <div class="articlePublished date">
                            <p class="date icon-calendar iconDetail">
                                <time datetime="<?php echo date('Y-m-d', strtotime(get_the_date())); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </p>
                        </div>
                        <?php if (!empty(get_the_title())) : ?>
                            <h3 class="articleTitle">
                                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                        <?php endif; ?>
                    </div>
                    <a class="articleLink link-leftDash"
                        <?php if (!empty(get_the_title())) : ?>
                            title="<?php the_title(); ?>"
                        <?php endif; ?>
                        href="<?php the_permalink(); ?>">Read More</a>
                </article>
            <?php endwhile; ?>
        </div>
    </aside>

<?php
endif;
get_footer();
