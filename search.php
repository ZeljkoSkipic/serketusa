
<?php

get_header();
?>

	<main id="primary" class="site-main search_results_main">
		<header class="c-wide">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'serket' ), '<span>"' . get_search_query() . '"</span>' );
				?>
			</h1>
		</header>
		<div class="search_results space_0_2 c-wide">
			<div class="search_results_main">

			<?php
				 $product_args = array(
					'post_type'      => 'product',
					'posts_per_page' => 10,
					's'              => get_search_query(),
					'post_status'    => 'publish',
				);

				$post_args = array(
					'post_type'      => 'post',
					'posts_per_page' => 10,
					's'              => get_search_query(),
					'post_status'    => 'publish',
				);

				$product_query = new WP_Query( $product_args );
				$post_query = new WP_Query( $post_args );

				?>


				<?php if ( $product_query->have_posts() ) : ?>

					<section class="search_results_products">
					<p class="number-of-results">
						<?php
						printf(
							_n(
								'<strong>%s</strong> Product.',
								'<strong>%s</strong> Products.',
								$product_query->found_posts,
								'stier'
							),
							number_format_i18n( $product_query->found_posts )
						);
						?>
					</p>
					<div class="products columns-4">
						<?php
						// Start the Loop
						while ( $product_query->have_posts() ) : $product_query->the_post();

							// You can use your own template part or content structure here ?>

							<div class="product">
							<a href="<?php the_permalink(); ?>">
								<figure>
									<?php the_post_thumbnail(); ?>
								</figure>
								<h2 class="woocommerce-loop-product__title">
									<?php the_title(); ?>
								</h2>
							</a>
							</div>

						<?php endwhile; ?>
					</div>
					</section><!-- .search-results -->

				 <?php endif;

				?>


				<!-- Query for 'post' post type -->
				<?php
					$post_args = array(
						'post_type'      => 'post',
						'posts_per_page' => 10,
						's'              => get_search_query(),
						'post_status'    => 'publish',
					);

					$post_query = new WP_Query( $post_args ); ?>

					<?php if ( $post_query->have_posts() ) : ?>

						<section class="search-results-posts">
							<p class="number-of-results">
							<?php
							printf(
								_n(
									'<strong>%s</strong> Blog Post',
									'<strong>%s</strong> Blog Posts.',
									$post_query->found_posts,
									'stier'
								),
								number_format_i18n( $post_query->found_posts )
							);
							?>
						</p>
							<?php
							while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
								<article>
									<h2><a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h2>
									<div class="sr_meta">
										<span class="author"><?php echo esc_html__( 'By:', 'stier' ) . ' ' . get_the_author(); ?></span>
										<span class="date-published"><?php echo esc_html__( '|', 'stier' ) . ' ' . get_the_date(); ?></span>
									</div>
									<div class="entry-summary">
										<?php
										if ( has_excerpt() ) {
											the_excerpt();
										} else {
											echo wp_trim_words( get_the_content(), 30, '...' );
										}
										?>
									</div>
								</article>
							<?php endwhile; ?>

						</section>



					<?php endif; ?>

					<?php if ( !$product_query->have_posts() && !$post_query->have_posts() ) : ?>
						<div class="no-results">
							<h2>0 results</h2>
							<p>Your search for "<?php the_search_query(); ?>" did not yield any results.</p>
						</div>
					<?php endif; ?>

					<?php wp_reset_postdata(); ?>

			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
