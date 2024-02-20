<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ACF Dependency

if(!function_exists('get_field') || !function_exists('is_shop') ) {

	add_action('admin_notices', function() {
		?>
		<div class="notice notice-warning is-dismissible">
          	<p><?php esc_html_e('The form register feature requires Woocommerce and ACF Pro installed', 'register'); ?></p>
         </div>
		<?php
	});

	return;
}

require 'vendor/autoload.php';

new App\Register\Register();
