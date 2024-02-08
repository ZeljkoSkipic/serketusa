<?php
$btn1 = get_field('button_1');
$btn2 = get_field('button_2');
$btn3 = get_field('button_3');


if( !empty($btn1 || $btn2 || $btn3 ) ) { ?>

<div class="btns">
<?php
if( $btn1 ):
	$btn1_url = $btn1['url'];
	$btn1_title = $btn1['title'];
	$btn1_target = $btn1['target'] ? $btn1['target'] : '_self';
	?>
	<a class="btn btn-1" href="<?php echo esc_url( $btn1_url ); ?>" target="<?php echo esc_attr( $btn1_target ); ?>"><?php echo esc_html( $btn1_title ); ?></a>
<?php endif; ?>
<?php
if( $btn2 ):
	$btn2_url = $btn2['url'];
	$btn2_title = $btn2['title'];
	$btn2_target = $btn2['target'] ? $btn2['target'] : '_self';
	?>
	<a class="btn btn-2" href="<?php echo esc_url( $btn2_url ); ?>" target="<?php echo esc_attr( $btn2_target ); ?>"><?php echo esc_html( $btn2_title ); ?></a>
<?php endif; ?>
<?php
if( $btn3 ):
	$btn3_url = $btn3['url'];
	$btn3_title = $btn3['title'];
	$btn3_target = $btn3['target'] ? $btn3['target'] : '_self';
	?>
	<a class="btn btn-3" href="<?php echo esc_url( $btn3_url ); ?>" target="<?php echo esc_attr( $btn3_target ); ?>"><?php echo esc_html( $btn3_title ); ?></a>
<?php endif; ?>
</div>

<?php }

?>
