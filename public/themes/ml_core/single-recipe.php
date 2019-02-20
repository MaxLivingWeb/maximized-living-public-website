<?php
/**
 * Template for Recipe Details
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MaxLiving
 */

get_header();
global $blog_id;
$childsite_id       = $blog_id;
$childsite_base_url = home_url();
if ( $blog_id != 1 ) {
	switch_to_blog( 1 );
	$switched = true;
}

global $taxonomy;
global $category_name;
$taxonomy = 'recipe_categories';
switch_to_blog( 1 );
get_template_part( 'template-parts/category' );
restore_current_blog();

?>

    <article class="container recipeSingle">
        <header class="singlePostIntro centerAlign">
			<?php if ( ! empty( $category_name ) ) : ?>
                <div class="borderText border-brandGreen"><?php echo $category_name; ?></div>
			<?php endif;
			if ( ! empty( get_the_title() ) ) : ?>
                <h1><?php the_title(); ?></h1>
			<?php endif;
			if ( ! empty( get_the_date() ) ) : ?>
                <p class="date icon-calendar iconDetail">
                    <time datetime="<?php echo date( 'Y-m-d', strtotime( get_the_date() ) ); ?>">
						<?php echo get_the_date(); ?>
                    </time>
                </p>
			<?php endif; ?>
			<div class="link">
					<?php
					$text = "Shop Now";
					$link = "https://maxliving.com/store";
					if ($childsite_id != 1) {
							$text = "Shop Now";
							$link = "https://maxliving.com/store";
					}
					?>
					<a class="button button-tertiary button-large" href="<?php echo $link; ?>"><?php echo $text; ?></a>
			</div>
        </header>
		<?php
		switch_to_blog( 1 );
		if ( has_post_thumbnail( $post->ID ) ) :
			$id = get_post_thumbnail_id( $post->ID );
			$image = wp_get_attachment_image_src( $id, 'featured-image' );
			$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
			restore_current_blog();
			?>
            <div class="fullImage bg-image" style="background-image: url('<?php echo $image[0]; ?>')">
                <img class="image" src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>">
            </div>
		<?php endif; ?>

        <div class="singlePostContainer">
            <aside class="socialSidebar socialSticky">
				<?php get_template_part( 'template-parts/share' ); ?>
            </aside>
            <div class="singlePostContent">
				<?php if ( ! empty( the_content() ) ): ?>
                    <div class="overview singlePostContentGroup">
                        <h2>Overview</h2>
                        <div class="content" id="content">
							<?php
							$content = the_content();
							$content = apply_filters( 'the_content', $content );
							$content = str_replace( ']]>', ']]&gt;', $content );
							$content = str_replace( "<blockquote>", "<blockquote class=\"quote\">", $content );
							echo $content;
							?>
                        </div>
                    </div>
				<?php endif; ?>

				<?php if ( get_field( 'prep_time' ) || get_field( 'cook_time' ) || get_field( 'yield' ) ) : ?>
                    <div class="articleTable singlePostContentGroup">
						<?php if ( get_field( 'prep_time' ) ) : ?>
                            <div class="tableSection centerAlign">
                                <p class="tableTitle">Prep Time</p>
                                <p class="tableContent"><?php the_field( 'prep_time' ); ?></p>
                            </div>
						<?php endif;
						if ( get_field( 'cook_time' ) ) : ?>
                            <div class="tableSection centerAlign">
                                <p class="tableTitle">Cook Time</p>
                                <p class="tableContent"><?php the_field( 'cook_time' ); ?></p>
                            </div>
						<?php endif;
						if ( get_field( 'yield' ) ) : ?>
                            <div class="tableSection centerAlign">
                                <p class="tableTitle">Yield</p>
                                <p class="tableContent"><?php the_field( 'yield' ); ?></p>
                            </div>
						<?php endif; ?>

                        <div class="printContent">
		                    <?php
		                    $content = the_content();
		                    $content = apply_filters( 'the_content', $content );
		                    $content = str_replace( ']]>', ']]&gt;', $content );
		                    $content = str_replace( "<blockquote>", "<blockquote class=\"quote\">", $content );
		                    echo $content;
		                    ?>
                        </div>
                    </div>
				<?php endif; ?>
                <div class="recipeInfo">
                    <div class="printTitle">
						<?php the_title(); ?>
                    </div>
					<?php if ( have_rows( 'nutrition_facts' ) ) : ?>
                        <div class="nutrition singlePostContentGroup">
                            <h2>Nutrition</h2>
                            <ul>
								<?php while ( have_rows( 'nutrition_facts' ) ): the_row(); ?>
                                    <li>
										<?php the_sub_field( 'nutrition_fact' ); ?>
                                    </li>
								<?php endwhile; ?>
                            </ul>
                        </div>
					<?php endif; ?>

					<?php if ( have_rows( 'ingredients' ) ) : ?>
                        <div class="ingredients singlePostContentGroup">
                            <h2>Ingredients</h2>
                            <ul>
								<?php while ( have_rows( 'ingredients' ) ): the_row(); ?>
                                    <li>
										<?php the_sub_field( 'ingredient' ); ?>
                                    </li>
								<?php endwhile; ?>
                            </ul>
                        </div>
					<?php endif; ?>

                    <div class="instructions singlePostContentGroup">
						<?php if ( have_rows( 'instructions' ) ) : ?>
                            <h2>Instructions</h2>
                            <ol>
								<?php while ( have_rows( 'instructions' ) ): the_row(); ?>
                                    <li>
										<?php the_sub_field( 'step' ); ?>
                                    </li>
								<?php endwhile; ?>
                            </ol>
						<?php endif; ?>

						<?php get_template_part( 'template-parts/author-footer' ); ?>

                    </div>
                </div>
            </div>
    </article>

