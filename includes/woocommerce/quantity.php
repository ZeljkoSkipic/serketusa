<?php

add_action( 'woocommerce_before_quantity_input_field', 'woo_quantity_minus' );

function woo_quantity_minus() {
   if ( ! is_product() && !is_cart() ) return;
   echo '<button type="button" class="minus" >-</button>';
}

add_action( 'woocommerce_after_quantity_input_field', 'woo_quantity_plus' );

function woo_quantity_plus() {
   if ( ! is_product() && !is_cart() ) return;
   echo '<button type="button" class="plus" >+</button>';
}
