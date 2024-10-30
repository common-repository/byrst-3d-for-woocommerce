<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Registers options page menu item and form.
 */
$cmb = new_cmb2_box(array(
    'id' => 'byrst_woocommerce_plugin_settings',
    'object_types' => array('options-page'),
    'option_key' => 'byrst_woocommerce_plugin_settings', // The option key and admin menu page slug.
    'menu_title' => esc_html__('Byrst', 'byrst-3d-for-woocommerce'), // Fallback to 'title' if not specified.
    'parent_slug' => 'options-general.php', // Makes options page a submenu of the general settings.
    'capability' => 'manage_options', // Capability required to view the options-page.
    'save_button' => esc_html__('Save Settings', 'byrst-3d-for-woocommerce'), // Text for the options-page save button.
));

// Title section for the settings
$cmb->add_field(array(
    'name' => '<span class="dashicons dashicons-admin-generic"></span> ' . __('Byrst API', 'byrst-3d-for-woocommerce'), // Make the title translatable
    'type' => 'title',
    'id' => 'byrst_woocommerce_plugin_title_api',
    'before_row' => array('Byrst_Woocommerce_Plugin_Admin', 'byrst_woocommerce_plugin_cmb2_before_row'),
));


$cmb->add_field(array(
    'id' => 'byrst_woocommerce_plugin_claim_id',
    'type' => 'hidden'
));

$cmb->add_field(array(
    'id' => 'byrst_woocommerce_plugin_access_token',
    'type' => 'hidden',
));

$cmb->add_field( array(
    'name' => __( 'Enable Error Logs', 'byrst-3d-for-woocommerce' ),
    'desc' => __( 'Check this box to enable error logs only for debug.', 'byrst-3d-for-woocommerce' ),
    'id'   => 'byrst_woocommerce_plugin_enable_error_logs',
    'type' => 'checkbox',
    'default' => true
));

// Title section for the settings
$cmb->add_field(array(
    'name' => '<span class="dashicons dashicons-admin-generic"></span> ' . __('View Settings', 'byrst-3d-for-woocommerce'), // Make the title translatable
    'type' => 'title',
    'id' => 'byrst_woocommerce_plugin_title',
));

// Field for selecting where the button should appear
$cmb->add_field(array(
    'name' => esc_html__('Show button in', 'byrst-3d-for-woocommerce'),
    'id' => 'byrst_woocommerce_plugin_btn',
    'type' => 'select',
    'default' => 2,
    'classes' => 'switch-field',
    'show_option_none' => true,
    'options' => array(
        1 => __('Before Single Product Summary', 'byrst-3d-for-woocommerce'),
        2 => __('After Single Product Summary', 'byrst-3d-for-woocommerce'),
        3 => __('Before Single Product', 'byrst-3d-for-woocommerce'),
        4 => __('After Single Product', 'byrst-3d-for-woocommerce'),
        5 => __('After Add to Cart Form', 'byrst-3d-for-woocommerce'),
        6 => __('Before Add to Cart Form', 'byrst-3d-for-woocommerce'),
    ),
));

// Field to decide whether to show in Product Tabs
$cmb->add_field(array(
    'name' => esc_html__('Show in Product Tabs', 'byrst-3d-for-woocommerce'),
    'id' => 'byrst_woocommerce_plugin_single_product_tabs',
    'type' => 'radio_inline',
    'default' => 'no',
    'classes' => 'switch-field',
    'show_option_none' => false,
    'options' => array(
        'yes' => __('Yes', 'byrst-3d-for-woocommerce'),
        'no' => __('No', 'byrst-3d-for-woocommerce'),
    ),
    'default' => 'yes',
));

// Add a title field for the loading attributes section
$cmb->add_field(array(
    'name' => '<span class="dashicons dashicons-admin-generic"></span> ' . __('Loading: Attributes', 'byrst-3d-for-woocommerce'), // Make the title translatable
    'desc' => '',
    'type' => 'title',
    'id' => 'byrst_woocommerce_plugin_loading_title',
));

