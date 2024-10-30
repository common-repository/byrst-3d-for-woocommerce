<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the admin-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 * @author     Byrst
 */
class Byrst_Woocommerce_Plugin_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The unique prefix of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
     */
    private $plugin_prefix;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name       The name of this plugin.
     * @param      string $plugin_prefix    The unique prefix of this plugin.
     * @param      string $version    The version of this plugin.
     */
    public function __construct($plugin_name, $plugin_prefix, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->plugin_prefix = $plugin_prefix;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     * @param string $hook_suffix The current admin page.
     */
    public function enqueue_styles($hook_suffix)
    {
        // Uncomment the following line for debugging to see the current $hook_suffix value.
        // echo '<h1 style="color: crimson;">' . esc_html($hook_suffix) . '</h1>';

        // Check if the current page is the settings page for the WooCommerce plugin.
        if ($hook_suffix == 'settings_page_byrst_woocommerce_plugin_settings') {
            // Enqueue a specific stylesheet for the plugin settings page.
            wp_enqueue_style($this->plugin_name . '-settings', plugin_dir_url(__FILE__) . 'css/byrst-woocommerce-plugin-admin-settings.css', array(), time(), 'all');
        }

        // Get the current screen object to determine the type of admin page.
        $screen = get_current_screen();

        // Check if the current screen is the product edit or add new page in WooCommerce.
        if ($screen->id === 'product') {
            // Enqueue a specific stylesheet for the WooCommerce product pages.
            wp_enqueue_style($this->plugin_name . '-product', plugin_dir_url(__FILE__) . 'css/byrst-woocommerce-plugin-admin-product.css', array(), time(), 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     * @param string $hook_suffix The current admin page.
     */
    public function enqueue_scripts($hook_suffix)
    {
        if ($hook_suffix == 'settings_page_byrst_woocommerce_plugin_settings') {
            // Create a nonce for security purposes - this will be used to verify the AJAX request.
            $settings_ajax_nonce = wp_create_nonce('byrst_nonce_settings');

            // Load text domain for script translations.
            wp_set_script_translations($this->plugin_name . '-settings', 'byrst-3d-for-woocommerce');

            wp_enqueue_script($this->plugin_name . '-settings', plugin_dir_url(__FILE__) . 'js/byrst-woocommerce-plugin-admin-settings-dist.js', array('jquery', 'wp-i18n'), time(), false);

            // Localize our script with necessary variables for AJAX.
            wp_localize_script($this->plugin_name . '-settings', 'ajax_object_settings', array(
                'ajax_url' => admin_url('admin-ajax.php'), // URL to WordPress AJAX processing file.
                'security' => $settings_ajax_nonce, // Pass the created nonce.
            ));
        }

        // Get the current screen object to determine the type of admin page.
        $screen = get_current_screen();

        // Check if the current screen is the product edit or add new page in WooCommerce.
        if ($screen->id === 'product') {
            // Create a nonce for security purposes - this will be used to verify the AJAX request.
            $nonce = wp_create_nonce('byrst_nonce');

            // Images URL for pass to JavaScript.
            $logo_url = esc_url(plugin_dir_url(__DIR__) . 'admin/images/byrst-logo.png');
            $air_sticker_url = esc_url(plugin_dir_url(__DIR__) . 'admin/images/icon-byrst-air-stickers.png');
            $model_url = esc_url(plugin_dir_url(__DIR__) . 'admin/images/icon-byrst-3d-blue.svg');
            $refresh_url = esc_url(plugin_dir_url(__DIR__) . 'admin/images/icon-byrst-refresh.svg');
            $null_url = esc_url(plugin_dir_url(__DIR__) . 'admin/images/icon-byrst-null.svg');
            $model_3d_app_url = esc_url(plugin_dir_url(__DIR__) . 'admin/images/image-byrst-active-3d-model.png');

            // Load text domain for script translations.
            wp_set_script_translations($this->plugin_name . '-product', 'byrst-3d-for-woocommerce');

            // Enqueue the main JavaScript file for this plugin.
            wp_enqueue_script($this->plugin_name . '-product', plugin_dir_url(__FILE__) . 'js/byrst-woocommerce-plugin-admin-product-dist.js', array('jquery', 'wp-i18n'), time(), false);

            // Localize our script with necessary variables for AJAX.
            wp_localize_script($this->plugin_name . '-product', 'ajax_object', array(
                'ajax_url' => admin_url('admin-ajax.php'), // URL to WordPress AJAX processing file.
                'nonce' => $nonce, // Pass the created nonce.
                'logo_url' => $logo_url,
                'air_sticker_url' => $air_sticker_url,
                'model_url' => $model_url,
                'refresh_url' => $refresh_url,
                'null_url' => $null_url,
                'model_3d_app_url' => $model_3d_app_url,
            ));
        }
    }

    /**
     * Filters the file type and extension for uploaded files.
     *
     * This function checks if the uploaded file has a .glb or .usdz extension
     * and modifies its MIME type accordingly. This is useful for adding support
     * for custom file types in WordPress uploads.
     *
     * @param array  $types    An array with keys 'ext' and 'type'. Both values might be a valid type, or one/some might be false.
     * @param array  $file     An array representing the file being uploaded.
     * @param string $filename The name of the file being uploaded.
     * @param array  $mimes    Key is the file extension with value as the mime type.
     *
     * @return array Modified array with file extension and MIME type.
     */
    public function byrst_woocommerce_plugin_file_and_ext($types, $file, $filename, $mimes)
    {
        // Check if the filename has a .glb extension.
        if (false !== strpos($filename, '.glb')) {
            $types['ext'] = 'glb'; // Set the file extension to 'glb'.
            $types['type'] = 'model/gltf-binary'; // Set the MIME type for .glb files.
        }

        // Check if the filename has a .usdz extension.
        if (false !== strpos($filename, '.usdz')) {
            $types['ext'] = 'usdz'; // Set the file extension to 'usdz'.
            $types['type'] = 'model/vnd.usdz+zip'; // Set the MIME type for .usdz files.
        }

        return $types; // Return the modified types.
    }

    /**
     * Adds Android - .gbl and IOS - .usdz filetype to allowed mimes.
     *
     * This function adds support for the .glb and .usdz file extensions in WordPress uploads by
     * adding their MIME types to the list of allowed MIME types.
     *
     * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
     * @param array $mimes Existing list of MIME types keyed by the file extension regex corresponding to those types.
     *
     * @return array Updated list of MIME types.
     */
    public function byrst_woocommerce_plugin_mime_types($mimes)
    {
        // Add the MIME type for .glb files, typically used on Android devices.
        $mimes['glb'] = 'model/gltf-binary';

        // Add the MIME type for .usdz files, typically used on iOS devices.
        $mimes['usdz'] = 'model/vnd.usdz+zip';

        // Return the updated list of MIME types.
        return $mimes;
    }

    /**
     * Sets up the metabox and field configurations for the plugin.
     *
     * This function includes necessary partials for the custom fields related to
     * products and settings in the WooCommerce plugin's admin area.
     *
     * @return void
     */
    public function byrst_woocommerce_plugin_cmb2_metaboxes()
    {
        // Load the configuration file for custom fields associated with products.
        include_once 'includes/byrst-woocommerce-plugin-admin-custom-fields-product.php';

        // Load the configuration file for custom fields associated with plugin settings.
        include_once 'includes/byrst-woocommerce-plugin-admin-custom-fields-settings.php';
    }

    /**
     * Executes before a CMB2 row has been displayed.
     *
     * This function includes the display partials for the WooCommerce plugin's admin area
     * once a CMB2 row has been rendered.
     *
     * @param array      $field_args The field's arguments.
     * @param CMB2_Field $field      The CMB2_Field object.
     *
     * @return void
     */
    public static function byrst_woocommerce_plugin_cmb2_before_row($field_args, $field)
    {
        // Load the partial file to display additional content or configurations in the admin area after a CMB2 row has been displayed.
        include_once 'partials/byrst-woocommerce-plugin-admin-display-settings.php';

        $claim_id = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_claim_id');

        if (isset($claim_id) && empty($claim_id)) {
            include_once 'partials/settings/byrst-woocommerce-plugin-admin-settings-nopair.php';
        } else {
            include_once 'partials/settings/byrst-woocommerce-plugin-admin-settings-pair.php';
        }
        echo "</div></div>";
    }

    /**
     * Displays a notice in the admin dashboard when the WooCommerce plugin is not installed.
     *
     * This function shows an error notice to inform the user that the WooCommerce plugin
     * needs to be installed for the "Byrst" plugin to work correctly.
     *
     * @return void
     */
    public function byrst_woocommerce_plugin_notice()
    {
        $message = __('Byrst is active but not working. You need to install the WooCommerce plugin for the plugin to work properly.', 'byrst-3d-for-woocommerce');

        echo '<div class="notice notice-error is-dismissible">';
        echo "<p>" . esc_html($message) . "</p>"; 
        echo '</div>';
    }

    /**
     * Force the use of WooCommerce's built-in gallery.
     *
     * This function is specifically tailored for compatibility with the Blocksy theme.
     * It ensures that the built-in WooCommerce gallery is used instead of any
     * gallery provided by the theme.
     *
     * @param mixed $current_value The current value being filtered.
     *
     * @return bool Returns true to indicate the use of WooCommerce's built-in gallery.
     */
    public function byrst_woocommerce_plugin_blocksy_fix($current_value)
    {
        return true;
    }

    /**
     * Display modal or information related to Byrst WooCommerce Plugin.
     *
     * This function checks the plugin's settings and displays relevant information
     * or prompts for the user. It ensures that users are properly guided regarding
     * the configuration and usage of the Byrst API.
     *
     * @return void
     */
    public static function byrst_woocommerce_plugin_modal()
    {
        $product_id = get_the_ID();

        // Retrieve the plugin settings.
        $byrst_woocommerce_plugin_settings = get_option('byrst_woocommerce_plugin_settings');

        // Fetch claim_id and access_token, if available.
        $claim_id = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_claim_id');
        $access_token = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_access_token');

        // Get the fields value of 3D model

        // Get the file url for android
        $get_android_file = get_post_meta($product_id, 'byrst_woocommerce_plugin_file_android', true);
        // Get the file url for iOS
        $get_ios_file = get_post_meta($product_id, 'byrst_woocommerce_plugin_file_ios', true);

        echo "<div id='byrst-content'></div>";
    }

    /**
     * Handles the AJAX request to get data view for the WooCommerce plugin.
     *
     * This function checks for a valid nonce for security, sanitizes and validates
     * the 'product_id' from the POST request, retrieves relevant meta data, and
     * includes the appropriate partial view file based on the retrieved data.
     */
    public function byrst_woocommerce_plugin_get_data_view()
    {
        // Check the AJAX nonce for security.
        $nonce_verified = check_ajax_referer('byrst_nonce', 'security', false);

        // Verify if the nonce is valid.
        if (!$nonce_verified) {
            wp_send_json_error(['message' => 'Security check failed.']);
            $this->log_to_woocommerce('Security check failed.', 'error');
            return;
        }

        // Check if 'product_id' is set in the POST request and sanitize it.
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

        // Check if the product ID is valid.
        if ($product_id <= 0) {
            wp_send_json_error(['message' => 'Invalid or no Product ID found.']);
            $this->log_to_woocommerce('Invalid or no Product ID found.', 'error');
            return;
        }

        // Retrieve plugin settings.
        $claim_id = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_claim_id');
        $access_token = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_access_token');

        // Retrieve file meta data for Android and iOS, along with alt text and poster image.
        $get_android_file = get_post_meta($product_id, 'byrst_woocommerce_plugin_file_android');
        $get_ios_file = get_post_meta($product_id, 'byrst_woocommerce_plugin_file_ios');
        $get_alt = get_post_meta($product_id, 'byrst_woocommerce_plugin_file_alt', true);
        $get_poster = get_post_meta($product_id, 'byrst_woocommerce_plugin_file_poster', true);

        // Determine the appropriate file to include based on the available data.
        if (empty($claim_id) || empty($access_token)) {
            $file = 'partials/product/byrst-woocommerce-plugin-admin-display-product-no-pair.php';
        } elseif (empty($get_android_file) || empty($get_ios_file)) {
            $file = 'partials/product/byrst-woocommerce-plugin-admin-display-product-buttton.php';
        } else {
            $file = 'partials/product/byrst-woocommerce-plugin-admin-display-product-pair.php';
        }

        // Build the full path to the file.
        $file_path = plugin_dir_path(__FILE__) . $file;

        // Start output buffering to capture the included file's content.
        ob_start();
        include_once $file_path;
        $file_content = ob_get_clean(); // Retrieve the content and clean the output buffer.

        // Send the file content in the AJAX response.
        wp_send_json_success(
            [
                'message' => 'Loading content.',
                'content' => $file_content,
            ]
        );
    }

    /**
     * Logs messages to WooCommerce system with varying levels of severity.
     *
     * This function checks if logging is enabled in the plugin's settings and, if so,
     * logs messages using WooCommerce's logging system based on the specified level.
     *
     * @param string $message The message to be logged.
     * @param string $level   The severity level of the log. Default is 'info'.
     */
    public function log_to_woocommerce($message, $level = 'info')
    {
        // Retrieve the logging setting from the plugin options using CMB2 library.
        $log_active = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_enable_error_logs');

        // Check if logging is enabled in the plugin's settings.
        if (!$log_active) {
            // If logging is not enabled, exit the function without logging.
            return;
        }

        // Obtain an instance of WooCommerce's WC_Logger class.
        $logger = wc_get_logger();

        // Define the logging context, specifically indicating the source of the log.
        // Replace 'sap-woocommerce' with the actual source name or plugin name.
        $context = array('source' => 'byrst-woocommerce');

        // Log the message at the specified severity level.
        switch ($level) {
            case 'emergency':
                $logger->emergency($message, $context);
                break;
            case 'alert':
                $logger->alert($message, $context);
                break;
            case 'critical':
                $logger->critical($message, $context);
                break;
            case 'error':
                $logger->error($message, $context);
                break;
            case 'warning':
                $logger->warning($message, $context);
                break;
            case 'notice':
                $logger->notice($message, $context);
                break;
            case 'info':
                // The default logging level is 'info'.
                $logger->info($message, $context);
                break;
            case 'debug':
                $logger->debug($message, $context);
                break;
            default:
                // If an unrecognized level is specified, default to 'info' level.
                $logger->info($message, $context);
        }
    }
}
