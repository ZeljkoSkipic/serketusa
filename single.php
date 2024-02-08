<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package stier
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="c-wide"><span class="post_news_title title-1">News</span></div>
		<div class="post_content_wrap c-wide">
			<div class="post_main">
				<div class="post_intro"> <!-- Intro -->
					<?php
					the_post_thumbnail();
					the_title( '<h1 class="title-1">', '</h1>' ); ?>
					<time datetime="<?php echo get_the_date( 'Y-m-d G:i:s' ); ?>"><?php echo get_the_date(); ?></time>
				</div>

				<div class="post_content"> <!-- Main Content -->
					<?php
						the_content();
					?>
				</div>

				<div class="post_after_content"> <!-- Categories and Post Navigation -->
					<div class="left post_categories">
					<?php $categories = get_the_category();
						$separator = ' ';
						$output = '';
						if ( ! empty( $categories ) ) {
							foreach( $categories as $category ) {
								$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
							}
							echo trim( $output, $separator );
						} ?>
					</div>
					<?php the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous Post', 'stier' ),
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next Post', 'stier' ),
						)
					);
					?>
				</div>

				<div class="post_socials"> <!-- Comment count and Socials -->
					<div class="left comment_count">
						<a href="#post_comments"><?php get_template_part( 'template-parts/comment', 'count' ); ?></a>
					</div>
					<div class="right">
						socials
					</div>
				</div>

				<div class="post_related"> <!-- Related Posts -->
					<h2>Related News</h2>
					<div class="post_related_inner">
						<?php

						// Get the current post ID
						$current_post_id = get_the_ID();

						// Get the category terms of the current post
						$terms = get_the_terms($current_post_id, 'category');

						// If there are category terms
						if ($terms && !is_wp_error($terms)) {
							$category_ids = array();
							foreach ($terms as $term) {
								$category_ids[] = $term->term_id;
							}

							// Query related posts
							$args = array(
								'post_type' => 'post',
								'posts_per_page' => 3,
								'post__not_in' => array($current_post_id),
								'tax_query' => array(
									array(
										'taxonomy' => 'category',
										'field' => 'term_id',
										'terms' => $category_ids,
									),
								),
							);
							$related_posts = new WP_Query($args);

							// Display related posts
							if ($related_posts->have_posts()) {
								while ($related_posts->have_posts()) {
									$related_posts->the_post();
									?>
									<div class="related-post">
										<div class="post-thumbnail">
											<a href="<?php the_permalink(); ?>">
												<?php if (has_post_thumbnail()) { ?>
													<?php the_post_thumbnail('medium'); ?>
													<?php } else { ?>
													<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-image.jpg" alt="">
												<?php } ?>
											</a>
										</div>
										<h3 class="post-title">
											<a href="<?php the_permalink(); ?>">
												<?php the_title(); ?>
											</a>
										</h3>
										<p class="post-date"><?php the_date(); ?></p>
									</div>
									<?php
								}
							}

							// Restore original post data
							wp_reset_postdata();
						}
						?>
					</div>
				</div>

				<div class="post_comments" id="post_comments"> <!-- Comments -->
				<?php // If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>

	</main><!-- #main -->

<?php
get_footer();
