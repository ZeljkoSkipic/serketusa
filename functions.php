<?php
/**
 * stier functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package stier
 */


// Sets up theme defaults and registers support for various WordPress features.


function stier_setup() {

	// Make theme available for translation.

	load_theme_textdomain( 'stier', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.

	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'main' => esc_html__( 'Primary', 'stier' ),
			'apparel' => esc_html__( 'Apparel', 'stier' ),
			'equipment' => esc_html__( 'Equipment', 'stier' ),
			'about' => esc_html__( 'About', 'stier' ),
			)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for core custom logo.

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 83,
			'width'       => 224,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'stier_setup' );


// Enqueue scripts and styles.

function stier_scripts() {
	$css_cache_buster = date("YmdHi", filemtime( get_stylesheet_directory() . '/assets/dist/theme.css'));
	$js_cache_buster = date("YmdHi", filemtime( get_stylesheet_directory() . '/assets/dist/theme.js'));

	wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/assets/dist/theme.min.css', array(), $css_cache_buster, 'all' );
	wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/assets/dist/theme.js', array('jquery'), $js_cache_buster );

	wp_enqueue_style( 'stier-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'stier_scripts' );

// Login Styles
function stier_login_styles() {
    wp_enqueue_style( 'login-style', get_template_directory_uri() . '/assets/dist/wp-login.css' );
}
add_action('login_head', 'stier_login_styles');

// Admin Styles
function stier_admin_styles() {
	wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/assets/dist/admin.min.css' );
}
add_action( 'admin_enqueue_scripts', 'stier_admin_styles' );

// Custom template tags for this theme.

require get_template_directory() . '/includes/template-tags.php';

// Functions which enhance the theme by hooking into WordPress.

require get_template_directory() . '/includes/template-functions.php';

// Customizer additions.

require get_template_directory() . '/includes/customizer.php';

// WooCommerce functions

require get_template_directory() . '/includes/woocommerce.php';

// WooCommerce Military Form

require get_template_directory() . '/includes/register/index.php';

/* Remove Downloads */

add_filter('woocommerce_account_menu_items', 'remove_my_account_tabs', 999);

function remove_my_account_tabs($items) {
    unset($items['downloads']);
    return $items;
}

// Remove URL from Comment form

add_filter('comment_form_default_fields', 'website_remove');
	function website_remove($fields)
	{
	if(isset($fields['url']))
	unset($fields['url']);
	return $fields;
}

// Change Leave a Reply text
function stier_comment_form_title_reply( $defaults ) {
	$defaults['title_reply'] = __( 'Post Comment' );
	return $defaults;
	}
add_filter( 'comment_form_defaults', 'stier_comment_form_title_reply' );



// Comment Form Placeholder Author, Email, URL

function placeholder_author_email_url_form_fields( $fields ) {
	foreach( $fields as &$field ) {
	  $field = str_replace( 'id="author"', 'id="author" placeholder="Full Name*"', $field );
	  $field = str_replace( 'id="email"', 'id="email" placeholder="Your Email*"', $field );
	}
	return $fields;
  }
  add_filter( 'comment_form_default_fields', 'placeholder_author_email_url_form_fields' );
/**
 * Comment Form Placeholder Comment Field
 */
function placeholder_comment_form_field($fields) {
    $replace_comment = __("Add your comments here", 'stier');

    $fields['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
    '</label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.$replace_comment.'" aria-required="true"></textarea></p>';

    return $fields;
 }
add_filter( 'comment_form_defaults', 'placeholder_comment_form_field' );
