<?php

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

/**
 * Initializes the Custom Meta Boxes for WooCommerce Products.
 */

// Set up a new CMB2 metabox for WooCommerce products.
$cmb = new_cmb2_box(array(
    'id' => 'byrst_woocommerce_plugin_metaboxes',
    'title' => __('Byrst', 'byrst-3d-for-woocommerce'), // Make the title translatable.
    'object_types' => array('product'), // Specify the post type: product.
    'context' => 'normal',
    'priority' => 'low',
    'show_names' => false, // Display field names on the left side.
    'cmb_styles' => false, // Activate the CMB stylesheet.
    'closed' => false, // Keep the metabox expanded by default.
));

// Add a title field for 3D model information.
$cmb->add_field(array(
    'type' => 'title',
    'id' => 'byrst_woocommerce_plugin_title_3d_model',
    'after_row' => array('Byrst_Woocommerce_Plugin_Admin','byrst_woocommerce_plugin_modal')
));

// File field for Android .glb files.
$cmb->add_field(array(
    'id' => 'byrst_woocommerce_plugin_file_android',
    'type' => 'hidden',
));

// File field for iOS .usdz files.
$cmb->add_field(array(
    'id' => 'byrst_woocommerce_plugin_file_ios',
    'type' => 'hidden',
));

// File field for a poster image.
$cmb->add_field(array(
    'id' => 'byrst_woocommerce_plugin_file_poster',
    'type' => 'hidden',
));

// Text field for alt attribute for models.
$cmb->add_field(array(
    'id' => 'byrst_woocommerce_plugin_file_alt',
    'type' => 'hidden',
    //'after_row' => array('Byrst_Woocommerce_Plugin_Admin', 'byrst_woocommerce_plugin_gallery'),
));

// Hook for adding additional custom fields if needed.
do_action('byrst_woocommerce_plugin_custom_fields');
