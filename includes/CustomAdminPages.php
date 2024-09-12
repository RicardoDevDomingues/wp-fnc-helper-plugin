<?php
class CustomAdminPages
{

    public function helperPage()
    {
        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $products = new WP_Query($args);

        $page = '<div class="wc-fnc-helper-wrapper">';
        $page .= '<h1>' . WC_FNC_HELPER_PLUGIN_NAME . '</h1>';

        $page .= '<div class="wc-fnc-helper-title-container m-50"><h2>Problematic variable products:</h2></div>';

        $countProblematicProducts = 0;

        if ($products->have_posts()) {
            $page .= '<ul class="wc-fnc-helper-list-container">';

            while ($products->have_posts()) {
                $products->the_post();

                global $product;

                if ($product->is_type('variable')) {
                    $productVariations = $product->get_available_variations();

                    if (count($productVariations) <= 0) {

                        $countProblematicProducts++;

                        $page .= '<li class="wc-fnc-helper-list-item">' . get_the_title() . '</li>';
                    }
                }
            }

            if ($countProblematicProducts === 0) {
                $page .= '<li class="wc-fnc-helper-list-item-success-text">No problematic products found.</li>';
            }

            $page .= '</ul>';

            wp_reset_postdata();
        }

        $page .= '<div class="wc-fnc-helper-title-container"><h2>Click the button to clear WooCommerce transients/caches and regenerate product tables:</h2></div>';

        $page .= '<form class="wc-fnc-helper-form" method="post" action="' . admin_url('admin-post.php') . '">';
        $page .= '<input type="hidden" name="action" value="clearTransientsAndRegenerateProductTablesPostAction">';
        $page .= '<button class="wc-fnc-helper-submit-button" type="submit">CLEAR</button>';
        $page .= '</form>';

        $page .= '</div>';

        echo $page;
    }
    public function createHelperPage()
    {
        add_menu_page(WC_FNC_HELPER_PLUGIN_NAME, WC_FNC_HELPER_PLUGIN_NAME, 'manage_options', WC_FNC_HELPER_PLUGIN_SLUG . '-page', [$this, 'helperPage'], 'dashicons-admin-tools', 200);
    }

    public function register()
    {
        add_action('admin_menu', [$this, 'createHelperPage']);
    }
}