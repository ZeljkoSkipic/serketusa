<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_counters space_0_3';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
	<div class="st_counters_inner c-narrow">
		<?php

		if( have_rows('counters') ): ?>

			<?php while( have_rows('counters') ) : the_row(); ?>
			<?php
			$number = get_sub_field('number');
			$title = get_sub_field('title'); ?>
				<div class="st_counter">
					<h4 class="counter_number title-2"><?php echo $number; ?></h4>
					<p class="counter_text body-2"><?php echo $title; ?></p>
				</div>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>
</div>
