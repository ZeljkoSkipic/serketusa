<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_mission space_0_2';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
	<div class="st_mission_inner">
		<div class="st_mission_left">
			<?php
			$image = get_field('image');
			$size = 'full';
			if( $image ) {
				echo wp_get_attachment_image( $image, $size, "", array( "class" => "image" ) );
			} ?>
		</div>
		<div class="st_mission_right body-1">
			<?php get_template_part('components/intro'); ?>
			<div class="intro_text body-2"><?php echo wp_kses_post( get_field('text') ); ?></div>
			<?php get_template_part('components/buttons'); ?>
		</div>

	</div>
</div>
