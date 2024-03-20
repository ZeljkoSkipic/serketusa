<?php

namespace App\Register;

class RegisterSettings
{

    public function __construct()
    {
        add_filter('woocommerce_get_settings_account', [$this, 'wooSettings'], 10, 2);
        add_action('wp_enqueue_scripts', [$this, 'loadScriptsStyles']);
        add_filter('bulk_actions-users', [$this, 'addBulkActionUsersPage']);
        add_filter('user_row_actions', [$this, 'addRowActionUsersPage'], 10, 2);
        add_filter('woocommerce_package_rates', [$this, 'shippingBasedUserRole'], 100, 2);
        add_action('init', [$this, 'newRegisterRole']);
        $this->acfOptionPage();
    }

    public function loadScriptsStyles()
    {
        wp_enqueue_script('appRegisterScript', get_stylesheet_directory_uri() . '/includes/register/dist/main.min.js', ['jquery'], '1.0', true);
        // wp_enqueue_script('appRegisterStyle', get_stylesheet_directory_uri() . '/includes/register/dist/main.css');
        wp_localize_script('appRegisterScript', 'appRegister', [
            'ajaxUrl'       => admin_url('admin-ajax.php'),
            'ajaxNonce'     => wp_create_nonce('requestNonce')
        ]);
    }

    public function newRegisterRole()
    {
        add_role('military_customer', 'Military Customer', get_role('customer')->capabilities);
    }

    public function shippingBasedUserRole($rates, $package)
    {
        if (is_admin() && !defined('DOING_AJAX')) {
            return $rates;
        }

        $target_user_role = 'military_customer';
        $current_user = wp_get_current_user();

        if (in_array($target_user_role, $current_user->roles)) {

            // Is free shipping method exists

            $free_shipping_method = false;
            $local_pickup_method = false;

            foreach ($rates as $rate_id => $rate) {
                if ('free_shipping' === $rate->method_id) {
                    $free_shipping_method = true;
                }

                if ('local_pickup' === $rate->method_id) {
                    $local_pickup_method = true;
                }
            }

            if ($free_shipping_method === true) {
                if (is_array($rates) && $rates) {
                    $rates = array_filter($rates, function ($rate){
                        return $rate->method_id === 'free_shipping' || $rate->method_id === 'local_pickup';
                    });
                }
            }

            else {

                // Get just flat rate methods

                if (is_array($rates) && $rates) {
                    $rates_flat = array_filter($rates, function ($rate){
                        return $rate->method_id === 'flat_rate';
                    });
                }

                // Get just local_pickup

                if (is_array($rates) && $rates && $local_pickup_method === true) {
                    $local_pickups = array_filter($rates, function ($rate){
                        return $rate->method_id === 'local_pickup';
                    });
                }

                foreach ($rates_flat as $rate_id => $rate) {
                    if ('flat_rate' === $rate->method_id) {
                        $rates[$rate_id]->cost = 0;
                        $rates[$rate_id]->label = __('Free Shipping', 'register');
                    }

                    if(count($rates_flat) !== 1) {
                        unset($rates_flat[$rate_id]);
                    }
                }

                if($local_pickup_method === true) {
                    $rates_flat = array_merge($rates_flat, $local_pickups);
                }

                $rates = $rates_flat;
            }
        }

        return $rates;
    }

    public function addBulkActionUsersPage($actions)
    {
        // Only admin has this action

        if (!current_user_can('manage_options')) {
            return $actions;
        }

        $actions['user-approve-bulk'] = __('User Approve', 'register');
        return $actions;
    }

    public function addrowActionUsersPage($actions, $user)
    {
        // Only admin has this action

        if (!current_user_can('manage_options')) {
            return $actions;
        }

        $user_status = get_user_meta($user->ID, 'status', true);
        if ($user_status == 'hold') {
            $actions['user-approve-single'] = "<a class='user-approve' href='" . admin_url("users.php?&action=user-approve-row&amp;user=$user->ID") . "'>" . esc_html__('User Approve', 'register') . "</a>";
        }

        return $actions;
    }

    public function acfOptionPage()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_sub_page(array(
                'page_title'    => 'Users CST Team Settings',
                'menu_title'    => 'CST Users',
                'parent_slug'   => 'woocommerce',
            ));
        }
    }

    public function wooSettings($settings, $current_section)
    {

        $field = [
            'title'      => __('Military Form Register Page'),
            'type'       => 'select',
            'desc'       => __('Select the page where the form will be displayed'),
            'id'         => 'military_form_register'
        ];

        $field['options'][-1] = __('Choose Page');

        $pages = $this->getPages();

        if ($pages) {
            foreach ($pages as $page) {
                $field['options'][$page->ID] = $page->post_title;
            }
        }

        $field_title = [
            'name'      => __('Military Form Register Page'),
            'type'       => 'title',
            'id'         => 'military_form_register_title'
        ];

        array_unshift($settings, $field);
        array_unshift($settings, $field_title);


        return $settings;
    }

    private function getPages()
    {
        $pages = get_posts([
            'posts_per_page'    => -1,
            'post_type'         => 'page',
        ]);

        return $pages;
    }
}
