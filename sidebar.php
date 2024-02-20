<aside>
<?php // Categories
// Fetch all categories for 'post' post type
$uncategorized = get_category_by_slug('uncategorized');
$categories = get_categories( array(
	'orderby' => 'name',
	'order'   => 'ASC',
	'exclude' => (!empty($uncategorized) ? $uncategorized->term_id : ''), // Exclude 'Uncategorized' by ID
	'taxonomy' => 'category' // Default taxonomy for 'post' is 'category'
) );

// Check if categories exist and display them
if ( !empty( $categories ) ) { ?>
	<div class="sidebar_item item_w_bg">
		<h2 class="title-2">Categories</h2>
		<ul>
			<?php foreach ( $categories as $category ) {
				echo '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
			} ?>
		</ul>
	</div>
<?php } else {
	echo 'No categories found.';
}
?>

<?php // Top Posts
	$args = array(
	'post_type'      => 'post', // Only fetch blog posts.
	'posts_per_page' => 5,      // Retrieve top 5 posts.
	'meta_key'       => 'post_views_count',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
	'post_status'    => 'publish',
);

$top_posts_query = new WP_Query($args);

if ($top_posts_query->have_posts()) { ?>
	<div class="sidebar_item item_w_bg top_posts">
	<h2 class="title-2">Top Posts</h2>
	<?php echo '<ul>';
	while ($top_posts_query->have_posts()) {
		$top_posts_query->the_post();
		// Display the position number and the title
		echo '<li>' . '<a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
	}
	echo '</ul>';
	wp_reset_postdata(); ?>
	</div>
<?php } else {
	echo 'No posts found.';
} ?>

</aside>
