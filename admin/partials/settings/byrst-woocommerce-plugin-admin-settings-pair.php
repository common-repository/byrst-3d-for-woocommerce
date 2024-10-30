<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<hr class="hr-divider">
<div class="columns is-vcentered is-centered">
    <div class="column">
        <div class="is-flex is-align-items-center">
            <figure class="image">
                <img src="<?php echo esc_url(plugins_url('/admin/images/icon-byrst-pair-green.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                    alt="<?php esc_attr_e('The Byrst Platform', 'byrst-3d-for-woocommerce');?>">
            </figure>
            <span class="last-title"><?php esc_html_e('You are paired with the Byrst app', 'byrst-3d-for-woocommerce');?></span>
        </div>
    </div>
</div>
<div class="columns">
    <div class="column">
        <div class="buttons">
            <button id="byrst-button-unpair" class="button is-flex is-align-items-center is-justify-content-center">
                <img src="<?php echo esc_url(plugins_url('/admin/images/icon-byrst-pair-white.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                    width="24px" class="mr-2">
                <span><?php esc_html_e('Unpair', 'byrst-3d-for-woocommerce'); ?></span>
            </button>
        </div>
    </div>
</div>