<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package s-tier
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta name="theme-color" content="#ECAA1F" />
	<?php echo get_field('head_script', 'option'); ?> <!-- Head External Code -->
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php echo get_field('body_top_script', 'option'); ?> <!-- Body Top External Code -->

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'stier' ); ?></a>
	<header id="masthead" class="header-main">
		<div class="c-wide">
			<figure class="site-logo">
				<?php
				the_custom_logo(); ?>
			</figure><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<!-- Mobile Nav Button -->
				<div class="hamburger">
				<label for="nav-toggle">Navigation Menu</label>
				<input type="checkbox" class="menu-toggle" id="nav-toggle">

				<div></div></div>
				<!-- Mobile Nav Button -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
			<div class="header-right">
				<form action="/" method="get">
					<label for="search">Search in <?php echo home_url( '/' ); ?></label>
					<input type="image" alt="Search" id="search_icon" src="<?php bloginfo( 'template_url' ); ?>/assets/icons//search.svg" />
					<input type="text" name="s" id="search" placeholder="Search" value="<?php the_search_query(); ?>" />
				</form>
				<a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>" aria-label="Cart">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32.547" height="31.63" viewBox="0 0 32.547 31.63">
					<defs>
						<clipPath id="clip-path">
						<rect id="Rectangle_78" data-name="Rectangle 78" width="32.547" height="31.63" fill="#fff"></rect>
						</clipPath>
					</defs>
					<g id="Group_41" data-name="Group 41" clip-path="url(#clip-path)">
						<path id="Path_46" data-name="Path 46" d="M25.873,69.372a3.692,3.692,0,1,0-3.692,3.692,3.692,3.692,0,0,0,3.692-3.692m-5.139,0a1.477,1.477,0,1,1,1.477,1.477,1.477,1.477,0,0,1-1.477-1.477" transform="translate(-11.664 -41.433)" fill="#fff"></path>
						<path id="Path_47" data-name="Path 47" d="M63.843,69.372a3.692,3.692,0,1,0-3.692,3.692,3.692,3.692,0,0,0,3.692-3.692m-5.139,0a1.477,1.477,0,1,1,1.477,1.477A1.477,1.477,0,0,1,58.7,69.372" transform="translate(-35.617 -41.433)" fill="#fff"></path>
						<path id="Path_48" data-name="Path 48" d="M3.884,0H1.107a1.107,1.107,0,0,0,0,2.215H3.88a1.108,1.108,0,0,1,1.052.76L9.65,17.244,7.885,21.518a1.107,1.107,0,0,0,1.023,1.528H27.119a1.107,1.107,0,0,0,0-2.215H10.565l1.023-2.484,15.021-1.539A4.8,4.8,0,0,0,30.8,13.15l1.713-7.158A1.107,1.107,0,0,0,31.7,4.656a1.083,1.083,0,0,0-.241-.031L7.7,4.256,7.044,2.278A3.323,3.323,0,0,0,3.884,0M30.039,6.818l-1.392,5.814A2.584,2.584,0,0,1,26.4,14.6L11.61,16.121,8.428,6.494Z" transform="translate(0 0)" fill="#fff"></path>
					</g>
					</svg>
				</a>

			</div>
		</div>
	</header><!-- #masthead -->
