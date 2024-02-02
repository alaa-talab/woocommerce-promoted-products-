<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Adds a new section to the WooCommerce settings tabs.
 */
function wc_pp_add_settings_section($sections) {
    $sections['wc_pp_promoted_products'] = __('Promoted Products', 'woocommerce-promoted-products');
    return $sections;
}
add_filter('woocommerce_get_sections_products', 'wc_pp_add_settings_section');

/**
 * Adds settings fields for our new section.
 */
function wc_pp_add_settings($settings, $current_section) {
    // Check if the current section is what we've added
    if ($current_section == 'wc_pp_promoted_products') {
        $wc_pp_settings = array(
            array(
                'title' => __('Promoted Product Settings', 'woocommerce-promoted-products'),
                'type'  => 'title',
                'desc'  => __('Settings for Promoted Products.', 'woocommerce-promoted-products'),
                'id'    => 'wc_pp_settings'
            ),
            array(
                'title'    => __('Promoted Product Title', 'woocommerce-promoted-products'),
                'desc'     => __('This title will be displayed above the promoted product.', 'woocommerce-promoted-products'),
                'id'       => 'wc_pp_promoted_title',
                'type'     => 'text',
                'default'  => 'FLASH SALE:',
                'desc_tip' => true,
            ),
            array(
                'title'    => __('Background Color', 'woocommerce-promoted-products'),
                'desc'     => __('Choose a background color for the promoted product display.', 'woocommerce-promoted-products'),
                'id'       => 'wc_pp_background_color',
                'type'     => 'color',
                'default'  => '#ffffff',
                'desc_tip' => true,
            ),
            array(
                'title'    => __('Text Color', 'woocommerce-promoted-products'),
                'desc'     => __('Choose a text color for the promoted product display.', 'woocommerce-promoted-products'),
                'id'       => 'wc_pp_text_color',
                'type'     => 'color',
                'default'  => '#000000',
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
                'id'   => 'wc_pp_settings'
            ),
        );
        return $wc_pp_settings;
    }

    // If not in our section, return the standard settings
    return $settings;
}
add_filter('woocommerce_get_settings_products', 'wc_pp_add_settings', 10, 2);
