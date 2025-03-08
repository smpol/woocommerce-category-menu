<?php
/**
 * Plugin Name: WooCommerce Category Menu
 * Description: Prosta wtyczka do wyświetlania menu kategorii WooCommerce. Uzywa ona shortcode [print_category_woocommerce] do wyświetlenia menu.
 * Version: 1.0.0
 * Author: Michał Przysiężny
 * Author URI: https://przysiezny.pl
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-init.php';

WooCommerce_Category_Menu_Init::init();
