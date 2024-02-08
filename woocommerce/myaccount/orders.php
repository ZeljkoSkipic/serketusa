<?php

/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders); ?>

<?php if ($has_orders) : ?>

	<div class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<h1><?php esc_html_e('Your Orders', 'serketusa' ) ?></h1>
		<div>
			<?php
			foreach ($customer_orders->orders as $customer_order) {
				$order      = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();
				$items = $customer_order->get_items();
				$products = [];

				if($items) {
					foreach($items as $item) {

						$products[] = [
							'product_id' 	=> $item->get_product()->get_id(),
							'variation'		=> new WC_Product_Variation( $item->get_variation_id()),
							'product_type'	=> $item->get_product()->get_type()
						];
					}
				}

			?>
				<div class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr($order->get_status()); ?> order">
					<div class="st-order">
							<div class="left">
								<?php if(isset($products[0])) {
									if($products[0]['product_type'] == 'variation') {
										echo wp_get_attachment_image($products[0]['variation']->image_id, 'medium');
									}

									else {
										echo wp_get_attachment_image(get_post_thumbnail_id( $products[0]['product_id'] ), 'medium');
									}

								}
								?>
							</div>
							<div class="right">
								<div class="top">
									<div class="top-left">
										<time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></time>
										<p class="st-status"><?php echo esc_html(wc_get_order_status_name($order->get_status())); ?></p>
									</div>
									<div class="top-right">
										<p class="st-order_details"><a href="<?php echo esc_url($order->get_view_order_url()); ?>"> <?php esc_html_e('Order Details', 'serketusa') ?></a></p>
										<p class="st-order_cancel"><?php esc_html_e('Cancel / Modify', 'serketusa') ?></p>
										<p class="st-order_track"><?php esc_html_e('Track Order', 'serketusa') ?></p>
										<p class="st-order_return"><?php esc_html_e('Request a Return', 'serketusa') ?></p>
									</div>
								</div>
								<div class="mid">
									<p class="st-order_no">
										<span> <?php esc_html_e('Order #', 'serketusa') ?></span>
										<?php echo $order->get_order_number() ?>
									</p>
									<p class="st-order_total">
										<span> <?php esc_html_e('Order Total', 'serketusa') ?></span>
										<?php echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count)); ?>
									</p>
								</div>

								<?php if($products && count($products) > 1): ?>

								<div class="bottom">
									<h5><a href="<?php echo esc_url($order->get_view_order_url()); ?>"><?php esc_html_e('Also in this order', 'serketusa') ?></a></h5>

									<?php
									foreach($products as $index => $product) {
										if($index === 0) continue;

										if($product['product_type'] == 'variation') {
											echo wp_get_attachment_image($product['variation']->image_id, 'medium', false, ['class' => 'st-order_img']);
										}

										else {
											echo wp_get_attachment_image(get_post_thumbnail_id( $product['product_id'] ), 'medium', false, ['class' => 'st-order_img']);
										}
									}

									?>
								</div>

								<?php endif; ?>

							</div>
						</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>

	<?php do_action('woocommerce_before_account_orders_pagination'); ?>

	<?php if (1 < $customer_orders->max_num_pages) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if (1 !== $current_page) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>"><?php esc_html_e('Previous', 'woocommerce'); ?></a>
			<?php endif; ?>

			<?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>"><?php esc_html_e('Next', 'woocommerce'); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>

	<?php wc_print_notice(esc_html__('No order has been made yet.', 'woocommerce') . ' <a class="woocommerce-Button button' . esc_attr($wp_button_class) . '" href="' . esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) . '">' . esc_html__('Browse products', 'woocommerce') . '</a>', 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
	?>

<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
