<?php

if (!defined('ABSPATH')) {
    exit;
}

class WooCommerce_Category_Menu_Settings {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_plugin_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
    }

    public static function add_plugin_menu() {
        add_options_page(
            'WooCommerce Category Menu',
            'Woo Category Menu',
            'manage_options',
            'woocommerce_category_menu',
            [__CLASS__, 'settings_page']
        );
    }

    public static function register_settings() {
        register_setting('woocommerce_category_menu_settings_group', 'woocommerce_category_menu_settings');
    }

    public static function settings_page() {
        $settings = get_option('woocommerce_category_menu_settings', []);
        ?>
        <div class="wrap">
            <h1>Ustawienia WooCommerce Category Menu</h1>
            <form method="post" action="options.php">
                <?php settings_fields('woocommerce_category_menu_settings_group'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="title">Nagłówek:</label></th>
                        <td><input type="text" name="woocommerce_category_menu_settings[title]" value="<?php echo esc_attr($settings['title'] ?? 'Kategorie produktów'); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="all_products_text">Tekst "Wszystkie produkty":</label></th>
                        <td><input type="text" name="woocommerce_category_menu_settings[all_products_text]" value="<?php echo esc_attr($settings['all_products_text'] ?? 'Wszystkie produkty'); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="sale_products_text">Tekst "Promocje":</label></th>
                        <td><input type="text" name="woocommerce_category_menu_settings[sale_products_text]" value="<?php echo esc_attr($settings['sale_products_text'] ?? 'Promocje'); ?>"></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
