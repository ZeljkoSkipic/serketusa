<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_arrival';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">

	<?php

	if( have_rows('slider') ): ?>
		<div class="st_arrival_inner main-carousel">

		<?php while( have_rows('slider') ) : the_row(); ?>

			<?php
			$prefix = get_sub_field('prefix');
			$title = get_sub_field('title');
			$arrival_background = get_sub_field('arrival_background');
			$size = 'full';
			$style = get_sub_field('button_style');
			$layout = get_sub_field('text_and_button_position');
			?>
			<div class="carousel-cell">
			<div class="block_bg">
				<?php if( $arrival_background ) {
				echo wp_get_attachment_image( $arrival_background, $size, "", array( "class" => "arrival_background" ) );
			} ?>
			</div>
				<div class="carousel-cell_inner space_1_2">
					<div class="st_arrival_content <?php echo esc_attr($layout); ?>">
						<h4 class="prefix"><?php echo $prefix; ?></h4>
						<h2 class="arrival_title" style="color: <?php echo wp_kses_post( get_sub_field('title_color') ); ?>"><?php echo $title; ?></h2>
						<?php
						$button_text_and_link = get_sub_field('button_text_and_link');
						if( $button_text_and_link ):
							$button_text_and_link_url = $button_text_and_link['url'];
							$button_text_and_link_title = $button_text_and_link['title'];
							$button_text_and_link_target = $button_text_and_link['target'] ? $button_text_and_link['target'] : '_self';
							?>
							<a class="<?php echo esc_attr($style); ?>" href="<?php echo esc_url( $button_text_and_link_url ); ?>" target="<?php echo esc_attr( $button_text_and_link_target ); ?>"><?php echo esc_html( $button_text_and_link_title ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div>

	<?php endif; ?>


</div>
