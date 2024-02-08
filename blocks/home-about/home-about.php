<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_about space_1_3';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
<?php get_template_part('components/background'); ?>
	<div class="st_about_inner c-narrow">
		<div class="st_about_left">
			<?php get_template_part('components/intro'); ?>
		</div>
		<div class="st_about_right body-1">
			<?php the_field('text'); ?>
			<?php get_template_part('components/buttons'); ?>
		</div>

	</div>
</div>
