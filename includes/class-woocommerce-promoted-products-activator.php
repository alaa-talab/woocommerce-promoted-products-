<?php
if (!defined('ABSPATH')) {
    exit;
}

class WooCommerce_Promoted_Products_Activator {
    public static function activate() {
        // Set default options
        update_option('wc_pp_background_color', '#ffffff');
        update_option('wc_pp_text_color', '#000000');
        // More activation tasks as needed
    }
}
