<?php
$page_title = get_field('page_title');
$intro_text = get_field('intro_text');
?>

<header class="page-header space_4">
	<?php
	$archive_hero_background = get_field('archive_hero_background', 'option');
	$size = 'full';
	if( $archive_hero_background ) {
		echo wp_get_attachment_image( $archive_hero_background, $size, "", array( "class" => "archive_hero_background" ) );
	} ?>
	<div class="c-narrow">
		<h1 class="page-title">
			<?php if($page_title) {
				echo $page_title;
			} else {
				the_title();
			} ?>
		</h1>
		<?php if($intro_text) { ?>
			<div class="page-header-description">
				<?php echo $intro_text; ?>
			</div>
		<?php } ?>
	</div>
</header>
