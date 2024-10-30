<?php
/**
 * The Api-specific functionality helper of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 */

/**
 * The Api-specific functionality helper of the plugin.
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/admin
 * @author     Byrst
 */
class Byrst_Woocommerce_Plugin_Api
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
     * Fetches a token from the Byrst API using a claim ID.
     *
     * This function sends a GET request to the Byrst API using a provided claim ID
     * to retrieve a token. If successful, it checks if the fetched token is different
     * from the one saved in the plugin's settings. If they differ, the function updates
     * the stored token with the new one.
     *
     * @return string|null The fetched token if successful, null otherwise.
     */
    public function byrst_woocommerce_plugin_fetch_token_by_claim_id()
    {
        // Step 1: Safely extract the claim ID from the settings.
        $claim_id = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_claim_id');

        // Step 3: Ensure claim ID exists and is not empty.
        if (empty($claim_id)) {
            $this->log_to_woocommerce('Claim ID missing or empty. Aborting API call.');
            return null;
        }

        // Sanitize the claim ID before using it in a URL.
        $claim_id = sanitize_text_field($claim_id);

        // Step 4: Define the API endpoint.
        $api_url = 'https://api.byrst.com/v2/token/claim?claim_id=' . $claim_id;

        // Step 5: Make the GET request to the API.
        $response = wp_remote_get($api_url, [
            'timeout' => 15, // Set an appropriate timeout.
        ]);

        // Step 6: Handle potential errors from the request.
        if (is_wp_error($response)) {
            $this->log_to_woocommerce('API request error: ' . $response->get_error_message());
            return null;
        }

        // Step 7: Decode the JSON response.
        $json_response = json_decode(wp_remote_retrieve_body($response), true);

        // Ensure the response is valid JSON and contains the token.
        if (!is_array($json_response) || !isset($json_response['token'])) {
            $this->log_to_woocommerce('Failed to decode JSON or token missing in response.');
            return null;
        }

        $token = $json_response['token'];

        // Step 8: Compare the fetched token with the one in the settings.
        $stored_token = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_access_token'] ?? null;
        if ($stored_token !== $token) {
            // Update and save the new token.
            $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_access_token'] = $token;
            update_option('byrst_woocommerce_plugin_settings', $byrst_woocommerce_plugin_settings);
            $this->log_to_woocommerce('Token updated in settings.');
        } else {
            $this->log_to_woocommerce('Fetched token matches stored token. No update required.');
        }

        return $token;
    }

    /**
     * Fetches all models from the Byrst API using a given token and an optional nextKey for pagination.
     *
     * This method sends a GET request to the Byrst API to retrieve a list of models, using pagination if a nextKey is provided.
     * It handles the API response, logging errors and returning the models' data along with the next pagination key if the request is successful.
     *
     * @param string      $token   The authorization token for the API request.
     * @param string|null $nextKey The pagination key for fetching the next set of models. Optional.
     * @return array|null An associative array containing the models' data and the next pagination key if successful, or null on failure.
     */
    public function byrst_woocommerce_plugin_fetch_all_models($token, $nextKey = null)
    {
        // Construct the API URL with a limit to the number of models fetched. Default is 25.
        $api_url = 'https://api.byrst.com/v2/projects/active?limit=25';

        // Append the nextKey to the API URL if it's provided, for pagination purposes.
        if ($nextKey) {
            $api_url .= '&nextKey=' . urlencode($nextKey);
        }

        // Execute a GET request to the API with the authorization token in the header.
        $response = wp_remote_get($api_url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token, // Authorization header with the bearer token.
            ),
            'timeout' => 15, // Set a timeout for the request (in seconds).
        ));

        // Check if the request resulted in an error.
        if (is_wp_error($response)) {
            // Log the error to WooCommerce and return null to indicate failure.
            $this->log_to_woocommerce('Error making the request: ' . $response->get_error_message());
            return null;
        }

        // Decode the JSON response into an associative array.
        $json_response = json_decode(wp_remote_retrieve_body($response), true);

        // Check if the response contains the 'data' key.
        if (isset($json_response['data'])) {
            // Prepare the data to be returned, including the nextKey if available.
            $data = $json_response['data'];
            $nextKey = isset($json_response['nextKey']) ? $json_response['nextKey'] : null;
            return array(
                'data' => $data,
                'nextKey' => $nextKey,
            );
        } else {
            // Log a message indicating failure to retrieve the model data from the response and return null.
            $this->log_to_woocommerce('Failed to retrieve the models data from the response.');
            return null;
        }
    }

    /**
     * Fetches a page of 3D models from the Byrst API.
     *
     * This method sends a GET request to the Byrst API to fetch a limited number of 3D models,
     * as specified by the query parameter 'limit'. It uses the provided access token for
     * authorization. If the request is successful, it returns the models data and the nextKey
     * for pagination; otherwise, it logs the error to WooCommerce and returns null.
     *
     * @param string $token The access token for authorization with the Byrst API.
     * @return array|null An associative array containing the 'data' of models and 'nextKey' for
     *                     pagination, or null on failure.
     */
    public function byrst_woocommerce_plugin_fetch_models_per_page($token)
    {
        // Define the API endpoint with a parameter to limit the number of models fetched.
        $api_url = 'https://api.byrst.com/v2/models?limit=1';

        // Execute a GET request to the API with the authorization token in the header.
        $response = wp_remote_get($api_url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token, // Include the token in the request header.
            ),
            'timeout' => 15, // Set a timeout for the request (in seconds).
        ));

        // Check if the request returned an error.
        if (is_wp_error($response)) {
            // Log the error message to WooCommerce.
            $this->log_to_woocommerce('Error making the request: ' . $response->get_error_message());
            return null; // Return null to indicate failure.
        }

        // Decode the JSON response into an associative array.
        $json_response = json_decode(wp_remote_retrieve_body($response), true);

        // Check if the response includes 'data' and 'nextKey'.
        if (isset($json_response['data']) && isset($json_response['nextKey'])) {
            // Return the models data and nextKey for pagination.
            return [
                'data' => $json_response['data'],
                'nextKey' => $json_response['nextKey'],
            ];
        } else {
            // Log a message indicating failure to retrieve the models data or nextKey and return null.
            $this->log_to_woocommerce('Failed to retrieve the models data or nextKey from the response.');
            return null;
        }
    }

    /**
     * Fetches a 3D model by its ID from the Byrst API.
     *
     * This method sends a GET request to the Byrst API to fetch a specific 3D model's details
     * using the model ID. It uses a saved access token for authorization. If the request is
     * successful and the model data is retrieved, it returns the data; otherwise, it logs
     * the error to WooCommerce and returns null.
     *
     * @param string $model_id The unique identifier for the 3D model to fetch.
     * @return array|null The model data as an associative array, or null on failure.
     */
    public function byrst_woocommerce_plugin_fetch_model($model_id)
    {
        // Retrieve the access token from plugin settings.
        $token = cmb2_get_option('byrst_woocommerce_plugin_settings', 'byrst_woocommerce_plugin_access_token');

        // Construct the API URL using the provided model ID.
        $api_url = 'https://api.byrst.com/v2/projects/active/' . $model_id;

        // Execute a GET request to the API endpoint with the authorization token.
        $response = wp_remote_get($api_url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token, // Include the token in the request header.
            ),
            'timeout' => 30, // Set a timeout for the request (in seconds).
        ));

        // Check if the request returned an error.
        if (is_wp_error($response)) {
            // Log the error message to WooCommerce.
            $this->log_to_woocommerce('Error making the request: ' . $response->get_error_message());
            return null; // Return null to indicate failure.
        }

        // Decode the JSON response into an associative array.
        $json_response = json_decode(wp_remote_retrieve_body($response), true);

        // Check if the response contains the expected data.
        if (isset($json_response)) {
            // Return the decoded data.
            $data = $json_response;
            return $data;
        } else {
            // Log a message indicating failure to retrieve model data and return null.
            $this->log_to_woocommerce('Failed to retrieve the model data from the response.');
            return null;
        }
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
        $context = array('source' => 'byrst-woocommerce-api');

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
