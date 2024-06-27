<?php

// Enable WooCommerce
function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

add_filter('woocommerce_single_product_carousel_options', 'st_update_woo_flexslider_options');

// Single Product thumbnail navigation

function st_update_woo_flexslider_options($options)
{

    $options['directionNav'] = true;

    return $options;
}



// Remove default WooCommerce styles
add_filter('woocommerce_enqueue_styles', 'magik_dequeue_styles');
function magik_dequeue_styles($enqueue_styles)
{
    unset($enqueue_styles['woocommerce-general']);    // Remove the gloss
    unset($enqueue_styles['woocommerce-layout']);        // Remove the layout
    unset($enqueue_styles['woocommerce-smallscreen']);    // Remove the smallscreen optimisation
    return $enqueue_styles;
}

add_filter('woocommerce_subcategory_count_html', '__return_null');

// Remove HOME from WooCommerce breadcrumbs

add_filter('woocommerce_breadcrumb_defaults', function ($defaults) {
    unset($defaults['home']); //removes home link.
    return $defaults; //returns rest of links
});

// Change Woo Single Product images

function custom_wc_gallery_image_size($size)
{
    return array(
        'width'  => 215, // change this value to the desired width
        'height' => 265, // change this value to the desired height
        'crop'   => 0,   // set to 1 if you want to crop the image, 0 if you want to resize without cropping
    );
}
add_filter('woocommerce_get_image_size_gallery_thumbnail', 'custom_wc_gallery_image_size');


// WooCommerce Swatches

require get_template_directory() . '/includes/woocommerce/swatches.php';

// WooCommerce Quantity

require get_template_directory() . '/includes/woocommerce/quantity.php';

// Change Read More to View More

function custom_woocommerce_product_add_to_cart_text($text)
{

    if ('Read more' == $text) {
        $text = __('View More', 'woocommerce');
    }

    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text');

// Redirect non Military users to team order page

add_action('template_redirect', 'non_military_users_restrictions');

function non_military_users_restrictions()
{
    $theme_order_page = get_option('team_order_page');

    if (is_singular('product') && get_page_template_slug(get_the_ID()) == 'woocommerce/single-product-military.php' || is_tax('product_cat', 'ngb')) {
        if (is_user_logged_in()) {
            $user =  wp_get_current_user();
            $roles = (array) $user->roles;

            if (!in_array('administrator', $roles) && !in_array('military_customer', $roles)) {
                wp_safe_redirect($theme_order_page ? get_page_link($theme_order_page) : get_home_url(), 302);
            }
        } else {
            wp_safe_redirect($theme_order_page ? get_page_link($theme_order_page) : get_home_url(), 302);
        }
    }
}

// Add body classes to team order page


function body_classes_order_page($classes) {

    $theme_order_page = get_option('team_order_page');

    if((int) $theme_order_page == get_the_ID()) {
        $classes = array_merge( $classes, array( 'archive', 'theme-order-page'));
    }

    return $classes;
    
}

add_filter( 'body_class', 'body_classes_order_page');

// Unify variation display on cart and checkout

add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );


// Team order tab on my account

function st_has_user_role($check_role){
    $user = wp_get_current_user();
    if(in_array( $check_role, (array) $user->roles )){
		return true;
	}
    return false;
}

if(st_has_user_role('military_customer' || 'administrator')){

	// Adds custom dasboard link to a page
	add_filter ( 'woocommerce_account_menu_items', 'tunez_one_more_link' );
	function tunez_one_more_link( $menu_links ){

		// We will hook "sometext" later
		$new = array( 'team-order' => 'Team Order' );

		// Or in case you need 2 links
		// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

		// array_slice() is good when you want to add an element between the other ones
		$menu_links = array_slice( $menu_links, 0, 1, true )
		+ $new
		+ array_slice( $menu_links, 1, NULL, true );

		return $menu_links;
	}

	add_filter( 'woocommerce_get_endpoint_url', 'tunez_hook_endpoint', 10, 4 );
	function tunez_hook_endpoint( $url, $endpoint, $value, $permalink ){
		if( $endpoint === 'team-order' ) {
            $theme_order_page = get_option('team_order_page');
			// Here is the place for your custom URL, it could be external
			$url = get_page_link($theme_order_page);
		}
		return $url;
	}

}


