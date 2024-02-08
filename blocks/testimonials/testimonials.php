<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_testimonials space_0_2';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
	<div class="c-wide">
		<?php get_template_part('components/intro'); ?>
	</div>
	<div class="st_testimonials_inner c-wide space_4_0">
		<?php

		if( have_rows('testimonials') ): ?>

			<?php while( have_rows('testimonials') ) : the_row(); ?>

				<?php
				$text = get_sub_field('text');
				$name = get_sub_field('name');
				$position = get_sub_field('position'); ?>
				<div class="st_testimonial">
					<div class="text">
						<?php echo $text; ?>
					</div>
					<span class="name"><?php echo $name; ?></span>
					<span class="position"><?php echo $position; ?></span>
				</div>
			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</div>
