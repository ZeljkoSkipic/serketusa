<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_video_hero';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
	<video width="960" height="540" autoplay="autoplay" muted playsinline loop>
		<source src="<?php the_field('hero_video');?>" type="video/mp4" >
	</video>
</div>
