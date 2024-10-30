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
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<!-- Byrst WooCommerce Plugin - Page of Settings -->
<div class="byrst-woocommerce-plugin-cards">
    <div class="byrst-woocommerce-plugin-card">
        <!-- Logo -->
        <div class="byrst-logo-name">
            <img src="<?php echo esc_url(plugins_url('admin/images/byrst-logo.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                alt="<?php esc_attr_e('Logo - Byrst', 'byrst-3d-for-woocommerce'); ?>" class="byrst-logo">
            <span class="byrst-name">
                <?php esc_html_e('3D Models for WooCommerce Plugin', 'byrst-3d-for-woocommerce'); ?>
            </span>
        </div>
        <div class="columns">
            <div class="column">
                <span class="settings">
                    <?php esc_html_e('Settings', 'byrst-3d-for-woocommerce'); ?>
                </span>
            </div>
        </div>
        <hr class="hr-divider">
        <div class="columns is-vcentered is-centered">
            <div class="column">
                <div class="is-flex is-align-items-center">
                    <figure class="image">
                        <img src="<?php echo esc_url(plugins_url('admin/images/icon-byrst-cog.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                            alt="<?php esc_attr_e('The Byrst Platform', 'byrst-3d-for-woocommerce'); ?>">
                    </figure>
                    <span class="title"><?php esc_html_e('The Byrst Platform', 'byrst-3d-for-woocommerce'); ?></span>
                </div>
                <div>
                    <p class="text-description">
                        <?php esc_html_e('Byrst lets your customers see how your products will look in their spaces using Augmented Reality (AR). Make photo-realistic 3D models of your products using your iPhone. You can easily create, scale, and host your 3D models, without learning complex 3D software. When you are satisfied with your 3D model, you can activate and publish it using our WooCommerce Plugin. Your customers will then be able to visualize your product in 3D and virtually view them in their own spaces.', 'byrst-3d-for-woocommerce'); ?>
                    </p>
                </div>
            </div>
            <hr class="line is-hidden-mobile is-hidden-tablet-only">
            <div class="column">
                <div class="is-flex is-align-items-center">
                    <figure class="image">
                        <img src="<?php echo esc_url(plugins_url('admin/images/icon-byrst-help.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                            alt="<?php esc_attr_e('Support', 'byrst-3d-for-woocommerce'); ?>">
                    </figure>
                    <span class="title"><?php esc_html_e('Support', 'byrst-3d-for-woocommerce'); ?></span>
                </div>
                <div>
                    <p class="text-description">
                        <?php esc_html_e('If you have any questions or feedback about Byrst, we would love to hear from you. You can contact us by sending an email to', 'byrst-3d-for-woocommerce'); ?>
                        <a class="text-link"
                            href="mailto:support@byrst.com"><?php esc_html_e('support@byrst.com', 'byrst-3d-for-woocommerce'); ?></a>.
                    </p>
                    <p class="text-description">
                        <?php esc_html_e('You can also check out our', 'byrst-3d-for-woocommerce'); ?> <a class="text-link"
                            href="link_to_your_FAQ"><?php esc_html_e('FAQ', 'byrst-3d-for-woocommerce'); ?></a>
                        <?php esc_html_e('page for answers to some common questions about Byrst and how to use it. Alternatively, you can browse our', 'byrst-3d-for-woocommerce'); ?>
                        <a class="text-link"
                            href="link_to_your_tutorials"><?php esc_html_e('tutorials', 'byrst-3d-for-woocommerce'); ?></a>
                        <?php esc_html_e('for more detailed instructions and tutorials on how to create and publish your 3D models.', 'byrst-3d-for-woocommerce'); ?>
                    </p>
                </div>
            </div>
        </div>
        <hr class="hr-divider">
        <div class="columns">
            <div class="column">
                <span class="secondary-title">
                    <?php esc_html_e('Easily create 3D models and add them to your product listings', 'byrst-3d-for-woocommerce'); ?>
                </span>
            </div>
        </div>
        <div class="columns">
            <div class="column is-one-fifth">
                <div>
                    <p class="text-description">
                        <?php esc_html_e('The Byrst 3D Models for WooCommerce Plugin works in conjunction with an iPhone app to help you create and manage 3D models and stickers for Augmented Reality (AR).', 'byrst-3d-for-woocommerce'); ?>
                    </p>
                </div>
                <div class="columns">
                    <div class="column">
                        <a href="https://apps.apple.com/us/app/air-stickers-ar-photos-editor/id6447993528"
                            target="_blank">
                            <img src="<?php echo esc_url(plugins_url('admin/images/icon-byrst-app-store.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                alt="<?php esc_attr_e('Download on the App Store', 'byrst-3d-for-woocommerce'); ?>"
                                class="byrst-app-store">
                            <br>
                            <img src="<?php echo esc_url(plugins_url('admin/images/byrst-qr-for-app-store-w-o-logo.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                alt="<?php esc_attr_e('QR Code for Download on the App Store', 'byrst-3d-for-woocommerce'); ?>"
                                class="byrst-app-store">
                        </a>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="columns is-centered">
                    <div class="column">
                        <p class="text-description"><?php esc_html_e('Step 1', 'byrst-3d-for-woocommerce'); ?></p>
                        <figure class="image is-square">
                            <img src="<?php echo esc_url(plugins_url('admin/images/byrst-step-1.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                class="byrst-img">
                        </figure>
                    </div>
                    <div class="column">
                        <p class="text-description"><?php esc_html_e('Step 2', 'byrst-3d-for-woocommerce'); ?></p>
                        <figure class="image is-square">
                            <img src="<?php echo esc_url(plugins_url('admin/images/byrst-step-2.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                class="byrst-img">
                        </figure>
                    </div>
                    <div class="column">
                        <p class="text-description"><?php esc_html_e('Step 3', 'byrst-3d-for-woocommerce'); ?></p>
                        <figure class="image is-square">
                            <img src="<?php echo esc_url(plugins_url('admin/images/byrst-step-3.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                class="byrst-img">
                        </figure>
                    </div>
                    <div class="column">
                        <p class="text-description"><?php esc_html_e('Step 4', 'byrst-3d-for-woocommerce'); ?></p>
                        <figure class="image is-square">
                            <img src="<?php echo esc_url(plugins_url('admin/images/byrst-step-4.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                class="byrst-img">
                        </figure>
                    </div>
                    <div class="column">
                        <p class="text-description"><?php esc_html_e('Step 5', 'byrst-3d-for-woocommerce'); ?></p>
                        <figure class="image is-square">
                            <img src="<?php echo esc_url(plugins_url('admin/images/byrst-step-5.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                class="byrst-img">
                        </figure>
                    </div>
                </div>
            </div>
            <div class="column is-one-quarter">
                <p class="third-title">
                    <?php esc_html_e('To use Byrst, you need to do the following:', 'byrst-3d-for-woocommerce'); ?>
                </p>
                <ul>
                    <li>
                        <p class="step">
                            <?php esc_html_e('Step 1: Download the Byrst app from the App Store', 'byrst-3d-for-woocommerce'); ?>
                        </p>
                    </li>
                    <li>
                        <p class="step">
                            <?php esc_html_e('Step 2: Pair your iOS app with your plugin', 'byrst-3d-for-woocommerce'); ?></p>
                    </li>
                    <li>
                        <p class="step">
                            <?php esc_html_e('Step 3: Generate 3D models via the iOS app', 'byrst-3d-for-woocommerce'); ?></p>
                    </li>
                    <li>
                        <p class="step">
                            <?php esc_html_e('Step 4: Activate E-commerce links to 3D models', 'byrst-3d-for-woocommerce'); ?>
                        </p>
                    </li>
                    <li>
                        <p class="step">
                            <?php esc_html_e('Step 5: Add 3D models to your product listings', 'byrst-3d-for-woocommerce'); ?>
                        </p>
                    </li>
                </ul>
                <div class="columns is-left">
                    <div class="column is-narrow">
                        <div class="buttons">
                            <a id="byrst-button-watch-tutorials"
                                href="<?php echo esc_url('https://tutorials.byrst.com/'); ?>" target="_blank"
                                class="button is-flex is-align-items-center is-justify-content-center">
                                <img src="<?php echo esc_url(plugins_url('admin/images/icon-byrst-tutorials.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                    width="24px" class="mr-6">
                                <span><?php esc_html_e('Tutorial', 'byrst-3d-for-woocommerce'); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>