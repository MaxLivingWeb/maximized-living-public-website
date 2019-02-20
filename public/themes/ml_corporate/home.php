<?php
/* Template Name: Corporate Home */
get_header();

$heroImage = get_template_directory_uri() . 'images/placeholder.jepg';
if (get_field('hero_background_image', 'options')) :
    $heroImage = get_field('hero_background_image', 'options');
endif; ?>

    <section class="hero homeHero bg-image wave wave-multi" style="background-image: url('<?php echo $heroImage; ?>');" id="content">
        <div class="heroContent">
            <h1>
                <span class="heroLeading">Restore your health through</span>
                <span class="heroHeadline">Chiropractic</span>
            </h1>
            <p class="heroDescription heroDescription-sm">
                We want to educate people about the power of chiropractic and empower them to live longer, healthier
                lives.
            </p>
            <a class="button button-tertiary" href="<?php echo get_home_url().'/locations';?>" title="Find a clinic near you">Make an Appointment</a>
        </div>
    </section>

    <section class="essentials essentials-home bg-faintGrey centerAlign">
        <div class="container discoverEssentials">
            <h2>Discover the 5 Essentials<sup>&trade;</sup></h2>
            <p>The 5 Essentials<sup>&trade;</sup> is a natural and effective way to align your health. By integrating chiropractic care
                with our four other powerful essentials — mindset, pure and simple nutrition, exercise, and minimizing
                toxins — MaxLiving gives you the tools you need for good health and longevity.</p>
        </div>
        <div class="essentialsContainer container">
            <div class="card card-fifth card-noBorder core">
                <a href="<?php echo get_home_url().'/five-essentials/core-chiropractic';?>" class="essentialLink">
                    <span class="invisible" aria-hidden="true">Core Chiropractic</span>
                </a>
                <div class="cardContent">
                    <span class="essentialIcon icon-coreSymbol text-brandGrey"></span>
                    <h3 class="essentialName uppercase">Core Chiropractic</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>The proper function of the nervous system through spinal correction is central to
                                chiropractic care.</p>
                            <a href="<?php echo get_home_url().'/five-essentials/core-chiropractic';?>" class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-fifth card-noBorder nutrition">
                <a href="<?php echo get_home_url().'/five-essentials/nutrition';?>" class="essentialLink">
                    <span class="invisible" aria-hidden="true">Nutrition</span>
                </a>
                <div class="cardContent">
                    <span class="essentialIcon icon-nutritionSymbol text-brandGreen"></span>
                    <h3 class="essentialName uppercase">Nutrition</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>Nutrition goes beyond weight loss — a healthy diet focused on natural foods improves your
                                body's composition and muscle-to-fat ratio, helping you achieve better health overall to
                                last a lifetime.</p>
                            <a href="<?php echo get_home_url().'/five-essentials/nutrition';?>" class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-fifth card-noBorder mindset">
                <a href="<?php echo get_home_url().'/five-essentials/mindset';?>" class="essentialLink">
                    <span class="invisible" aria-hidden="true">Mindset</span>
                </a>
                <div class="cardContent">
                    <span class="essentialIcon icon-mindsetSymbol text-brandOrange"></span>
                    <h3 class="essentialName uppercase">Mindset</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>A healthy body starts with the right mindset. We believe a healthy lifestyle supports
                                nutrients for optimal brain function, stress management, and good sleep patterns.</p>
                            <a href="<?php echo get_home_url().'/five-essentials/mindset';?>" class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-fifth card-noBorder oxygen">
                <a href="<?php echo get_home_url().'/five-essentials/oxygen-and-exercise';?>" class="essentialLink">
                    <span class="invisible" aria-hidden="true">Oxygen &amp; Exercise</span>
                </a>
                <div class="cardContent">
                    <span class="essentialIcon icon-oxygenSymbol text-brandTeal"></span>
                    <h3 class="essentialName uppercase">Oxygen &amp; Exercise</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>Exercise helps your body increase oxygen levels and lean muscle, helping reduce fat and
                                improve performance while increasing your ability to fight stress, anxiety, and other
                                illnesses.</p>
                            <a href="<?php echo get_home_url().'/five-essentials/oxygen-and-exercise';?>" class="button button-secondary">Learn
                                More</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card card-fifth card-noBorder toxins">
                <a href="<?php echo get_home_url().'/five-essentials/minimize-toxins';?>" class="essentialLink">
                    <span class="invisible" aria-hidden="true">Minimize Toxins</span>
                </a>
                <div class="cardContent">
                    <span class="essentialIcon icon-toxinsSymbol text-brandBrown"></span>
                    <h3 class="essentialName uppercase">Minimize Toxins</h3>
                    <span class="icon-arrowRight text-brandGrey"></span>
                    <div class="essentialContent centerAlign">
                        <div class="content">
                            <p>Minimize Toxins: Harmful chemicals surround us every day in our lives — our program
                                supports the body's natural ability to cleanse itself, resulting in long-lasting
                                positive effects.</p>
                            <a href="<?php echo get_home_url().'/five-essentials/minimize-toxins';?>" class="button button-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-faintGrey wave wave-white">
        <?php if (get_field('featured_product_name', 'options') && get_field('featured_product_background_image', 'options') && get_field('featured_product_description', 'options')) : ?>
            <div class="featuredProduct">
        <div class="container">
            <div class="productImage bg-brandTeal bg-pattern bg-pattern-oxygen">
                <div class="image"
                     style="background-image:url('<?php echo get_field('featured_product_background_image', 'options'); ?>');">
                </div>
            </div>
            <div class="featuredProductContent">
                <h2><span class="borderText border-brandTeal">Featured Product</span></h2>
                <div class="productDescription">
                    <a href="<?php echo get_field('featured_product_link', 'options'); ?>"><h3><?php echo get_field('featured_product_name', 'options'); ?></h3></a>
                    <div><?php echo get_field('featured_product_description', 'options'); ?></div>
                    <div class="productLinks">
                        <?php if (get_field('featured_product_link', 'options')) : ?>
                            <a class="shopLink button button-secondary"
                               href="<?php echo get_field('featured_product_link', 'options') . utmURL(); ?>"
                               title="Shop Now for <?php echo get_field('featured_product_name', 'options'); ?>">Shop
                                Now</a>
                        <?php endif; ?>
                        <a class="storeLink link-leftDash" href="<?php echo get_home_url().'/store' . utmURL(); ?>" title="Visit Store">Visit Store</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
