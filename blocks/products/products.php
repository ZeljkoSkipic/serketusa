<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_products space_2_3 c-wide';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
	<div class="st_products_inner">
		<div class="st_products_intro">
			<?php get_template_part('components/intro'); ?>
			<?php

			if( have_rows('cards') ): ?>
				<div class="product_cards">
					<?php while( have_rows('cards') ) : the_row(); ?>

						<div class="product_card">
							<?php
							$card_icon = get_sub_field('card_icon');
							$card_title = get_sub_field('card_title'); ?>
							<?php
							$size = 'full';
							if( $card_icon ) {
								echo wp_get_attachment_image( $card_icon, $size, "", array( "class" => "card_icon" ) );
							} ?>
							<h4 class="card_title"><?php echo $card_title; ?></h4>
						</div>

					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="st_block_products">
			<?php
			$product_left = get_field('product_left');
			if( $product_left ): ?>
				<div class="st_product_left">
					<img src="<?php echo esc_url( $product_left['background_image']['url'] ); ?>" class="block_bg background_image" alt="<?php echo esc_attr( $product_left['background_image']['alt'] ); ?>" />
					<div class="st_product_inner">
						<img src="<?php echo esc_url( $product_left['icon']['url'] ); ?>" class="icon" alt="<?php echo esc_attr( $product_left['icon']['alt'] ); ?>" />
						<h3 class="st_block_product_title"><?php echo $product_left['title']; ?></h3>
						<a class="btn-3" href="<?php echo esc_url( $product_left['link_and_text']['url'] ); ?>"><?php echo esc_html( $product_left['link_and_text']['title'] ); ?></a>
					</div>
				</div>
			<?php endif; ?>

			<?php
			$product_right = get_field('product_right');
			if( $product_right ): ?>
				<div class="st_product_right">
					<img src="<?php echo esc_url( $product_right['background_image']['url'] ); ?>" class="block_bg background_image" alt="<?php echo esc_attr( $product_left['background_image']['alt'] ); ?>" />
					<div class="st_product_inner">
						<img src="<?php echo esc_url( $product_right['icon']['url'] ); ?>" class="icon" alt="<?php echo esc_attr( $product_right['icon']['alt'] ); ?>" />
						<h3 class="st_block_product_title"><?php echo $product_right['title']; ?></h3>
						<a class="btn-3" href="<?php echo esc_url( $product_right['link_and_text']['url'] ); ?>"><?php echo esc_html( $product_right['link_and_text']['title'] ); ?></a>
					</div>
				</div>
			<?php endif; ?>
		</div>

	</div>
</div>
