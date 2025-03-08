<?php
// Zapobiega bezpośredniemu uruchomieniu pliku
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Usunięcie ustawień wtyczki
delete_option('woocommerce_category_menu_settings');

// Usunięcie ustawień z bazy danych Multisite (jeśli wtyczka była używana w sieci witryn)
if (is_multisite()) {
    global $wpdb;
    $blogs = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
    foreach ($blogs as $blog_id) {
        delete_blog_option($blog_id, 'woocommerce_category_menu_settings');
    }
}
