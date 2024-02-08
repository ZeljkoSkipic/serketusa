<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_arrival space_1_2';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
<?php get_template_part('components/background'); ?>
	<div class="st_arrival_inner c-narrow">
		<div class="st_arrival_content">
			<?php get_template_part('components/intro'); ?>
			<?php get_template_part('components/buttons'); ?>
		</div>

	</div>
</div>
