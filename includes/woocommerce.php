<?php

// Enable WooCommerce
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

add_filter( 'woocommerce_single_product_carousel_options', 'st_update_woo_flexslider_options' );

// Single Product thumbnail navigation

function st_update_woo_flexslider_options( $options ) {

    $options['directionNav'] = true;

    return $options;
}



// Remove default WooCommerce styles
add_filter( 'woocommerce_enqueue_styles', 'magik_dequeue_styles' );
function magik_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}

add_filter( 'woocommerce_subcategory_count_html', '__return_null' );

// Remove HOME from WooCommerce breadcrumbs

add_filter('woocommerce_breadcrumb_defaults', function( $defaults ) {
    unset($defaults['home']); //removes home link.
    return $defaults; //returns rest of links
});

// Change Woo Single Product images

function custom_wc_gallery_image_size( $size ) {
    return array(
        'width'  => 215, // change this value to the desired width
        'height' => 265, // change this value to the desired height
        'crop'   => 0,   // set to 1 if you want to crop the image, 0 if you want to resize without cropping
    );
}
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'custom_wc_gallery_image_size' );


// WooCommerce Swatches

require get_template_directory() . '/includes/woocommerce/swatches.php';

// WooCommerce Quantity

require get_template_directory() . '/includes/woocommerce/quantity.php';

// Change Read More to View More

function custom_woocommerce_product_add_to_cart_text( $text ) {

    if( 'Read more' == $text ) {
        $text = __( 'View More', 'woocommerce' );
    }

    return $text;

}
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
