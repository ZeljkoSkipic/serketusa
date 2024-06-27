<?php

$bg_color = get_field('background_color');
$bg_img = get_field('background_image');
$size = 'full';

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_background-wrapper';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
<div class="block_bg" style="background-image: url(<?php echo $bg_img; ?>); background-color: <?php echo $bg_color; ?>">
</div>
	<InnerBlocks />
</div>
