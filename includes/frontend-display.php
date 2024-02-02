<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display the promoted product.
 */
function wc_pp_display_promoted_product() {
    // Get the ID of the promoted product from the options table.
    $promoted_product_id = get_option('wc_pp_current_promoted_product');

    // Check if there's a promoted product set.
    if (!empty($promoted_product_id)) {
        // Check if the promotion has expired.
        $expire_date = get_post_meta($promoted_product_id, '_wc_pp_expire_date', true);
        $expire_time = get_post_meta($promoted_product_id, '_wc_pp_expire_time', true);

        $current_date = current_time('Y-m-d');
        $current_time = current_time('H:i');

        // Combine date and time for comparison.
        $current_datetime = strtotime($current_date . ' ' . $current_time);
        $expire_datetime = strtotime($expire_date . ' ' . $expire_time);

        // If the current date/time is past the expiration date/time, don't display.
        if ($current_datetime > $expire_datetime) {
            return;
        }

        // Fetch product details.
        $product = wc_get_product($promoted_product_id);
        if (!$product) {
            return;
        }

        $custom_title = get_post_meta($promoted_product_id, '_wc_pp_custom_title', true);
        $title = !empty($custom_title) ? $custom_title : $product->get_title();

        // Get the custom styles.
        $background_color = get_option('wc_pp_background_color', '#ffffff');
        $text_color = get_option('wc_pp_text_color', '#000000');

        // Output the promotional banner.
        echo '<div style="background-color:' . esc_attr($background_color) . '; color:' . esc_attr($text_color) . '; padding: 20px; text-align: center;">';
        echo '<p style="margin: 0;">' . esc_html($title) . ' | <a href="' . esc_url(get_permalink($promoted_product_id)) . '" style="color:' . esc_attr($text_color) . ';">View Product</a></p>';
        echo '</div>';
    }
}
add_action('wp_footer', 'wc_pp_display_promoted_product'); // You might want to change this hook depending on your theme's structure.
