<?php

/**
 * The Admin Product Settings specific functionality helper of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 */

/**
 * The Admin Product Settings specific functionality helper of the plugin.
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 * @author     Byrst
 */
class Byrst_Woocommerce_Plugin_Admin_Settings
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
     * Removes the claim ID and token settings for Byrst.
     *
     * @return void
     */
    public function byrst_settings_remove_claim_id_and_token()
    {
        /**
         * Check the AJAX nonce for security.
         *
         * @var boolean $nonce_verified Verifies the nonce for security.
         */
        $nonce_verified = check_ajax_referer('byrst_nonce_settings', 'security', false);

        /**
         * Verify if the nonce is valid.
         * If not, send a JSON error response and return.
         */
        if (!$nonce_verified) {
            wp_send_json_error(['message' => 'Security check failed. Try again.']);
            return;
        }

        /**
         * Check if 'claim_id' is set in the POST request.
         * If set, send a JSON error response and return.
         */
        if (isset($_POST['claim_id'])) {
            wp_send_json_error(['message' => 'No pair code with Byrst App found.']);
            return;
        }

        /**
         * Update the option to remove the claim ID.
         * This sets the 'byrst_woocommerce_plugin_claim_id' option to an empty string.
         *
         * @var bool $claim_id_removed Indicates if the claim ID was successfully removed.
         */
        $claim_id_removed = cmb2_update_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_claim_id', '');

        /**
         * Update the option to remove the access token.
         * This sets the 'byrst_woocommerce_plugin_access_token' option to an empty string.
         *
         * @var bool $access_token_removed Indicates if the access token was successfully removed.
         */
        $access_token_removed = cmb2_update_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_access_token', '');

        /**
         * Define query arguments to retrieve products with specific custom fields.
         *
         * @var array $args Arguments for WP_Query to get products.
         */
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'byrst_woocommerce_plugin_file_android',
                    'value' => '',
                    'compare' => '!=',
                ),
                array(
                    'key' => 'byrst_woocommerce_plugin_file_ios',
                    'value' => '',
                    'compare' => '!=',
                ),
            ),
        );

        /**
         * Retrieve the products based on the defined criteria.
         *
         * @var array $products List of products that match the query.
         */
        $products = get_posts($args);

        /**
         * Loop through each product and remove custom fields.
         */
        foreach ($products as $product) {
            $product_id = $product->ID;

            // Remove custom fields related to Byrst app from each product.
            delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_android');
            delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_ios');
            delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_alt');
            delete_post_meta($product_id, 'byrst_woocommerce_plugin_file_poster');
        }

        /**
         * Check if both updates (claim ID and token) were successful.
         */
        if ($claim_id_removed && $access_token_removed) {
            // If both updates are successful, send a success message.
            wp_send_json_success(['message' => 'Pairing code for Byrst app has been successfully removed.']);
        } else {
            // If either update fails, send an error message.
            wp_send_json_error(['message' => 'An error occurred while deleting the Pairing Code for the Byrst app.']);
        }
    }

    /**
     * Handles the saving of claim ID and token for Byrst settings.
     *
     * @return void
     */
    public function byrst_settings_save_claim_id_and_token()
    {
        /**
         * Check the AJAX nonce for security.
         *
         * @var boolean $nonce_verified Verifies the nonce for security.
         */
        $nonce_verified = check_ajax_referer('byrst_nonce_settings', 'security', false);

        /**
         * Verify if the nonce is valid.
         * If not, send a JSON error response and return.
         */
        if (!$nonce_verified) {
            wp_send_json_error(['message' => 'Security check failed. Try again.']);
            return;
        }

        /**
         * Check if 'claim_id' is not set in the POST request.
         * If not, send a JSON error response and return.
         */
        if (!isset($_POST['claim_id'])) {
            wp_send_json_error(['message' => 'No pair code with Byrst App found.']);
            return;
        }

        /**
         * Retrieve 'claim_id' from POST request.
         *
         * @var string $claim_id The claim ID received in the POST request.
         */
        $claim_id = isset($_POST['claim_id']) ? sanitize_text_field($_POST['claim_id']) : '';

        /**
         * Verify that 'claim_id' contains only letters and numbers.
         * If not, send a JSON error response and return.
         */
        if (!preg_match('/^[a-zA-Z0-9]+$/', $claim_id)) {
            wp_send_json_error(['message' => 'The pair code for Byrst App should only contain letters and numbers.']);
            return;
        }

        /**
         * Sanitize the claim ID before using it.
         *
         * @var string $claim_id Sanitized claim ID.
         */
        $claim_id = sanitize_text_field($claim_id);

        /**
         * Define the API endpoint.
         *
         * @var string $api_url API endpoint URL.
         */
        $api_url = 'https://api.byrst.com/v2/token/claim?claim_id=' . $claim_id;

        /**
         * Make the GET request to the API.
         *
         * @var array|WP_Error $response Response from the API or WP_Error.
         */
        $response = wp_remote_get($api_url, ['timeout' => 30]);

        /**
         * Handle potential errors from the request.
         * If there's an error, send a JSON error response and return.
         */
        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'API request error.', 'error_details' => $response->get_error_message()]);
            return;
        }

        /**
         * Decode the JSON response.
         *
         * @var array $json_response Decoded JSON response.
         */
        $json_response = json_decode(wp_remote_retrieve_body($response), true);

        /**
         * Ensure the response is valid JSON and contains the token.
         * If not, send a JSON error response and return.
         */
        if (!is_array($json_response) || !isset($json_response['token'])) {
            wp_send_json_error(['message' => 'Could not decode JSON or missing token in response when getting Token from Byrst App.']);
            return;
        }

        /**
         * Token from the JSON response.
         *
         * @var string $token Token received in the JSON response.
         */
        $token = $json_response['token'];

        /**
         * Update the option with the new claim ID and token.
         *
         * @var bool $claim_id_saved Indicates if the claim ID was saved successfully.
         * @var bool $token_saved Indicates if the token was saved successfully.
         */
        $claim_id_saved = cmb2_update_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_claim_id', $claim_id);
        $token_saved = cmb2_update_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_access_token', $token);

        /**
         * Send a success or error response based on whether the claim ID and token were saved.
         */
        if ($token_saved && $claim_id_saved) {
            wp_send_json_success(['message' => 'Token and Claim ID for Byrst app saved.']);
        } else {
            wp_send_json_error(['message' => 'Error saving Token for Byrst application.']);
        }
    }

}
