<?php

/**
 * The Admin Product -specific functionality helper of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 */

/**
 * The Admin Product -specific functionality helper of the plugin.
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 * @author     Byrst
 */
class Byrst_Woocommerce_Plugin_Admin_Product
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
     * Fetch data models based on the access token.
     *
     * This function is responsible for fetching data models from an external source using an access token.
     * The function ensures proper permissions, nonce verification, and data validation.
     *
     * @return void Sends a JSON response to the client.
     */
    public function byrst_woocommerce_plugin_get_data_models()
    {
        //Nonce verification.
        // Ensures that the request was intentionally sent from the current site, protecting against certain types of attacks.
        if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['security'] ) ), 'byrst_nonce' ) ) {
            wp_send_json_error( array( 'message' => 'Nonce verification failed.' ) );
            $this->log_to_woocommerce( 'Nonce verification failed on byrst_woocommerce_plugin_get_data_models', 'error' );
            return;
        }

        // Capability check.
        // Check if the current user has the necessary permissions to perform this action.
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Insufficient permissions.'));
            $this->log_to_woocommerce('Insufficient permissions to perform byrst_woocommerce_plugin_get_data_models', 'error');
            return;
        }

        // Retrieve the complete plugin settings.
        $byrst_woocommerce_plugin_settings = get_option('byrst_woocommerce_plugin_settings');

        // Verify that the settings were retrieved and contains the expected keys.
        if (!$byrst_woocommerce_plugin_settings || !is_array($byrst_woocommerce_plugin_settings) || !isset($byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_access_token'])) {
            wp_send_json_error(array('message' => 'Plugin settings retrieval failed or settings are malformed.'));
            $this->log_to_woocommerce('Plugin settings retrieval failed or settings are malformed.', 'critical');
            return;
        }

        // Fetch the access token.
        $token = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_access_token'];

        // Validate that the token exists and has a valid format.
        // I'm just checking if it's not empty.
        if (!$token || empty(trim($token))) {
            wp_send_json_error(array('message' => 'Token fetch failed or token is has a invalid format.'));
            $this->log_to_woocommerce('Plugin settings retrieval failed or settings are malformed.', 'critical');
            return;
        }

        // Get the nextKey if exists in request.
        $nextKey = isset($_POST['nextKey']) ? sanitize_text_field($_POST['nextKey']) : null;

        // Fetch all models using the webtoken.
        $api = new Byrst_Woocommerce_Plugin_Api($this->plugin_name, $this->plugin_prefix, $this->version);
        $response_data = $api->byrst_woocommerce_plugin_fetch_all_models($token, $nextKey);

        // Validate that the response contains valid data.
        if (!$response_data || !is_array($response_data) || !isset($response_data['data'])) {
            wp_send_json_error(array('message' => 'Fetching models failed.'));
            $this->log_to_woocommerce('Fetching models failed on byrst_woocommerce_plugin_get_data_models', 'error');
            return;
        }

        // Send the fetched data and the nextKey as a successful JSON response.
        $response = array(
            'data' => $response_data['data'],
            'nextKey' => isset($response_data['nextKey']) ? $response_data['nextKey'] : null,
        );
        wp_send_json_success($response);
    }

    /**
     * Handles the request to retrieve data model information in a WooCommerce context.
     *
     * This function performs nonce verification, capability checks, and fetches
     * data using a specific model ID. It is designed to respond with JSON formatted data.
     *
     * @return void Sends a JSON response to the client.
     */

    public function byrst_woocommerce_plugin_get_data_model()
    {
        // Nonce verification for security
        if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['security'] ) ), 'byrst_nonce' ) ) {
            wp_send_json_error( array( 'message' => 'Nonce verification failed.' ) );
            $this->log_to_woocommerce( 'Nonce verification failed on byrst_woocommerce_plugin_get_data_model', 'error' );
            return;
        }

        // Capability check to ensure the current user has the required permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Insufficient permissions.'));
            $this->log_to_woocommerce('Insufficient permissions to perform byrst_woocommerce_plugin_get_data_model', 'error');
            return;
        }

        // Validation to check if 'model_id' is set and not empty
        if (!isset($_POST['model_id']) || empty(trim($_POST['model_id']))) {
            wp_send_json_error(array('message' => 'Not found a model_id.'));
            $this->log_to_woocommerce('Not found a model_id on byrst_woocommerce_plugin_get_data_model', 'warning');
            return;
        }

        // Sanitize 'model_id' to prevent security issues like XSS attacks
        $model_id = sanitize_text_field($_POST['model_id']);

        // Instantiate the API class and fetch the model data
        $api = new Byrst_Woocommerce_Plugin_Api($this->plugin_name, $this->plugin_prefix, $this->version);
        $response_data = $api->byrst_woocommerce_plugin_fetch_model($model_id);

        // Check if the response data is valid and is an array
        if (!$response_data || !is_array($response_data)) {
            wp_send_json_error(array('message' => 'Fetching model failed.'));
            $this->log_to_woocommerce('Fetching model failed on byrst_woocommerce_plugin_get_data_model', 'error');
            return;
        }

        // Send a successful JSON response with the fetched data
        wp_send_json_success($response_data);
    }

    /**
     * Saves 3D model data into custom fields associated with a WooCommerce product.
     *
     * This function handles an AJAX request to save various model attributes like Android and iOS models,
     * thumbnail, and model name into WooCommerce product custom fields.
     *
     * @return void Send a JSON response to the client.
     */
    public function byrst_woocommerce_save_models_in_custom_fields()
    {
        // Check the AJAX nonce for security.
        $nonce_verified = check_ajax_referer('byrst_nonce', 'security', false);

        // Return error if nonce verification fails.
        if (!$nonce_verified) {
            wp_send_json_error(['message' => 'Security check failed.']);
            return;
        }

        // Check if 'model_android' is set in the POST request.
        if (!isset($_POST['model_android'])) {
            wp_send_json_error(['message' => 'No 3D Model for Android found.']);
            return;
        }

        // Check if 'model_ios' is set in the POST request.
        if (!isset($_POST['model_ios'])) {
            wp_send_json_error(['message' => 'No 3D Model for iOS found.']);
            return;
        }

        // Check if 'product_id' is set in the POST request.
        if (!isset($_POST['product_id'])) {
            wp_send_json_error(['message' => 'No Product ID found.']);
            return;
        }

        // Check if 'model_thumbnail' is set in the POST request.
        if (!isset($_POST['model_thumbnail'])) {
            wp_send_json_error(['message' => 'No Thumbnail found.']);
            return;
        }

        // Check if 'model_name' is set in the POST request.
        if (!isset($_POST['model_name'])) {
            wp_send_json_error(['message' => 'No Model Name found.']);
            return;
        }

        // Sanitize and process the input data
        $product_id = preg_replace('/[^0-9]/', '', sanitize_text_field($_POST['product_id']));
        $model_android = sanitize_text_field($_POST['model_android']);
        $model_ios = sanitize_text_field($_POST['model_ios']);
        $thumbnail = sanitize_text_field($_POST['model_thumbnail']);
        $name = sanitize_text_field($_POST['model_name']);

        // Update the Android model custom field and handle errors
        $result_android = update_post_meta($product_id, 'byrst_woocommerce_plugin_file_android', $model_android);
        if (!$result_android) {
            wp_send_json_error(['message' => 'Error updating Android model field.']);
            $this->log_to_woocommerce('Error updating Android model field.', 'error');
            return;
        }

        // Update the iOS model custom field and handle errors
        $result_ios = update_post_meta($product_id, 'byrst_woocommerce_plugin_file_ios', $model_ios);
        if (!$result_ios) {
            wp_send_json_error(['message' => 'Error updating iOS model field.']);
            $this->log_to_woocommerce('Error updating iOS model field.', 'error');
            return;
        }

        // Update the thumbnail custom field and handle errors
        $result_thumbnail = update_post_meta($product_id, 'byrst_woocommerce_plugin_file_poster', $thumbnail);
        if (!$result_thumbnail) {
            wp_send_json_error(['message' => 'Error updating thumbnail field.']);
            $this->log_to_woocommerce('Error updating thumbnail field.', 'error');
            return;
        }

        // Update the model name custom field and handle errors
        $result_name = update_post_meta($product_id, 'byrst_woocommerce_plugin_file_alt', $name);
        if (!$result_name) {
            wp_send_json_error(['message' => 'Error updating model name field.']);
            $this->log_to_woocommerce('Error updating model name field.', 'error');
            return;
        }

        // Log the successful operation
        $this->log_to_woocommerce('3D Model from Byrst API saved in product ID: ' . $product_id . ' - DATA: 3D Model for Android - ' . $model_android . ' - 3D Model for IOS - ' . $model_ios . ' - Thumbnail - ' . $thumbnail . ' - Name - ' . $name);

        // Send a success response with saved data details
        wp_send_json_success(
            [
                'message' => 'Data saved successfully.',
                'id' => $product_id,
                'model_android' => $model_android,
                'model_ios' => $model_ios,
                'thumbnail' => $thumbnail,
                'name' => $name,
            ]
        );
    }

    /**
     * Removes 3D model data from custom fields associated with a WooCommerce product.
     *
     * This function handles an AJAX request to delete various model attributes like Android and iOS models,
     * thumbnail, and model name from WooCommerce product custom fields.
     * 
     * @return void Send a JSON response to the client.
     */
    public function byrst_woocommerce_remove_models_in_custom_fields()
    {
        // Verify the AJAX nonce for security
        $nonce_verified = check_ajax_referer('byrst_nonce', 'security', false);

        // Return error and log if nonce verification fails
        if (!$nonce_verified) {
            wp_send_json_error(['message' => 'Security check failed.']);
            $this->log_to_woocommerce('Nonce verification failed on byrst_woocommerce_remove_models_in_custom_fields', 'error');
            return;
        }

        // Check if 'product_id' is provided in the POST request
        if (!isset($_POST['product_id'])) {
            wp_send_json_error(['message' => 'No Product ID found.']);
            $this->log_to_woocommerce('No Product ID found on byrst_woocommerce_remove_models_in_custom_fields', 'error');
            return;
        }

        // Sanitize and process the product ID
        $product_id = preg_replace('/[^0-9]/', '', sanitize_text_field($_POST['product_id']));

        // Delete the Android model custom field and handle errors
        $result_android = delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_android');
        if (!$result_android) {
            wp_send_json_error(['message' => 'Error updating Android model field.']);
            $this->log_to_woocommerce('Error deleting Android model field in product ID: ' . $product_id, 'error');
            return;
        }

        // Delete the iOS model custom field and handle errors
        $result_ios = delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_ios');
        if (!$result_ios) {
            wp_send_json_error(['message' => 'Error updating iOS model field.']);
            $this->log_to_woocommerce('Error deleting iOS model field in product ID: ' . $product_id, 'error');
            return;
        }

        // Delete the thumbnail custom field and handle errors
        $result_thumbnail = delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_poster');
        if (!$result_thumbnail) {
            wp_send_json_error(['message' => 'Error updating thumbnail field.']);
            $this->log_to_woocommerce('Error deleting thumbnail field in product ID: ' . $product_id, 'error');
            return;
        }

        // Delete the model name custom field and handle errors
        $result_name = delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_alt');
        if (!$result_name) {
            wp_send_json_error(['message' => 'Error updating model name field.']);
            $this->log_to_woocommerce('Error deleting model name field in product ID: ' . $product_id, 'error');
            return;
        }

        // Log the successful deletion
        $this->log_to_woocommerce('3D Model data removed from product ID: ' . $product_id);

        // Send a success response
        wp_send_json_success(['message' => 'Data removed successfully.']);
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
