<?php

$bg_color = get_field('background_color');
$bg_img = get_field('background_image');
$bg_img_mob = get_field('background_image_mob');
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
<div class="block_bg" style="background-color: <?php echo $bg_color; ?>">
<?php
if( $bg_img ) {
    echo wp_get_attachment_image( $bg_img, $size, "",array( 'class' => 'desk_bg' ) );
}
if( $bg_img_mob ) {
    echo wp_get_attachment_image( $bg_img_mob, $size, "",array( 'class' => 'mob_bg' ) );
}

?>

</div>
	<InnerBlocks />
</div>
