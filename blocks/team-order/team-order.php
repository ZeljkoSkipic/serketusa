<?php

$image = get_field('image');
$size = 'full';

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_thank-you';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
	<div class="st_ty_left">
		<h2 class="title-1"><?php echo wp_kses_post( get_field('ty_title') ); ?></h2>
		<div class="ty_text"><?php echo wp_kses_post( get_field('ty_text') ); ?></div>
		<?php get_template_part('components/buttons'); ?>
	</div>
	<div class="st_ty_right">
		<?php
		$image = get_field('image');
		$size = 'full';
		if( $image ) {
			echo wp_get_attachment_image( $image, $size, "", array( "class" => "image" ) );
		} ?>
	</div>
</div>
