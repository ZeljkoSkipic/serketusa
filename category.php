<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package s-tier
 */

get_header();
?>

	<div id="primary" class="site-main">
	<header class="page-header space_4">
		<?php
		$archive_hero_background = get_field('archive_hero_background', 'option');
		$size = 'full';
		if( $archive_hero_background ) {
			echo wp_get_attachment_image( $archive_hero_background, $size, "", array( "class" => "archive_hero_background" ) );
		} ?>
		<div class="c-narrow">
			<h1 class="page-title"><?php  single_cat_title() ; ?></h1>
			<div class="page-header-description">
				<?php the_archive_description(); ?>
			</div>

		</div>
	</header>

			<div class="archive_container c-wide space_4">

				<?php
				if ( have_posts() ) : ?>
					<main class="archive_posts">

						<div class="posts_grid">
							<?php while ( have_posts() ) :
								the_post();

								// Get the categories

								$post_link = get_permalink();

								$categories = get_the_category();
								$excluded_category = get_category_by_slug('uncategorized');
								$categories = array_filter($categories, function ($category) use ($excluded_category) {
									return $category->slug !== $excluded_category->slug;
								});  ?>

								<article class="archive_post">
									<figure>
										<a href="<?php echo $post_link ?>">
											<?php the_post_thumbnail(get_the_ID(), 'large'); ?>
										</a>
									</figure>
									<?php if($categories): ?>
										<div class="post_categories">
										<?php foreach ($categories as $category) {
											echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a> ';
										} ?>
										</div>
									<?php endif; ?>
									<h2 class="title-2">
										<a href="<?php echo $post_link ?>">
											<?php the_title(); ?>
										</a>
									</h2>
									<div class="post_excerpt">
										<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
									</div>
									<div class="post_meta">
										<?php the_date( '', '<span class="post_date">', '</span>');?>
										<span class="post_comments"><?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></span>
									</div>
								</article>

								<?php endwhile; ?>

						</div>
						<?php the_posts_pagination(); ?>
					</main>
					<?php get_sidebar(); ?>
				<?php endif; ?>
			</div>

		</div><!-- #primary -->

<?php
get_footer();
