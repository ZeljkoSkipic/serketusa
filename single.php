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
						<ul class="st_share">
							<li>
								<a href="http://www.facebook.com/sharer.php?u=<?php echo  get_permalink() ?>">
									<svg xmlns="http://www.w3.org/2000/svg" width="15.378" height="28.745" viewBox="0 0 15.378 28.745">
										<path id="Path_23" data-name="Path 23" d="M4.683,28.745h5.569V15.9h4.113l.823-5.189H10.252V6.786a2.5,2.5,0,0,1,2.721-2.278h2.4V.2l-4.3-.19C6.961-.239,4.683,2.989,4.683,6.849v3.86H0V15.9H4.683Z" fill-rule="evenodd"/>
									</svg>
								</a>
							</li>
							<li>
								<a href="http://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="25.279" height="20.531" viewBox="0 0 25.279 20.531">
									<path id="Path_26" data-name="Path 26" d="M1267.107,43.75a5.317,5.317,0,0,1,9.119-4.627,13.426,13.426,0,0,0,3.151-1.408,5.8,5.8,0,0,1-2.347,2.95,9.993,9.993,0,0,0,2.883-.8,5.6,5.6,0,0,1-2.481,2.481c.872,12.137-12.2,19.513-22.8,13.478,0,0,5.23.268,7.443-2.28,0,0-3.219.268-4.828-3.621a3.234,3.234,0,0,0,2.414-.134,5.234,5.234,0,0,1-4.09-5.1,3.3,3.3,0,0,0,2.548.6,5.144,5.144,0,0,1-1.811-6.973s4.426,5.632,10.8,5.431" transform="translate(-1254.635 -37.436)" fill-rule="evenodd"/>
								</svg>
								</a>
							</li>
							<li>
								<a href="https://linkedin.com/shareArticle?url=<?php echo get_permalink(); ?>/&title=<?php echo get_the_title(); ?>" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" width="23.156" height="23.271" viewBox="0 0 23.156 23.271">
									<path id="Path_25" data-name="Path 25" d="M1908.258,627.339h4.6v15.438h-4.6Zm2.27-7.832a2.781,2.781,0,1,1,0,5.562,2.782,2.782,0,0,1,0-5.562m5.051,7.832h4.54V629.5a5.253,5.253,0,0,1,4.37-2.327h1.249a5.244,5.244,0,0,1,5.221,5.222v10.386h-4.54v-8.343a3.018,3.018,0,0,0-3.008-3.121,3.261,3.261,0,0,0-3.292,3.121v8.343h-4.54Z" transform="translate(-1907.804 -619.507)" fill-rule="evenodd"/>
								</svg>
								</a>
							</li>
							<li>
								<a class="sh_cl_btn" id="btn">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
									<span class="result"></span>
								</a>
							</li>
						</ul>
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