<?php restore_current_blog();
if ( get_current_blog_id() === 1 && 1 === 2 ): ?>
    <div class="singlePostPreviousNext container">
		<?php
		$previousNextName = 'Recipe';
		include( locate_template( 'template-parts/previousNext.php' ) );
		?>
    </div>
<?php endif;
switch_to_blog( 1 ); ?>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Recipe",
      "author": "<?php the_author(); ?>",
      "cookTime": "<?php the_field( 'cook_time' ); ?>",
      "datePublished": "<?php if ( ! empty( get_the_date() ) ) {
			the_date();
		} ?>",
      "description": "<?php if ( ! empty( get_the_excerpt() ) ) {
			echo get_the_excerpt();
		} ?>",
      "image": "<?php echo $image[0]; ?>",
      "recipeIngredient": [
      <?php if ( have_rows( 'ingredients' ) ) {
			$rows            = get_field( 'ingredients' );
			$end_row         = end( $rows );
			$ingredient_last = $end_row['ingredient'];
			while ( have_rows( 'ingredients' ) ): the_row();

				if ( $ingredient_last === get_sub_field( 'ingredient' ) ) {
					echo '"' . get_sub_field( 'ingredient' ) . '"';
				} else {
					echo '"' . get_sub_field( 'ingredient' ) . '",';
				}
			endwhile;
		} ?>
      ],
      "nutrition": [
      <?php if ( have_rows( 'nutrition_facts' ) ) {
			$rows            = get_field( 'nutrition_facts' );
			$end_row         = end( $rows );
			$ingredient_last = $end_row['nutrition_fact'];
			while ( have_rows( 'nutrition_facts' ) ): the_row();

				if ( $ingredient_last === get_sub_field( 'nutrition_fact' ) ) {
					echo '"' . get_sub_field( 'nutrition_fact' ) . '"';
				} else {
					echo '"' . get_sub_field( 'nutrition_fact' ) . '",';
				}
			endwhile;
		} ?>
      ],
      "name": "<?php if ( ! empty( get_the_title() ) ) {
			the_title();
		} ?>",
      "prepTime": "<?php if ( get_field( 'prep_time' ) ) {
			the_field( 'prep_time' );
		} else {
			the_field( 'cook_time' );
		} ?>",
      "recipeYield": "<?php the_field( 'yield' ); ?>"
    }



    </script>

<?php
restore_current_blog();
//this one will work for corporate
$args = array(
	'posts_per_page' => 3,
	'post_type'      => 'recipe',
	'post__not_in'   => array( get_queried_object_id() ),
	'meta_query'     => array(
		array(
			'key'   => 'distribution_reach',
			'value' => '1'
		),
	),
);

//for childsites
if ( $childsite_id !== 1 ) {
	$args = array(
		'posts_per_page' => 3,
		'post_type'      => 'recipe',
		'post__not_in'   => array( get_queried_object_id() )
	);
}

$custom_query = new WP_Query( $args );
if ( $custom_query->have_posts() ):
	?>

    <aside class="singlePostRelated container">
        <h2 class="centerAlign">Related Recipes</h2>
        <div class="articleList">
			<?php
			while ( $custom_query->have_posts() ) :
				$custom_query->the_post();
				get_template_part( 'template-parts/category' );

				?>
                <article class="archiveListItem card card-underlineHover-brandGreen card-shadowHover">
                    <div class="articleImage">
                        <div class="image bg-image" style="background-image: url('<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail_url( 'archive-image-top' );
						} else {
							echo get_template_directory_uri() . '/images/placeholder.jpeg';
						}
						?>')"></div>
                        <a
							<?php if ( ! empty( get_the_title() ) ) : ?>
                                title="<?php the_title(); ?>"
							<?php endif; ?>
                                href="<?php echo $childsite_base_url . "/healthy-recipes/" . get_post_field( 'post_name', get_post() ); ?>">
                            <span class="invisible" aria-hidden="true"><?php the_title(); ?></span>
                        </a>
                    </div>
                    <div class="articlePreviewContent">
						<?php if ( ! empty( $category_name ) ): ?>
                            <div>
                                <span class="articleCategory borderText border-brandGreen"><?php echo $category_name; ?></span>
                            </div>
						<?php endif; ?>
						<?php if ( ! empty( get_the_title() ) ) : ?>
                            <h3 class="articleTitle">
                                <a title="<?php the_title(); ?>"
                                   href="<?php echo $childsite_base_url . "/healthy-recipes/" . get_post_field( 'post_name', get_post() ); ?>">
									<?php the_title(); ?>
                                </a>
                            </h3>
						<?php endif; ?>
                    </div>
                    <a class="articleLink link-leftDash"
						<?php if ( ! empty( get_the_title() ) ) : ?>
                            title="<?php the_title(); ?>"
						<?php endif; ?>
                       href="<?php echo $childsite_base_url . "/healthy-recipes/" . get_post_field( 'post_name', get_post() ); ?>">Read
                        More</a>
                </article>
			<?php endwhile; ?>
        </div>
    </aside>

<?php
endif;
if ( $switched ) {
	restore_current_blog();
}

get_footer();
