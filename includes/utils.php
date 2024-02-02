<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if a given product's promotion is active based on the expiration date and time.
 *
 * @param int $product_id The ID of the product.
 * @return bool True if the promotion is active, false otherwise.
 */
function wc_pp_is_promotion_active($product_id) {
    $expire_date = get_post_meta($product_id, '_wc_pp_expire_date', true);
    $expire_time = get_post_meta($product_id, '_wc_pp_expire_time', true);

    if (empty($expire_date) || empty($expire_time)) {
        // If either date or time is not set, consider the promotion inactive.
        return false;
    }

    $current_datetime = current_time('timestamp');
    $expire_datetime = strtotime($expire_date . ' ' . $expire_time);

    return $current_datetime <= $expire_datetime;
}

/**
 * Retrieve the ID of the currently promoted product, if any.
 *
 * @return int|false The ID of the promoted product, or false if no product is currently promoted.
 */
function wc_pp_get_current_promoted_product_id() {
    $promoted_product_id = get_option('wc_pp_current_promoted_product');
    if (!empty($promoted_product_id) && wc_pp_is_promotion_active($promoted_product_id)) {
        return (int) $promoted_product_id;
    }
    return false;
}

/**
 * Format a given date and time string for display.
 *
 * @param string $date Date string in 'Y-m-d' format.
 * @param string $time Time string in 'H:i' format.
 * @return string Formatted date and time.
 */
function wc_pp_format_datetime_for_display($date, $time) {
    $timestamp = strtotime($date . ' ' . $time);
    // Adjust the date format according to your preference.
    return date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $timestamp);
}
