<?php
class CacheManager
{
    public function clearTransientsAndRegenerateProductTables()
    {
        global $wpdb;

        // Clear WooCommerce transients
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_wc_%'");
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_wc_%'");

        if (function_exists('wc_delete_product_transients')) {
            wc_delete_product_transients();
        }
        if (function_exists('wc_delete_expired_transients')) {
            wc_delete_expired_transients();
        }

        // Regenerate product tables
        if (function_exists('wc_update_product_lookup_tables')) {
            wc_update_product_lookup_tables();
        }
    }

    public function clearTransientsAndRegenerateProductTablesPostAction()
    {

        if (isset($_POST['action']) && $_POST['action'] === 'clearTransientsAndRegenerateProductTablesPostAction') {

            try {

                $this->clearTransientsAndRegenerateProductTables();

                wp_redirect(admin_url('admin.php?page=' . WC_FNC_HELPER_PLUGIN_SLUG . '-page&success=1'));

                exit;

            } catch (Exception $e) {

                wp_redirect(admin_url('admin.php?page=' . WC_FNC_HELPER_PLUGIN_SLUG . '-page&error=1'));

                exit;
            }

        }

        wp_redirect(admin_url('admin.php?page=' . WC_FNC_HELPER_PLUGIN_SLUG . '-page&error=1'));

        exit;
    }

    public function clearTransientsAndRegenerateProductTablesNotices()
    {
        if (isset($_GET['success']) && $_GET['success'] == 1) {

            $notice = '<div class="notice notice-success is-dismissible">';
            $notice .= '<p>Success! Transients/cache cleared and product tables regenerated.</p>';
            $notice .= '</div>';

            echo $notice;
        }

        if (isset($_GET['error']) && $_GET['error'] == 1) {

            $notice = '<div class="notice notice-error is-dismissible">';
            $notice .= '<p>Error! Something went wrong.</p>';
            $notice .= '</div>';

            echo $notice;
        }
    }

    public function register()
    {
        add_action('admin_post_clearTransientsAndRegenerateProductTablesPostAction', [$this, 'clearTransientsAndRegenerateProductTablesPostAction']);
        add_action('admin_notices', [$this, 'clearTransientsAndRegenerateProductTablesNotices']);
    }
}