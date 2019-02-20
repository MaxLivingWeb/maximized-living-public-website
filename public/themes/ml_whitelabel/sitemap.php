<?php
/* Template Name: Sitemap */
/**
 * Template for HTML Sitemap
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

$locations = '';
if(get_current_blog_id() == 1) {
    $location_functions = new \MaxLiving\Location\FrontEnd\Functions();
    $locations = $location_functions->get_all_cities();
}

$sitemap_obj = new \MaxLiving\Sitemaps\Includes\Generate();

$recipes = $sitemap_obj->get_articles_or_recipes('recipe');

$articles = $sitemap_obj->get_articles_or_recipes('article');

//need to grab these two by name to exclude them from the page list by ID
$sitemap_page = get_page_by_path( "sitemap" );
$thank_you = get_page_by_path("thank-you");

get_header();
?>
    <div class="hero" style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/mainHero.jpg');">
        <div class="heroContent centerAlign container">
            <h1 class="heroHeadline">Sitemap</h1>
        </div>
    </div>
    <section class="articleListContainer container">

    <article class="container">
        <h1>Sitemap</h1>
        <div class="singlePostContainer">

        <ul>
            <?php wp_list_pages('exclude='.$sitemap_page->ID.','.$thank_you->ID ); ?>

            <?php
            $press_and_media = new \WP_Query( array('post_type' => 'press',
                'posts_per_page' => 500) );

            if($press_and_media->have_posts() ) {
                echo "<li class=\"pagenav\">Press and Media<ul>";
                while($press_and_media->have_posts() ) {
                    $press_and_media->the_post();

                    $permalink = get_permalink();
                    $title = get_the_title();
                    echo "<li><a href=\"$permalink\">$title</a></li>";
                }
                echo "</ul></li>";
            } ?>

            <?php
            $events = new \WP_Query( array('post_type' => 'event',
                'posts_per_page' => 500) );

            if($events->have_posts() ) {
                echo "<li class=\"pagenav\">Events<ul>";
                while($events->have_posts() ) {
                    $events->the_post();

                    $permalink = get_permalink();
                    $title = get_the_title();
                    echo "<li><a href=\"$permalink\">$title</a></li>";
                }
                echo "</ul></li>";
            } ?>
        </ul>
        </div>
    </article>

    <article class="container">
        <div class="singlePostContainer">
        <ul>
            <?php

            if($recipes->have_posts() ) {
                echo "<li class=\"pagenav\">Recipes<ul>";
                while($recipes->have_posts() ) {

                    switch_to_blog(1);

                    $recipes->the_post();

                    $post_meta = get_post_meta( $recipes->post->ID );
                    $site_origin_id = $post_meta['siteOriginID'][0];
                    $site_origin = get_home_url($site_origin_id);
                    $post = get_post( $recipes->post->ID );

                    //default to corporate
                    $corporate_site = get_home_url(1);
                    $post_url = "$corporate_site/healthy-recipes/$post->post_name/";

                    //if it is 'my site only' or regional
                    if($post_meta['distribution_reach'][0] === '0' || $post_meta['distribution_reach'][0] === '2') {
                        $post_url = "$site_origin/healthy-recipes/$post->post_name/";
                    }

                    $title = get_the_title();
                    echo "<li><a href=\"$post_url\">$title</a></li>";

                    restore_current_blog();
                }
                echo "</ul></li>";
            } ?>

            <?php

            if($articles->have_posts() ) {
                echo "<li class=\"pagenav\">Articles<ul>";
                while($articles->have_posts() ) {

                    switch_to_blog(1);
                    $articles->the_post();

                    $post_meta = get_post_meta( $articles->post->ID );
                    $site_origin_id = $post_meta['siteOriginID'][0];
                    $site_origin = get_home_url($site_origin_id);
                    $post = get_post( $articles->post->ID );

                    //default to corporate
                    $corporate_site = get_home_url(1);
                    $post_url = "$corporate_site/healthy-articles/$post->post_name/";

                    //if it is 'my site only' or regional
                    if($post_meta['distribution_reach'][0] === '0' || $post_meta['distribution_reach'][0] === '2') {
                        $post_url = "$site_origin/healthy-articles/$post->post_name/";
                    }

                    $title = get_the_title();
                    echo "<li><a href=\"$post_url\">$title</a></li>";

                    restore_current_blog();
                }
                echo "</ul></li>";
            } ?>
        </ul>
        </div>
    </article>
    <?php if(!empty($locations) ): ?>
        <article class="container">
            <div class="singlePostContainer">
                <ul>
                    <li class="pagenav">Locations - Country
                        <ul>
                            <?php
                            foreach($locations->countries as $country) {
                                if($location_functions->country_has_locations($country)) {
                                    $url = get_home_url()."/locations/".strtolower($country->abbreviation);
                                    echo "<li><a href=\"$url\">".$country->name."</a></li>";
                                }
                            } ?>
                        </ul>
                    </li>

                    <li class="pagenav">Locations - Regions
                        <ul>
                            <?php
                            foreach($locations->countries as $country) {
                                foreach($country->regions as $region) {
                                    if($location_functions->region_has_locations($region)) {
                                        $url = get_home_url()."/locations/".strtolower($country->abbreviation."/".$region->abbreviation);
                                        echo "<li><a href=\"$url\">".$region->name."</a></li>";
                                    }
                                }
                            } ?>
                        </ul>
                    </li>

                    <li class="pagenav">Locations - Cities
                        <ul>
                            <?php
                            foreach($locations->countries as $country) {
                                foreach($country->regions as $region) {
                                    foreach($region->cities as $city) {
                                        if($location_functions->city_has_locations($city)) {
                                            $url = get_home_url()."/locations/".strtolower($country->abbreviation."/".$region->abbreviation."/".$city->slug);
                                            echo "<li><a href=\"$url\">".$city->name."</a></li>";
                                        }
                                    }
                                }
                            } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </article>
    <?php endif; ?>
    </section>
<?php

get_footer();
