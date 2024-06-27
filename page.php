<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package stier
 */

get_header();
$theme_order_page = get_option('team_order_page');
if( (int) $theme_order_page == get_the_ID()):
	get_template_part('template-parts/theme-order-page');
else: 
	?>
	<main id="primary" class="site-main">
		<?php the_content(); ?>
	</main><!-- #main -->

	<?php

endif;
get_footer();
