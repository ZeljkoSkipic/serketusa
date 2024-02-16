<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}
$class = 'st_block st_latest-posts space_3';
if ( ! empty( $block['className'] ) ) {
	$class .= ' ' . $block['className'];
}

?>
<div id="<?php echo $anchor; ?>" class="<?php echo $class ?>">
	<div class="c-wide">
		<?php get_template_part('components/intro'); ?>
	</div>
	<div class="st_latest-posts_inner c-wide space_4_0">
	<?php

		// Query to fetch latest 3 blog posts
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'orderby' => 'date',
			'order' => 'DESC',
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$category = get_the_category();
				$title = get_the_title();
				$post_link = get_the_permalink();
				$excerpt = wp_trim_words( get_the_content(), 20, '...' ); ?>

				<div class="latest_post">
					<a href="<?php echo $post_link; ?>">
						<?php the_post_thumbnail();	?>
					</a>
					<div class="lp_content">
						<?php
						echo '<span class="lp_category">' . $category[0]->name . '</span>'; ?>

							<h3 class="title-2"><a href="<?php echo $post_link; ?>"><?php the_title(); ?></a></h3>

						<?php echo '<p>' . esc_html( $excerpt ) . '</p>'; ?>
						<a class="lp_read_more" href="<?php echo $post_link; ?>">Read More</a>
					</div>
				</div>

			<?php }
			wp_reset_postdata();
		} ?>

	</div>
	<div class="btns">
		<a href="<?php echo esc_url(get_post_type_archive_link( 'post' )); ?>" class="btn-2">View all news</a>
	</div>
</div>
