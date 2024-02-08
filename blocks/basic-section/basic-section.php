<?php

$layout = get_field_object('layout');
$stack = get_field_object('stack');
$image_options = get_field('image_options');

$class = 'st_block basic_sec space_4';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}

$sec_in_class = 'basic_sec_inner c-wide';
if ( ! empty( $layout ) ) {
    $sec_in_class .=  ' ' . $layout['value'];
}
if ( ! empty( $stack ) ) {
    $sec_in_class .=  ' ' . $stack['value'];
}


?>


<!-- Basic Section -->
<section class="<?php echo $class; ?>">
	<div class="<?php echo $sec_in_class; ?>">

		<div class="left">
			<h2 class="title-1 t_space_2"><?php echo wp_kses_post( get_field('basic_title') ); ?></h2>
			<div>
				<?php echo wp_kses_post( get_field('text') ); ?>
			</div>
		</div>
		<div class="right">
			<?php
			$image = get_field('image');
			$size = 'full';
			if( $image ) {
				echo wp_get_attachment_image( $image, $size, "", array( "class" => "image" ) );
			} ?>
		</div>
	</div>
</section>
