<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<hr class="hr-divider">
<div class="columns">
    <div class="column">
        <div class="is-flex is-align-items-center">
            <figure class="image">
                <img src="<?php echo esc_url(plugins_url('admin/images/icon-byrst-pair.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                    alt="<?php esc_attr_e('Pair with Byrst iOS app', 'byrst-3d-for-woocommerce');?>">
            </figure>
            <span class="title"><?php esc_html_e('Pair with Byrst iOS app', 'byrst-3d-for-woocommerce');?></span>
        </div>
        <div class="columns">
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <p class="text-instructions">
                            <?php esc_html_e('Input the 5-character code generated from your iOS app', 'byrst-3d-for-woocommerce'); ?>
                        </p>
                        <div class="field is-grouped">
                            <p class="control">
                                <input id="claim_id_1" type="text" class="input input-ios" maxlength="1">
                            </p>
                            <p class="control">
                                <input id="claim_id_2" type="text" class="input input-ios" maxlength="1">
                            </p>
                            <p class="control">
                                <input id="claim_id_3" type="text" class="input input-ios" maxlength="1">
                            </p>
                            <p class="control">
                                <input id="claim_id_4" type="text" class="input input-ios" maxlength="1"> 
                            </p>
                            <p class="control">
                                <input id="claim_id_5" type="text" class="input input-ios" maxlength="1">
                            </p>
                        </div>
                        <div class="buttons">
                            <button id="byrst-button-pair"
                                class="button is-flex is-align-items-center is-justify-content-center"> <!-- Se ha removido href de <button>, ya que no es válido para este elemento -->
                                <img src="<?php echo esc_url(plugins_url('/admin/images/icon-byrst-pair-white.svg', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                                    width="24px" class="mr-6">
                                <span><?php esc_html_e('Pair now', 'byrst-3d-for-woocommerce'); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="line-2 is-hidden-mobile is-hidden-tablet-only">
    <div class="column">
        <p class="secondary-title">
            <?php esc_html_e('How to locate pairing code on your iOS app', 'byrst-3d-for-woocommerce'); ?>
        </p>
        <div class="how-locate-code">
            <div class="columns">
                <div class="column">
                    <figure class="image is-square">
                        <img src="<?php echo esc_url(plugins_url('admin/images/image-byrst-pairing-guide.png', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME)); ?>"
                            class="byrst-img">
                    </figure>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <ul>
                        <li>
                            <p class="step-2"><?php esc_html_e('Step 1: Go to Byrst app - Settings', 'byrst-3d-for-woocommerce'); ?></p>
                        </li>
                        <li>
                            <p class="step-2"><?php esc_html_e('Step 2: Tap “Get pairing code” button', 'byrst-3d-for-woocommerce'); ?>
                            </p>
                        </li>
                        <li>
                            <p class="step-2">
                                <?php esc_html_e('Step 3: Input the 5-character code on the left', 'byrst-3d-for-woocommerce'); ?></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>