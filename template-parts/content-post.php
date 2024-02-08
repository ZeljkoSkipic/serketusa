<?php
$title = get_the_title();
$image = get_the_post_thumbnail(get_the_id(), 'large');
$excerpt = get_the_excerpt();


?>

<div class="grid_item">
    <figure class="gi_image">
        <?php if ($image) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php echo $image; ?>
            </a>
        <?php endif; ?>
	</figure>

    <?php if ($title) : ?>
		<h2 class="heading-secondary">
			<a href="<?php the_permalink(); ?>"><?php echo $title; ?></a>
		</h2>
    <?php endif; ?>
    <?php if ($excerpt) :
         if (strlen($excerpt) <= 100){
            // Outputs the whole post content
           $trimmed_excerpt = $excerpt;
        }else{
            $trimmed_excerpt = substr($excerpt, 0, strpos($excerpt, ' ', 60));
            $trimmed_excerpt.="...";
        }

          $single_url = "<a class='post-link' href='".get_the_permalink()."'>".__('see more.')." </a>";
          $excerpt = sprintf("%s %s", $trimmed_excerpt, $single_url );
          ?>
        <div class="entry-content"> <?php echo $excerpt;  ?> </div>
    <?php endif; ?>

</div>
