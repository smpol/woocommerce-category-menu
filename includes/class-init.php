<?php

if (!defined('ABSPATH')) {
    exit;
}

class WooCommerce_Category_Menu_Init
{

    public static function init()
    {
        add_action('plugins_loaded', [__CLASS__, 'load_dependencies']);
    }

    public static function load_dependencies()
    {
        require_once plugin_dir_path(__FILE__) . 'class-menu-renderer.php';
        require_once plugin_dir_path(__FILE__) . 'class-settings.php';

        WooCommerce_Category_Menu_Settings::init();

        add_shortcode('print_category_woocommerce', ['WooCommerce_Category_Menu_Renderer', 'render_menu']);

        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets']);

        add_action('pre_get_posts', [__CLASS__, 'filter_sale_products']);
    }

    public static function enqueue_assets()
    {
        wp_enqueue_style(
            'woocommerce-category-menu-style',
            plugin_dir_url(__FILE__) . '../assets/styles.css'
        );

        wp_enqueue_script(
            'woocommerce-category-menu-script',
            plugin_dir_url(__FILE__) . '../assets/script.js',
            [],
            false,
            true
        );
    }

    public static function filter_sale_products($query)
    {
        if (!is_admin() && $query->is_main_query() && isset($_GET['onsale']) && $query->is_post_type_archive('product')) {
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            if (!empty($product_ids_on_sale)) {
                $query->set('post__in', $product_ids_on_sale);
            }
        }
    }
}