// Add a field for loading options
$cmb->add_field(array(
    'name' => __('Loading', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_loading',
    'type' => 'radio_inline',
    'desc' => __('An enumerable attribute describing under what conditions the model should be preloaded. The supported values are "auto", "lazy", and "eager". "Auto" is equivalent to "lazy", which loads the model when it is near the viewport for reveal="auto", and when interacted with for reveal="interaction". "Eager" loads the model immediately.', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'default' => '1',
    'classes' => 'switch-field',
    'show_option_none' => false,
    'options' => array(
        '1' => __('Auto', 'byrst-3d-for-woocommerce'),
        '2' => __('Lazy', 'byrst-3d-for-woocommerce'),
        '3' => __('Eager', 'byrst-3d-for-woocommerce'),
    ),
));

// Add a field for reveal options
$cmb->add_field(array(
    'name' => __('Reveal', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_reveal',
    'type' => 'radio_inline',
    'desc' => __('This attribute controls when the model should be revealed. It currently supports three values: "auto", "interaction", and "manual". If "reveal" is set to "interaction", <model-viewer> will wait until the user interacts with the poster before loading and revealing the model. If "reveal" is set to "auto", the model will be revealed as soon as it is done loading and rendering. If "reveal" is set to "manual", the model will remain hidden until dismissPoster() is called.', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'default' => '1',
    'classes' => 'switch-field',
    'show_option_none' => false,
    'options' => array(
        '1' => __('Auto', 'byrst-3d-for-woocommerce'),
        '2' => __('Interaction', 'byrst-3d-for-woocommerce'),
        '3' => __('Manual', 'byrst-3d-for-woocommerce'),
    ),
));

// Add a field for the poster color option
$cmb->add_field(array(
    'name' => '--poster-color',
    'id' => 'byrst_woocommerce_plugin_poster_color',
    'desc' => __('Sets the background-color of the poster. You may wish to set this to transparent if you are using a seamless poster with transparency (so that the background color of <model-viewer> shows through).', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'type' => 'colorpicker',
    'default' => 'rgba(255,255,255,0)',
    'options' => array(
        'alpha' => true, // Make this a rgba color picker.
    ),
));

// Add a title field for the Augmented Reality attributes section
$cmb->add_field(array(
    'name' => '<span class="dashicons dashicons-admin-generic"></span> ' . __('Augmented Reality: Attributes', 'byrst-3d-for-woocommerce'), // Make the title translatable
    'desc' => '',
    'type' => 'title',
    'id' => 'ar_title_2',
));

// Add a field to enable or disable AR functionality
$cmb->add_field(array(
    'name' => __('Enable AR', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_ar',
    'type' => 'radio_inline',
    'default' => '1',
    'desc' => __('Enable the ability to launch AR experiences on supported devices.', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'show_option_none' => false,
    'options' => array(
        '1' => __('Active', 'byrst-3d-for-woocommerce'),
        '2' => __('Deactivate', 'byrst-3d-for-woocommerce'),
    ),
    'classes' => 'switch-field',
));

// Add a field to select the AR modes
$cmb->add_field(array(
    'name' => __('AR Modes', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_ar_modes',
    'type' => 'multicheck',
    'default' => array( '1', '2', '3' ),
    'desc' => __('A prioritized list of the types of AR experiences to enable. Allowed values are "webxr", to launch the AR experience in the browser, "scene-viewer", to launch the Scene Viewer app, "quick-look", to launch the iOS Quick Look app. Note that the presence of an ios-src will enable quick-look by itself.', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'show_option_none' => false,
    'options' => array(
        '1' => __('webxr', 'byrst-3d-for-woocommerce'),
        '2' => __('scene-viewer', 'byrst-3d-for-woocommerce'),
        '3' => __('quick-look', 'byrst-3d-for-woocommerce'),
    ),
    'classes' => 'switch-field',
));

// Add a field to control scaling in AR mode
$cmb->add_field(array(
    'name' => __('AR Scale', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_ar_scale',
    'type' => 'radio_inline',
    'default' => '1',
    'desc' => __('Controls the scaling behavior in AR mode. Set to "fixed" to disable scaling of the model, which sets it to always be at 100% scale. Defaults to "auto" which allows the model to be resized by pinch.', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'show_option_none' => false,
    'options' => array(
        '1' => __('Auto', 'byrst-3d-for-woocommerce'),
        '2' => __('Fixed', 'byrst-3d-for-woocommerce'),
    ),
    'classes' => 'switch-field',
));

// Add a field to select the AR object placement (either on the floor or wall)
$cmb->add_field(array(
    'name' => __('AR Placement', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_ar_placement',
    'type' => 'radio_inline',
    'default' => '1',
    'desc' => __('Selects whether to place the object on the floor (horizontal surface) or a wall (vertical surface) in AR. The back (negative Z) of the object´s bounding box will be placed against the wall and the shadow will be put on this surface as well. Note that the different AR modes handle the placement UX differently.', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'show_option_none' => false,
    'options' => array(
        '1' => __('Floor', 'byrst-3d-for-woocommerce'),
        '2' => __('Wall', 'byrst-3d-for-woocommerce'),
    ),
    'classes' => 'switch-field',
));

// Add a field to enable or disable the XR-Environment for AR lighting estimation in WebXR mode
$cmb->add_field(array(
    'name' => __('XR-Environment', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_xr_environment',
    'type' => 'radio_inline',
    'default' => '2',
    'desc' => __('Enables AR lighting estimation in WebXR mode; this has a performance cost and replaces the lighting selected with during an AR session. Known issues: sometimes too dark, sudden updates, shiny materials look matte.', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'show_option_none' => false,
    'options' => array(
        '1' => __('Active', 'byrst-3d-for-woocommerce'),
        '2' => __('Deactive', 'byrst-3d-for-woocommerce'),
    ),
    'classes' => 'switch-field',
));

// Title field for Augmented Reality: Slots settings
$cmb->add_field(array(
    'name' => __('Augmented Reality : Slots', 'byrst-3d-for-woocommerce'), // Make the title translatable
    'desc' => '',
    'type' => 'title',
    'id' => 'ar_title_3',
    'before_row' => '<div id="cmb2-id-byrst-woocommerce-plugin-ar-settings">',
    'after_row' => '</div>',
));

// Option to enable or disable a custom AR button
$cmb->add_field(array(
    'name' => __('Custom AR Button', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_ar_button',
    'type' => 'radio_inline',
    'desc' => __('By placing a child element under <model-viewer> with slot="ar-button", this element will replace the default "Enter AR" button, which is a <model-viewer> icon in the lower right. This button will be visible if AR is potentially available (we will have some false positives until the user tries).', 'byrst-3d-for-woocommerce'), // Make the description translatable
    'show_option_none' => false,
    'options' => array(
        '1' => __('Active', 'byrst-3d-for-woocommerce'),
        '2' => __('Deactive', 'byrst-3d-for-woocommerce'),
    ),
    'default' => '2',
    'classes' => 'switch-field',
));

// Field to input custom text for the AR button
$cmb->add_field(array(
    'name' => __('Button Text', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'desc' => '',
    'default' => __('👋 Activate AR', 'byrst-3d-for-woocommerce'), // Make the default text translatable
    'id' => 'byrst_woocommerce_plugin_ar_button_text',
    'type' => 'text_medium',
));

// Field to select a custom background color for the AR button
$cmb->add_field(array(
    'name' => __('Button Color', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_ar_button_background_color',
    'type' => 'colorpicker',
    'default' => '#ffffff',
));

// Field to select a custom text color for the AR button
$cmb->add_field(array(
    'name' => __('Text Color', 'byrst-3d-for-woocommerce'), // Make the field name translatable
    'id' => 'byrst_woocommerce_plugin_ar_button_text_color',
    'type' => 'colorpicker',
    'default' => '#000000',
));
