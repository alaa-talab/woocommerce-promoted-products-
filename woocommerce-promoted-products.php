<?php
/*
Plugin Name: WooCommerce Promoted Products
Plugin URI:  https://portfolio.sdac.space/
Description: Display a promoted product on every page.
Version:     1.0
Author:      Alaa Talab
Author URI:  https://portfolio.sdac.space/
Text Domain: woocommerce-promoted-products
Domain Path: /languages
WC requires at least: 3.0.0
WC tested up to: 5.9.0
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin version constant.
define('WC_PP_VERSION', '1.0');

// Define plugin paths and URLs.
define('WC_PP_PATH', plugin_dir_path(__FILE__));
define('WC_PP_URL', plugin_dir_url(__FILE__));

require_once WC_PP_PATH . 'includes/utils.php';
require_once WC_PP_PATH . 'includes/admin-settings.php';
require_once WC_PP_PATH . 'includes/product-meta-boxes.php';
require_once WC_PP_PATH . 'includes/frontend-display.php';


// Activation hook
function activate_woocommerce_promoted_products() {
    require_once WC_PP_PATH . 'includes/class-woocommerce-promoted-products-activator.php';
    WooCommerce_Promoted_Products_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_woocommerce_promoted_products');

// Deactivation hook
function deactivate_woocommerce_promoted_products() {
    require_once WC_PP_PATH . 'includes/class-woocommerce-promoted-products-deactivator.php';
    WooCommerce_Promoted_Products_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_woocommerce_promoted_products');

register_activation_hook(__FILE__, 'activate_woocommerce_promoted_products');
register_deactivation_hook(__FILE__, 'deactivate_woocommerce_promoted_products');

/**
 * Core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require WC_PP_PATH . 'includes/class-woocommerce-promoted-products.php';

/**
 * Begins execution of the plugin.
 */
function run_woocommerce_promoted_products() {
    $plugin = new WooCommerce_Promoted_Products();
    $plugin->run();
}

run_woocommerce_promoted_products();