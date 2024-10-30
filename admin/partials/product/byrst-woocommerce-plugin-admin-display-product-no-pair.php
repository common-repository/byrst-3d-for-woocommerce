<?php

/**
 * Provide a admin area view in product for the plugin when you are not paired with API
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="columns">
    <div class="column">
        <div class="columns">
            <div class="column">
                <div class="byrst-logo-name">
                    <img src="<?php echo esc_url(plugins_url('/admin/images/byrst-logo.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                        alt="<?php esc_attr_e('Logo - Byrst', 'byrst-3d-for-woocommerce'); ?>" class="byrst-logo">
                    <span class="byrst-name">
                        <?php esc_html_e('Bring your product to life with 3D', 'byrst-3d-for-woocommerce'); ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column is-4">
                <div class="buttons">
                    <a id="byrst-pair-product"
                        href="<?php echo esc_url(admin_url('options-general.php?page=byrst_woocommerce_plugin_settings')); ?>"
                        class="button is-flex is-align-items-center is-justify-content-center">
                        <img src="<?php echo esc_url(plugins_url('/admin/images/icon-byrst-pair-white.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                            width="24px" class="mr-2">
                        <span><?php esc_html_e('Pair with your Byrst app now', 'byrst-3d-for-woocommerce'); ?></span>
                    </a>
                </div>
            </div>
            <div class="column guide-container">
                <div class="columns">
                    <div class="column">
                        <figure class="image">
                            <img src="<?php echo esc_url(plugins_url('/admin/images/image-byrst-pairing-guide-2.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                alt="Byrst - Guide for Pair" class="pairing-guide">
                        </figure>
                        <div class="columns">
                            <div class="column">
                                <p class="text-description">
                                    <strong><?php esc_html_e('Step 1:', 'byrst-3d-for-woocommerce'); ?></strong><br>
                                    <?php esc_html_e('Retrieve 5-character code generated from your iOS app at the Settings screen', 'byrst-3d-for-woocommerce'); ?>
                                </p>
                            </div>
                            <div class="column">
                                <p class="text-description">
                                    <strong><?php esc_html_e('Step 2:', 'byrst-3d-for-woocommerce'); ?></strong><br>
                                    <?php esc_html_e('Go to WordPress Settings', 'byrst-3d-for-woocommerce'); ?>
                                </p>
                                <p class="text-description">
                                    <strong><?php esc_html_e('Step 3:', 'byrst-3d-for-woocommerce'); ?></strong><br>
                                    <?php esc_html_e('Select “Byrst 3D Model For WooCommerce”', 'byrst-3d-for-woocommerce'); ?>
                                </p>
                            </div>
                            <div class="column">
                                <p class="text-description">
                                    <strong><?php esc_html_e('Step 4:', 'byrst-3d-for-woocommerce'); ?></strong><br>
                                    <?php esc_html_e('Input the 5-character code to Pair with Byrst platform', 'byrst-3d-for-woocommerce'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>