<?php

if (!defined('ABSPATH')) {
    exit;
}

class WooCommerce_Category_Menu_Renderer
{

    public static function render_menu()
    {
        if (!class_exists('WooCommerce')) {
            return '<p>WooCommerce nie jest aktywny.</p>';
        }

        $settings = get_option('woocommerce_category_menu_settings', []);

        $title = $settings['title'] ?? 'Kategorie produktów';
        $all_products_text = $settings['all_products_text'] ?? 'Wszystkie produkty';
        $sale_products_text = $settings['sale_products_text'] ?? 'Promocje';

        $args = [
            'taxonomy' => "product_cat",
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true,
        ];
        $product_categories = get_terms($args);
        $categories = [];

        foreach ($product_categories as $category) {
            $categories[] = [
                'name' => esc_html($category->name),
                'link' => esc_url(get_term_link($category))
            ];
        }

        $shop_page_url = esc_url(get_post_type_archive_link('product'));
        $sale_products_page_url = esc_url(add_query_arg('onsale', 'true', $shop_page_url));
        $has_sale_products = !empty(wc_get_product_ids_on_sale());

        ob_start();
        ?>
        <div class="woocommerce-category-menu">
            <h3 class="category-title"><?php echo esc_html($title); ?></h3>

            <!-- Mobile Version (select) -->
            <select class="category-select" onchange="if (this.value) window.location.href=this.value;">
                <option value="" disabled selected>Wybierz kategorię</option>
                <option value="<?php echo $shop_page_url; ?>"><?php echo esc_html($all_products_text); ?></option>
                <?php if ($has_sale_products): ?>
                    <option value="<?php echo $sale_products_page_url; ?>"><?php echo esc_html($sale_products_text); ?></option>
                <?php endif; ?>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['link']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Desktop Version (list) -->
            <ul class="ul-category-list">
                <li><a href="<?php echo $shop_page_url; ?>"
                        class="all-products-button"><?php echo esc_html($all_products_text); ?></a></li>
                <?php if ($has_sale_products): ?>
                    <li><a href="<?php echo $sale_products_page_url; ?>"
                            class="sale-products-button"><?php echo esc_html($sale_products_text); ?></a></li>
                <?php endif; ?>
                <?php foreach ($categories as $category): ?>
                    <li><a href="<?php echo $category['link']; ?>"><?php echo $category['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                function checkWidth() {
                    var categoryList = document.querySelector('.ul-category-list');
                    var categorySelect = document.querySelector('.category-select');
                    if (window.innerWidth < 992) {
                        categoryList.style.display = 'none';
                        categorySelect.style.display = 'block';
                    } else {
                        categoryList.style.display = 'block';
                        categorySelect.style.display = 'none';
                    }
                }
                window.addEventListener('resize', checkWidth);
                checkWidth();
            });
        </script>
        <?php
        return ob_get_clean();
    }
}
