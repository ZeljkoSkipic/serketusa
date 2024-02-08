<?php

$title = get_field('title');
$tag = get_field('heading_tag');

if( $title ) { ?>
<<?php echo esc_html($tag); ?> class="intro_title title-1"><?php echo $title; ?></<?php echo esc_html($tag); ?>>
<?php }
