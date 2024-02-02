<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds custom fields to the General product settings tab.
 */
function wc_pp_add_custom_product_fields() {
    global $woocommerce, $post;

    echo '<div class="options_group">';

    // Checkbox to indicate if this product should be promoted
    woocommerce_wp_checkbox(
        array(
            'id'            => '_wc_pp_promote',
            'label'         => __('Promote this product', 'woocommerce-promoted-products'),
            'description'   => __('Check this box to promote this product.', 'woocommerce-promoted-products'),
        )
    );

    // Text field for the custom promoted product title
    woocommerce_wp_text_input(
        array(
            'id'          => '_wc_pp_custom_title',
            'label'       => __('Custom Promoted Title', 'woocommerce-promoted-products'),
            'desc_tip'    => 'true',
            'description' => __('Enter a custom title for the promoted product. Leave blank to use the product title.', 'woocommerce-promoted-products'),
        )
    );

    // Date picker for promotion expiration date
    woocommerce_wp_text_input(
        array(
            'id'          => '_wc_pp_expire_date',
            'label'       => __('Promotion Expiry Date', 'woocommerce-promoted-products'),
            'placeholder' => 'YYYY-MM-DD',
            'description' => __('Enter the expiry date of the promotion.', 'woocommerce-promoted-products'),
            'type'        => 'date',
            'desc_tip'    => true,
            'class'       => 'date-picker-field',
        )
    );

    // Time picker for promotion expiration time
    woocommerce_wp_text_input(
        array(
            'id'          => '_wc_pp_expire_time',
            'label'       => __('Promotion Expiry Time', 'woocommerce-promoted-products'),
            'placeholder' => 'HH:MM',
            'description' => __('Enter the expiry time of the promotion. Use 24-hour format.', 'woocommerce-promoted-products'),
            'type'        => 'time',
            'desc_tip'    => true,
            'class'       => 'time-picker-field',
        )
    );

    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'wc_pp_add_custom_product_fields');

/**
 * Saves the custom fields values when submitted.
 *
 * @param int $post_id The ID of the post being saved.
 */
function wc_pp_save_custom_product_fields($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['_wc_pp_nonce'])) {
        return;
    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['_wc_pp_nonce'], 'wc_pp_save_data')) {
        return;
    }

    // Check this is the Product Post Type
    if ('product' != $_POST['post_type']) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the checkbox
    $wc_pp_promote = isset($_POST['_wc_pp_promote']) ? 'yes' : 'no';
    update_post_meta($post_id, '_wc_pp_promote', $wc_pp_promote);

    // Save the custom title
    if (isset($_POST['_wc_pp_custom_title'])) {
        update_post_meta($post_id, '_wc_pp_custom_title', sanitize_text_field($_POST['_wc_pp_custom_title']));
    }

    // Save the expiry date
    if (isset($_POST['_wc_pp_expire_date'])) {
        update_post_meta($post_id, '_wc_pp_expire_date', sanitize_text_field($_POST['_wc_pp_expire_date']));
    }

    // Save the expiry time
    if (isset($_POST['_wc_pp_expire_time'])) {
        update_post_meta($post_id, '_wc_pp_expire_time', sanitize_text_field($_POST['_wc_pp_expire_time']));
    }
}
add_action('woocommerce_process_product_meta', 'wc_pp_save_custom_product_fields');
