<?php

get_header();
?>

	<main id="primary" class="site-main">
		<?php the_content(); ?>
		<div class="error_404 c-narrow">
			<div class="error_inner">
				<div class="left">
					<?php
					$error_image = get_field('error_image', 'option');
					$size = 'full';
					if( $error_image ) {
						echo wp_get_attachment_image( $error_image, $size, "", array( "class" => "error_image" ) );
					} ?>
				</div>
				<div class="right">
					<h1><?php echo wp_kses_post( get_field('error_title', 'option') ); ?></h1>
					<div class="error_text"><?php echo wp_kses_post( get_field('error_text', 'option') ); ?></div>

				</div>
			</div>
		</div>

	</main><!-- #main -->

<?php
get_footer();
