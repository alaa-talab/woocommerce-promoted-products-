<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WooCommerce_Promoted_Products {
    /**
     * Construct the plugin.
     */
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        require_once WC_PP_PATH . 'includes/admin-settings.php';
        require_once WC_PP_PATH . 'includes/product-meta-boxes.php';
        require_once WC_PP_PATH . 'includes/frontend-display.php';
        require_once WC_PP_PATH . 'includes/utils.php';
    }

    /**
     * Register all of the hooks related to the administrative area functionality of the plugin.
     */
    public function define_admin_hooks() {
        add_filter('woocommerce_get_sections_products', 'wc_pp_add_settings_section');
        add_filter('woocommerce_get_settings_products', 'wc_pp_add_settings', 10, 2);
        add_action('woocommerce_product_options_general_product_data', 'wc_pp_add_custom_product_fields');
        add_action('woocommerce_admin_process_product_object', 'wc_pp_save_custom_product_fields', 10, 1);
    }

    /**
     * Register all of the hooks related to the public-facing functionality of the plugin.
     */
    public function define_public_hooks() {
        add_action('wp_footer', 'wc_pp_display_promoted_product');
    }

    /**
     * Run the plugin.
     */
    public function run() {
        // Admin hooks
        add_action('admin_init', [$this, 'define_admin_hooks']);
    
        // Public hooks
        add_action('wp_enqueue_scripts', [$this, 'define_public_hooks']);
    
        // Load plugin textdomain for internationalization
        add_action('plugins_loaded', function() {
            load_plugin_textdomain('woocommerce-promoted-products', false, WC_PP_PATH . 'languages/');
        });
    
        // Additional WooCommerce-specific hooks and filters can be added here
        // For example, to add a custom column to the products list in admin
        add_filter('manage_edit-product_columns', function($columns) {
            $columns['wc_pp_promoted'] = __('Promoted', 'woocommerce-promoted-products');
            return $columns;
        });
    
        // Populate the custom column with data
        add_action('manage_product_posts_custom_column', function($column, $postid) {
            if ('wc_pp_promoted' === $column) {
                $is_promoted = get_post_meta($postid, '_wc_pp_promote', true);
                echo $is_promoted ? __('Yes', 'woocommerce-promoted-products') : __('No', 'woocommerce-promoted-products');
            }
        }, 10, 2);
}
}

