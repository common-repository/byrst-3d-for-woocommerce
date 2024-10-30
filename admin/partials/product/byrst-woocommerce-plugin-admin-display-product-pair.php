<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin/partials
 */

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly
?>
<div class="columns">
    <div class="column">
        <div class="columns">
            <div class="column">
                <div class="byrst-logo-name">
                    <img src="<?php echo esc_url(plugins_url('/admin/images/byrst-logo.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                        alt="<?php esc_attr_e('Logo - Byrst', 'byrst-3d-for-woocommerce');?>" class="byrst-logo">
                    <span class="byrst-name">
                        <?php esc_html_e('Bring your product to life with 3D', 'byrst-3d-for-woocommerce');?>
                    </span>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a id="byrst-gallery" class="button is-flex is-align-items-center is-justify-content-center">
                        <img src="<?php echo esc_url(plugins_url('/admin/images/icon-byrst-3d-white.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                            width="24px" class="mr-2">
                        <span><?php esc_html_e('Choose a different 3D model', 'byrst-3d-for-woocommerce');?></span>
                    </a>
                    <a id="byrst-remove" class="button is-flex is-align-items-center is-justify-content-center">
                        <img src="<?php echo esc_url(plugins_url('/admin/images/icon-byrst-remove.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                            width="24px" class="mr-2">
                        <span><?php esc_html_e('Remove 3D model', 'byrst-3d-for-woocommerce');?></span>
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <div class="columns">
            <div class="column">
                <p class="message">
                    <?php esc_html_e('Your model file successfully added', 'byrst-3d-for-woocommerce');?></p>
            </div>
        </div>
        <hr>
        <div class="columns">
            <div class="column">
                <div class="model-details">
                    <h2 class="message"><?php esc_html_e('Model thumbnail', 'byrst-3d-for-woocommerce');?></h2>
                    <img src="<?php echo esc_url($get_poster); ?>">
                </div>
                <br>
                <h2><?php esc_html_e('Alt text', 'byrst-3d-for-woocommerce');?></h2>
                <textarea class="textarea" readonly>
                    <?php echo esc_html($get_alt); ?>
                </textarea>
            </div>
        </div>
    </div>
</div>