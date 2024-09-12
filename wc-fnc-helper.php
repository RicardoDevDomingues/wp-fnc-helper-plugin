<?php

/*
Plugin Name: WooCommerce Helper
Description: Clears WooCommerce transients/caches and regenerates product tables.
Version: 1.0.0
Author: RicardoDevDomingues
*/

if (!defined('ABSPATH')) {
    echo 'You can\'t access this file directly.';
    exit;
}

define('WC_FNC_HELPER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WC_FNC_HELPER_PLUGIN_URL', plugin_dir_url(__FILE__));

$pluginName = 'WooCommerce Helper';
define('WC_FNC_HELPER_PLUGIN_NAME', $pluginName);

$pluginSlug = 'wc-fnc-helper';
define('WC_FNC_HELPER_PLUGIN_SLUG', $pluginSlug);

require_once WC_FNC_HELPER_PLUGIN_PATH . 'includes/Actions.php';
require_once WC_FNC_HELPER_PLUGIN_PATH . 'includes/CustomAdminPages.php';
require_once WC_FNC_HELPER_PLUGIN_PATH . 'includes/CacheManager.php';

register_activation_hook(__FILE__, ['Actions', 'onActivate']);
register_deactivation_hook(__FILE__, ['Actions', 'onDeactivate']);

if (class_exists('CustomAdminPages')) {
    $customAdminPages = new CustomAdminPages();
    $customAdminPages->register();
}

if (class_exists('CacheManager')) {
    $cacheManager = new CacheManager();
    $cacheManager->register();
}

function setAdminStylesAndScripts()
{

    wp_register_style(WC_FNC_HELPER_PLUGIN_SLUG . '-styles', WC_FNC_HELPER_PLUGIN_URL . 'assets/styles.css', [], '1.0.0', 'all');
    wp_register_script(WC_FNC_HELPER_PLUGIN_SLUG . '-scripts', WC_FNC_HELPER_PLUGIN_URL . 'assets/scripts.js', ['jquery'], '1.0.0', true);

    wp_enqueue_style(WC_FNC_HELPER_PLUGIN_SLUG . '-styles');
    wp_enqueue_script(WC_FNC_HELPER_PLUGIN_SLUG . '-scripts');
}

add_action('admin_enqueue_scripts', 'setAdminStylesAndScripts');