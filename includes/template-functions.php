<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package stier
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

function stier_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	return $classes;
}
add_filter( 'body_class', 'stier_body_classes' );

// Add a pingback url auto-discovery header for single posts, pages, or attachments.

function stier_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'stier_pingback_header' );


// Admin footer modification

function dashboard_footer_admin ()
{
    echo '<span id="footer-thankyou">Thank you for developing with <a href="https://stierdev.com/" target="_blank">S Tier Dev</a>. Powered by <a href="https://wordpress.org/" target="_blank">WordPress</a>.</span> ';
}

add_filter('admin_footer_text', 'dashboard_footer_admin');

// ACF Local JSON

function my_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_load_point( $paths ) {

    // Append the new path and return it.
    $paths = get_stylesheet_directory() . '/acf-json';

    return $paths;
}
add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );


// Settings pages

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Website Settings',
        'menu_title'    => 'Site Settings',
        'menu_slug'     => 'site-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
		'position' => '2.69',
		'icon_url'          => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIHZlcnNpb249IjEuMSI+CjxnIGlkPSJzdXJmYWNlMSI+CjxwYXRoIHN0eWxlPSIgc3Ryb2tlOm5vbmU7ZmlsbC1ydWxlOm5vbnplcm87ZmlsbDpyZ2IoMCUsMCUsMCUpO2ZpbGwtb3BhY2l0eToxOyIgZD0iTSAxLjU4MjAzMSA2LjE3OTY4OCBMIDEuNTgyMDMxIDEwLjc3MzQzOCBMIDEuNzIyNjU2IDEwLjc2NTYyNSBMIDEuODU5Mzc1IDEwLjc1MzkwNiBMIDEuODcxMDk0IDYuMzEyNSBMIDEuODc4OTA2IDEuODc4OTA2IEwgMTAuODA0Njg4IDEuODc4OTA2IEwgMTAuODA0Njg4IDEuNTgyMDMxIEwgMS41ODIwMzEgMS41ODIwMzEgWiBNIDEuNTgyMDMxIDYuMTc5Njg4ICIvPgo8cGF0aCBzdHlsZT0iIHN0cm9rZTpub25lO2ZpbGwtcnVsZTpub256ZXJvO2ZpbGw6cmdiKDAlLDAlLDAlKTtmaWxsLW9wYWNpdHk6MTsiIGQ9Ik0gOS40ODQzNzUgNC42MTMyODEgQyA4LjI0NjA5NCA0LjczNDM3NSA3LjM0Mzc1IDUuMjEwOTM4IDYuODIwMzEyIDYuMDIzNDM4IEMgNi4zMzU5MzggNi43ODkwNjIgNi4zMzU5MzggOC4wODU5MzggNi44MjAzMTIgOC45MTc5NjkgQyA2Ljk3NjU2MiA5LjE4MzU5NCA3LjQxMDE1NiA5LjYwOTM3NSA3LjcxODc1IDkuODAwNzgxIEMgOC4wOTc2NTYgMTAuMDMxMjUgOC42NTIzNDQgMTAuMjYxNzE5IDkuNjgzNTk0IDEwLjYwMTU2MiBDIDExLjEyMTA5NCAxMS4wODIwMzEgMTEuNTM5MDYyIDExLjMxNjQwNiAxMS43NjU2MjUgMTEuNzg1MTU2IEMgMTEuODcxMDk0IDExLjk5NjA5NCAxMS44NzUgMTIuMDE1NjI1IDExLjg3NSAxMi40MTc5NjkgQyAxMS44NzUgMTIuOTAyMzQ0IDExLjgyNDIxOSAxMy4xMDE1NjIgMTEuNjM2NzE5IDEzLjM3MTA5NCBDIDExLjM5MDYyNSAxMy43MTg3NSAxMC45NTMxMjUgMTMuOTI5Njg4IDEwLjMwODU5NCAxNCBDIDEwLjExNzE4OCAxNC4wMjM0MzggOS44Mzk4NDQgMTQuMDI3MzQ0IDkuNjgzNTk0IDE0LjAxNTYyNSBDIDguOTIxODc1IDEzLjk1NzAzMSA3Ljk3NjU2MiAxMy42MjUgNy4zMzk4NDQgMTMuMTk5MjE5IEwgNy4xMTcxODggMTMuMDU0Njg4IEwgNi43NTM5MDYgMTMuNjU2MjUgTCA2LjM5NDUzMSAxNC4yNTc4MTIgTCA2LjUxNTYyNSAxNC4zNjMyODEgQyA2Ljk3NjU2MiAxNC43NzM0MzggNy44MzIwMzEgMTUuMTQ0NTMxIDguNzM0Mzc1IDE1LjMzNTkzOCBDIDkuMjg5MDYyIDE1LjQ1MzEyNSAxMC4yMTg3NSAxNS40ODA0NjkgMTAuNzY1NjI1IDE1LjQwMjM0NCBDIDExLjc3MzQzOCAxNS4yNTM5MDYgMTIuNTkzNzUgMTQuODU1NDY5IDEzLjA2NjQwNiAxNC4yOTI5NjkgQyAxMy4yNTM5MDYgMTQuMDYyNSAxMy40ODgyODEgMTMuNTg1OTM4IDEzLjU3MDMxMiAxMy4yNjU2MjUgQyAxMy42OTE0MDYgMTIuNzczNDM4IDEzLjY4NzUgMTIuMDYyNSAxMy41NTQ2ODggMTEuNTQ2ODc1IEMgMTMuMzI4MTI1IDEwLjY3MTg3NSAxMi44MDg1OTQgMTAuMTQ0NTMxIDExLjY5NTMxMiA5LjY0ODQzOCBDIDExLjQ5MjE4OCA5LjU1NDY4OCAxMC44ODY3MTkgOS4zMzU5MzggMTAuMzUxNTYyIDkuMTUyMzQ0IEMgOS4wMzUxNTYgOC43MTA5MzggOC42MjEwOTQgOC40OTYwOTQgOC4zOTg0MzggOC4xNDQ1MzEgQyA4LjIwNzAzMSA3Ljg0NzY1NiA4LjE3OTY4OCA3LjE1NjI1IDguMzQzNzUgNi44MzU5MzggQyA4LjcwMzEyNSA2LjEyNSA5Ljk4NDM3NSA1LjgzMjAzMSAxMS4zMTI1IDYuMTY0MDYyIEMgMTEuNjQwNjI1IDYuMjQ2MDk0IDEyLjI0NjA5NCA2LjUzOTA2MiAxMi40NjQ4NDQgNi43MTQ4NDQgQyAxMi41NTA3ODEgNi43OTI5NjkgMTIuNjM2NzE5IDYuODUxNTYyIDEyLjY1MjM0NCA2Ljg1MTU2MiBDIDEyLjY2NDA2MiA2Ljg1MTU2MiAxMi44NTE1NjIgNi42MjUgMTMuMDYyNSA2LjM0NzY1NiBDIDEzLjI3MzQzOCA2LjA3NDIxOSAxMy40NjA5MzggNS44MjgxMjUgMTMuNDgwNDY5IDUuODA0Njg4IEMgMTMuNTU4NTk0IDUuNzA3MDMxIDEyLjc5Mjk2OSA1LjE0NDUzMSAxMi4zNTE1NjIgNC45NzY1NjIgQyAxMS41NjY0MDYgNC42NzU3ODEgMTAuNDAyMzQ0IDQuNTI3MzQ0IDkuNDg0Mzc1IDQuNjEzMjgxIFogTSA5LjQ4NDM3NSA0LjYxMzI4MSAiLz4KPHBhdGggc3R5bGU9IiBzdHJva2U6bm9uZTtmaWxsLXJ1bGU6bm9uemVybztmaWxsOnJnYigwJSwwJSwwJSk7ZmlsbC1vcGFjaXR5OjE7IiBkPSJNIDE4LjE0ODQzOCAxMy43MDMxMjUgTCAxOC4xNDg0MzggMTguMTQ4NDM4IEwgOS4yMjI2NTYgMTguMTQ4NDM4IEwgOS4yMjI2NTYgMTguNDQ1MzEyIEwgMTguNDQ1MzEyIDE4LjQ0NTMxMiBMIDE4LjQ0NTMxMiA5LjI1MzkwNiBMIDE4LjE0ODQzOCA5LjI1MzkwNiBaIE0gMTguMTQ4NDM4IDEzLjcwMzEyNSAiLz4KPC9nPgo8L3N2Zz4K'
    ));

	acf_add_options_sub_page(array(
		'page_title'    => 'External Scripts',
		'menu_title'    => 'External Scripts',
		'parent_slug'   => 'site-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title'    => 'Footer',
		'menu_title'    => 'Footer Settings',
		'parent_slug'   => 'site-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title'    => 'Archive',
		'menu_title'    => 'Archive',
		'parent_slug'   => '/edit.php',
	));

}


// Block Category

add_filter( 'block_categories_all' , function( $categories ) {

    // Adding a new category.
	$categories[] = array(
		'slug'  => 's-tier',
		'title' => 'S Tier'
	);

	return $categories;
} );


// Blocks

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
	register_block_type( __DIR__ . '/../blocks/video-hero' );
	register_block_type( __DIR__ . '/../blocks/home-about' );
	register_block_type( __DIR__ . '/../blocks/products' );
	register_block_type( __DIR__ . '/../blocks/home-mission' );
	register_block_type( __DIR__ . '/../blocks/testimonials' );
	register_block_type( __DIR__ . '/../blocks/new-arrival' );
	register_block_type( __DIR__ . '/../blocks/latest-posts' );
	register_block_type( __DIR__ . '/../blocks/bg-wrap' );
	register_block_type( __DIR__ . '/../blocks/counters' );
	register_block_type( __DIR__ . '/../blocks/thank-you' );
	register_block_type( __DIR__ . '/../blocks/basic-section' );
	register_block_type( __DIR__ . '/../blocks/page-intro' );
}


function increment_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

// To trigger view count increment on single post view
function track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    increment_post_views($post_id);
}
add_action('wp_head', 'track_post_views');
