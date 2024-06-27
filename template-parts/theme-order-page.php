<?php
$is_user_military = false;

if (is_user_logged_in()) {
    $user =  wp_get_current_user();
    $roles = (array) $user->roles;

    if (in_array('administrator', $roles) || in_array('military_customer', $roles)) {
        $is_user_military = true;
    }
}
if ($is_user_military) :
    $products = new WP_Query([
        'post_type'         => 'product',
        'posts_per_page'    => -1,
        'meta_key'          => '_wp_page_template',
        'meta_value'        => 'woocommerce/single-product-military.php'
    ]);

?>

    <div class="military-products-order-page">
        <header class="page-header space_4">
            <?php
            $archive_hero_background = get_field('archive_hero_background', 'option');
            $size = 'full';
            if ($archive_hero_background) {
                echo wp_get_attachment_image($archive_hero_background, $size, "", array("class" => "archive_hero_background"));
            } ?>
            <div class="c-narrow">
                <h1 class="woocommerce-products-header__title page-title"><?php esc_html_e('Team Order', 'serketusa') ?></h1>
            </div>
        </header>
        <div class="c-wide space_2">
            <?php
            if ($products->have_posts()) {
                woocommerce_product_loop_start();
                while ($products->have_posts()) {
                    $products->the_post();

                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action('woocommerce_shop_loop');

                    wc_get_template_part('content', 'product');
                }
                woocommerce_product_loop_end();
                wp_reset_query();
            } else {
                do_action('woocommerce_no_products_found');
            }

            ?>
        </div>
    </div>

<?php else : ?>

    <main id="primary" class="site-main">
        <?php the_content(); ?>
    </main><!-- #main -->

<?php endif;
?>