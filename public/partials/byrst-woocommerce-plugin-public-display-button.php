<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/public/partials
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<button id="byrst_woocommerce_plugin_btn"><?php echo esc_html__( 'View in 3D', 'byrst-3d-for-woocommerce' ); ?></button>

<div id="dialog" title="<?php echo esc_html($product->get_name()); ?>">
  <!-- Byrst WooCommerce Plugin - HTML -->
  <model-viewer id="reveal" alt="<?php echo esc_attr($alt_description); ?>"
    src="<?php echo esc_url($android_file_url); ?>" 
    ios-src="<?php echo esc_url($ios_file_url); ?>"
    poster="<?php echo esc_url($poster_file_url); ?>"
    <?php if (!empty($loading)): ?> loading="<?php echo esc_attr($loading); ?>" <?php endif; ?>
    <?php if (!empty($reveal)): ?> reveal="<?php echo esc_attr($reveal); ?>" <?php endif; ?>
    <?php if (!empty($ar)): ?>ar <?php endif; ?>
    ar-modes="<?php echo esc_attr($ar_modes); ?>"
    ar-scale="<?php echo esc_attr($ar_scale_mode); ?>"
    ar-placement="<?php echo esc_attr($ar_placement_mode); ?>"
    <?php echo esc_attr($xr_environment_mode); ?>
    seamless-poster
    camera-controls enable-pan>
  </model-viewer>
  <!-- Byrst WooCommerce Plugin - HTML -->

  <!-- AR Custom Button -->
  <?php if ($this->byrst_woocommerce_plugin_ar_btn_custom($ar_btn_custom) == true): ?>
  <button slot="ar-button"
    style="background-color: <?php echo esc_attr($ar_btn_custom_background); ?>; color: <?php echo esc_attr($ar_btn_custom_text_color); ?>; border-radius: 4px; border: none; position: absolute; top: 16px; right: 16px; ">
    <?php echo esc_html($ar_btn_custom_text); ?>
  </button>
  <?php endif;?>
  <!-- AR Custom Button -->
</div>