<?php endif; ?>
    </section>
    <section class="featuredArticles doctorsBlog container">
        <h2 class="centerAlign">Doctor's Blog</h2>
        <p class="doctorsBlogIntro centerAlign">Hear from our leading experts on the topics of health, nutrition, and
            optimization.</p>
        <div class="articleCon">
            <article>
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'posts_per_page' => 1,
                    'post_type' => 'recipe',
                    'paged' => $paged
                );
                $custom_query = new WP_Query($args);
                $featureTop = true;
                while ($custom_query->have_posts()) :
                    $custom_query->the_post();
                    ?>
                    <div class="cardTop">
                        <p class="borderText border-brandGreen">Featured Recipe</p>
                        <a class="link-leftDash" href="<?php echo get_home_url().'/healthy-recipes';?>">More Recipes</a>
                    </div>
                    <div class="card card-noBorder card-shadowHover card-underlineHover-brandGreen">
                        <div class="cardContent">
                            <?php
                            $alt = "MaxLiving Recipe";
                            $id = get_post_thumbnail_id($post->ID);
                            $image = wp_get_attachment_image_src($id, 'home-image');
                            if (get_post_meta($id, '_wp_attachment_image_alt', true)) {
                                $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
                            } ?>
                            <div class="imageContainer">
                                <div class="imageContent bg-image" style="background-image:url('<?php
                                if (has_post_thumbnail()) {
                                    echo $image[0];
                                } else {
                                    echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                }
                                ?>')">
                                    <a href="<?php the_permalink(); ?>">
                                        <img class="image" src="<?php
                                        if (has_post_thumbnail()) {
                                            echo $image[0];
                                        } else {
                                            echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                        }
                                        ?>" alt="<?php echo $alt; ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="cardBody">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="link-leftDash bottomLink">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </article>

            <article>
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'posts_per_page' => 1,
                    'post_type' => 'article',
                    'paged' => $paged
                );
                $custom_query = new WP_Query($args);
                $featureTop = true;
                while ($custom_query->have_posts()) :
                    $custom_query->the_post();
                    ?>
                    <div class="cardTop">
                        <p class="borderText border-brandOrange">Featured Article</p>
                        <a class="link-leftDash" href="<?php echo get_home_url().'/healthy-articles';?>">More Articles</a>
                    </div>
                    <div class="card card-noBorder card-shadowHover card-underlineHover-brandOrange">
                        <div class="cardContent">
                            <?php
                            $alt = "MaxLiving Article";
                            $id = get_post_thumbnail_id($post->ID);
                            $image = wp_get_attachment_image_src($id, 'home-image');
                            if (get_post_meta($id, '_wp_attachment_image_alt', true)) {
                                $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
                            }
                            ?>
                            <div class="imageContainer">
                                <div class="imageContent bg-image" style="background-image:url('<?php
                                if (has_post_thumbnail()) {
                                    echo $image[0];
                                } else {
                                    echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                }
                                ?>')">
                                    <a href="<?php the_permalink(); ?>">
                                        <img class="image" src="<?php
                                        if (has_post_thumbnail()) {
                                            echo $image[0];
                                        } else {
                                            echo get_template_directory_uri() . '/images/placeholder.jpeg';
                                        }
                                        ?>" alt="<?php echo $alt; ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="cardBody">
                                <h4><a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?></a></h4>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="link-leftDash bottomLink">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </article>
        </div>
    </section>
<?php
get_template_part('template-parts/schema');
get_footer();
