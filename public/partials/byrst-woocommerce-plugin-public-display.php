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

<?php 
// Check if product has a 3D Model 
if (empty($android_file_url) && empty($ios_file_url)) {
    echo '<h1>' . esc_html__('Not available', 'byrst-3d-for-woocommerce') . '</h1>';
} else {
?>
    <!-- Byrst WooCommerce Plugin -->
    <model-viewer 
        alt="<?php echo esc_attr($alt_description); ?>" 
        src="<?php echo esc_url($android_file_url); ?>"
        ios-src="<?php echo esc_url($ios_file_url); ?>" 
        poster="<?php echo esc_url($poster_file_url); ?>" 
        ar 
        ar-modes="webxr scene-viewer quick-look" 
        camera-controls 
        seamless-poster 
        shadow-intensity="1" 
        camera-controls 
        enable-pan>
    </model-viewer>
<?php
}
?>