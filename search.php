
<?php

get_header();
?>

	<main id="primary" class="site-main search_results_main">
		<header class="c-wide">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'serket' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header>
		<div class="search_results c-wide">
			<aside class="search_categories">
				<p class="search_results_sidebar_title">Category</p>
				<ul class="search_results_sidebar_categories">
					<li class="category">
						<label for="term-1">
							<input id="term-1" type="checkbox">
							<span class="product_name">Category Name</span>
							<span class="product_count">8</span>
						</label>
					</li>
					<li class="category">
						<label for="term-2">
							<input id="term-2" type="checkbox">
							<span class="product_name">Category Name</span>
							<span class="product_count">5</span>
						</label>
					</li>
					<li class="category">
						<label for="term-3">
							<input id="term-3" type="checkbox">
							<span class="product_name">Category Name</span>
							<span class="product_count">12</span>
						</label>
					</li>

				</ul>
			</aside>
			<div class="search_results_main">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<div class="search_results_products">
				<div class="sr_product">
					<figure>
						<img src="/wp-content/uploads/2024/01/apparel-home-background.jpg" alt="">
					</figure>
					<h2>Flame Resistant Short Sleeve T-Shirt</h2>
				</div>
				<div class="sr_product">
					<figure>
						<img src="/wp-content/uploads/2024/01/apparel-home-background.jpg" alt="">
					</figure>
					<h2>Flame Resistant Short Sleeve T-Shirt</h2>
				</div>
				<div class="sr_product">
					<figure>
						<img src="/wp-content/uploads/2024/01/apparel-home-background.jpg" alt="">
					</figure>
					<h2>Flame Resistant Short Sleeve T-Shirt</h2>
				</div>
				<div class="sr_product">
					<figure>
						<img src="/wp-content/uploads/2024/01/apparel-home-background.jpg" alt="">
					</figure>
					<h2>Flame Resistant Short Sleeve T-Shirt</h2>
				</div>
				<div class="sr_product">
					<figure>
						<img src="/wp-content/uploads/2024/01/apparel-home-background.jpg" alt="">
					</figure>
					<h2>Flame Resistant Short Sleeve T-Shirt</h2>
				</div>
				<div class="sr_product">
					<figure>
						<img src="/wp-content/uploads/2024/01/apparel-home-background.jpg" alt="">
					</figure>
					<h2>Flame Resistant Short Sleeve T-Shirt</h2>
				</div>
			</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
