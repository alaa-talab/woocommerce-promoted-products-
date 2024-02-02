<?php
if (!defined('ABSPATH')) {
    exit;
}

class WooCommerce_Promoted_Products_Deactivator {
    public static function deactivate() {
        // Flush rewrite rules or other deactivation tasks
        flush_rewrite_rules();
    }
}
