<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/public
 * @author     Byrst
 */
class Byrst_Woocommerce_Plugin_Public
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
     * @param      string $plugin_name      The name of the plugin.
     * @param      string $plugin_prefix          The unique prefix of this plugin.
     * @param      string $version          The version of this plugin.
     */
    public function __construct($plugin_name, $plugin_prefix, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->plugin_prefix = $plugin_prefix;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/byrst-woocommerce-plugin-public.css', array(), $this->version, 'all');
        wp_enqueue_style('jquery-ui-theme', plugin_dir_url(__FILE__) . 'css/jquery-ui.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        // Register the script.
        wp_enqueue_script(
            $this->plugin_name . '-model-viewer', // Handle for the script. This is used as a unique identifier for the script in WordPress.
            plugins_url('public/js/model-viewer.min.js', BYRST_WOOCOMMERCE_PLUGIN_BASE_NAME), // The URL to the script file. `plugins_url` function generates a full URL to the script in your plugin directory.
            array('jquery'), // Array of handles of any scripts that this script depends on, jquery in this case. These must be loaded before this script.
            $this->version, // The version number of the script. This can be used for cache busting.
            true// Whether to place the script in the footer. `true` means the script will be placed before the closing body tag.
        );

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/byrst-woocommerce-plugin-public-dist.js', array('jquery'), $this->version, true);
        wp_enqueue_script('jquery-ui-dialog');
    }

    /**
     * Adds attributes to the script tag for a specific enqueued script.
     *
     * This method is designed to modify the script tag of an enqueued script
     * by adding additional attributes, such as 'type'='module', which is necessary
     * for modern JavaScript modules. It utilizes the 'script_loader_tag' filter
     * in WordPress to adjust the script tag before it's printed to the HTML document.
     *
     * @param string $tag    The HTML `<script>` tag of the enqueued script.
     * @param string $handle The script's registered handle in WordPress.
     * @param string $src    The script's source URL.
     *
     * @return string The modified script tag if the handle matches, otherwise the original tag.
     */
    public function byrst_woocommerce_plugin_add_attributes($tag, $handle, $src)
    {
        // Check if the enqueued script's handle matches the one we want to modify.
        // `$this->plugin_name . '-model-viewer'` should be replaced with the actual
        // script handle that was used when the script was enqueued.
        if ($handle === $this->plugin_name . '-model-viewer') {
            // Use wp_get_script_tag to generate the script tag with desired attributes.
            // This function allows adding or modifying attributes of the script tag.
            // Here, 'type' => 'module' is added to enable ES6 module support for the script.
            $tag = wp_get_script_tag([
                'src' => $src, // The source URL of the script is included.
                'type' => 'module', // Adding the 'type' attribute with value 'module'.
                // Add any other necessary attributes here.
            ]);
        }

        // Return the modified script tag if the handle matches, otherwise return the original tag.
        return $tag;
    }

    /**
     * Example of Shortcode processing function.
     *
     * Shortcode can take attributes like [byrst-woocommerce-plugin shortcode attribute='123']
     * Shortcodes can be enclosing content [byrst-woocommerce-plugin shortcode attribute='123']custom content[/byrst-woocommerce-plugin-shortcode].
     *
     * @see https://developer.wordpress.org/plugins/shortcodes/enclosing-shortcodes/
     *
     * @since    1.0.0
     * @param    array  $atts    ShortCode Attributes.
     * @param    mixed  $content ShortCode enclosed content.
     * @param    string $tag    The Shortcode tag.
     */
    public function byrst_woocommerce_plugin_shortcode_func($atts, $content, $tag)
    {

        /**
         * Combine user attributes with known attributes.
         *
         * @see https://developer.wordpress.org/reference/functions/shortcode_atts/
         *
         * Pass third paramter $shortcode to enable ShortCode Attribute Filtering.
         * @see https://developer.wordpress.org/reference/hooks/shortcode_atts_shortcode/
         */
        $atts = shortcode_atts(
            array(
                'attribute' => 123,
            ),
            $atts,
            $this->plugin_prefix . 'shortcode'
        );

        /**
         * Build our ShortCode output.
         * Remember to sanitize all user input.
         * In this case, we expect a integer value to be passed to the ShortCode attribute.
         *
         * @see https://developer.wordpress.org/themes/theme-security/data-sanitization-escaping/
         */
        $out = intval($atts['attribute']);

        /**
         * If the shortcode is enclosing, we may want to do something with $content
         */
        if (!is_null($content) && !empty($content)) {
            $out = do_shortcode($content); // We can parse shortcodes inside $content.
            $out = intval($atts['attribute']) . ' ' . sanitize_text_field($out); // Remember to sanitize your user input.
        }

        // ShortCodes are filters and should always return, never echo.

        return $out;

    }

    /**
     * Renders the augmented reality (AR) button for WooCommerce products.
     *
     * This method checks if the product has associated AR models for both Android and iOS.
     * If it does, it retrieves the plugin settings for the AR button appearance and behavior.
     * The final step is to include the template that displays the AR button to the user.
     *
     * @global WP_Post $product The global product object provided by WooCommerce.
     *
     * @return void
     */
    public function byrst_woocommerce_plugin_button()
    {
        // Global product variable
        global $product;

        //Get the file url for android
        $get_android_file = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_android', true);
        //Get the fiel url for IOS
        $get_ios_file = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_ios', true);
        //Get the alt for web accessibility
        $get_alt = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_alt', true);
        //Get the Poster
        $get_poster = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_poster', true);

        // Check if the customs fields has a value.
        if (!empty($get_android_file)) {
            $android_file_url = $get_android_file;
        }
        if (!empty($get_ios_file)) {
            $ios_file_url = $get_ios_file;
        }
        if (!empty($get_alt)) {
            $alt_description = sanitize_text_field($get_alt);
        } else {
            $alt_description = $product->get_name();
        }
        if (!empty($get_poster)) {
            $poster_file_url = $get_poster;
        } else {
            $poster_file_url = wp_get_attachment_url($product->get_image_id());
        }

        /**
         * If product not have a 3D Model for IOS or Android - Hide the button
         */
        if (!empty($android_file_url) & !empty($ios_file_url)) {
            /**
             * Get the CMB2 Options or plugin options
             */
            $byrst_woocommerce_plugin_settings = get_option('byrst_woocommerce_plugin_settings');

            /**
             * Get the Loading Type from plugin settings
             * @see: https://modelviewer.dev/docs/#entrydocs-loading-attributes-loading
             */
            $loading_type = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_loading'];
            /**
             * Check the value of $loading_type and return the $loading_type
             * @param string $loading_type
             */
            $loading = $this->byrst_woocommerce_plugin_loading_type($loading_type);

            /**
             * Get th Reveal Type from plugin settings
             * @see: https://modelviewer.dev/docs/#entrydocs-loading-attributes-reveal
             */
            $reveal_type = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_reveal'];
            /**
             * Check the value of $reveal_type and return the $reveal_type
             * @param string $reveal_type
             */
            $reveal = $this->byrst_woocommerce_plugin_reveal_type($reveal_type);

            /**
             * AR Settings
             */

            /**
             * Get the --poster-color from plugin settings
             * @see: https://modelviewer.dev/docs/#entrydocs-augmentedreality-attributes-ar
             */
            $ar_active = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar'];
            /**
             * Check the value of $ar_active and return the $ar_active
             * @param string $ar_active
             */
            $ar = $this->byrst_woocommerce_plugin_ar($ar_active);

            /**
             * Get the ar-modes from plugin settings
             * @see: https://modelviewer.dev/docs/#entrydocs-augmentedreality-attributes-arModes
             */
            $ar_mode = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar_modes'];
            /**
             * Check the value of $ar_active and return the $ar_active
             * @param string $ar_active
             */
            $ar_modes = $this->byrst_woocommerce_plugin_ar_modes($ar_mode);

            /**
             * Get the ar scale from plugin settings
             * @see: https://modelviewer.dev/docs/index.html#entrydocs-augmentedreality-attributes-arScale
             */
            $ar_scale = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar_scale'];
            /**
             * Check the value of $ar_scale and return the $ar_scale
             * @param string $ar_scale
             */
            $ar_scale_mode = $this->byrst_woocommerce_plugin_ar_scale($ar_scale);

            /**
             * Get the ar placement from plugin settings
             * @see: https://modelviewer.dev/docs/index.html#entrydocs-augmentedreality-attributes-arPlacement
             */
            $ar_placement = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar_placement'];
            /**
             * Check the value of $ar_placement and return the $ar_placement
             * @param string $ar_placement
             */
            $ar_placement_mode = $this->byrst_woocommerce_plugin_ar_placement($ar_placement);

            /**
             * Get the xr_enviroment from plugin settings
             * @see: https://modelviewer.dev/docs/index.html#entrydocs-augmentedreality-attributes-xrEnvironment
             */
            $xr_environment = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_xr_environment'];
            /**
             * Check the value of xr_enviroment and return the $xr_enviroment
             * @param string $xr_enviroment
             */
            $xr_environment_mode = $this->byrst_woocommerce_plugin_ar_xr_environment($xr_environment);

            /**
             * AR Button Settings
             */

            /**
             * Get the custom btn option from plugin settings
             * @see: https://modelviewer.dev/docs/#entrydocs-augmentedreality-slots-arButton
             */
            $ar_btn_custom = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar_button'];
            /**
             * Check ar button custom is active
             */
            $this->byrst_woocommerce_plugin_ar_btn_custom($ar_btn_custom);

            // Get the custom text btn
            $ar_btn_custom_text = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar_button_text'];
            // Get the custom backgrund btn
            $ar_btn_custom_background = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar_button_background_color'];
            // Get the custom text color btn
            $ar_btn_custom_text_color = $byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_ar_button_text_color'];

            //Include the HTML for display the modal and the HTML content with a lilte bit PHP
            include_once 'partials/byrst-woocommerce-plugin-public-display-button.php';
        }
    }

    /**
     * Add a custom tab for viewing the product in 3D on the product page.
     *
     * @param array $tabs The existing tabs.
     * @return array The updated tabs with the new "View Product in 3D" tab.
     */
    public function byrst_woocommerce_plugin_tab($tabs)
    {
        // Add a new tab for viewing the product in 3D
        $tabs['ar_model_viewer'] = array(
            'title' => __('View Product in 3D', 'byrst-3d-for-woocommerce'), // Tab title
            'priority' => 50, // Position/order of the tab
            'callback' => array(__CLASS__, 'byrst_woocommerce_plugin_tab_content'), // Function to call for tab content
        );

        return $tabs; // Return the updated tabs array
    }

    /**
     * Render the content for the custom "View Product on 3D" tab on the product page.
     *
     * This function retrieves custom meta values for the product related to AR/3D viewing,
     * such as the file URLs for different platforms, alt text for accessibility, and a poster image.
     * If these meta values aren't set, the function sets default values. At the end,
     * the function includes a display template to present the 3D viewer to the user.
     *
     * @return void
     */
    public static function byrst_woocommerce_plugin_tab_content()
    {
        // Make the product global variable accessible within the function.
        global $product;

        // Retrieve the Android file URL from the product's meta data.
        $get_android_file = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_android', true);

        // Retrieve the iOS file URL from the product's meta data.
        $get_ios_file = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_ios', true);

        // Retrieve the alternative text for web accessibility from the product's meta data.
        $get_alt = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_alt', true);

        // Retrieve the poster image URL from the product's meta data.
        $get_poster = get_post_meta($product->get_id(), 'byrst_woocommerce_plugin_file_poster', true);

        // Assign the Android file URL if it's set; otherwise, skip.
        if (!empty($get_android_file)) {
            $android_file_url = $get_android_file;
        }

        // Assign the iOS file URL if it's set; otherwise, skip.
        if (!empty($get_ios_file)) {
            $ios_file_url = $get_ios_file;
        }

        // Assign the alt text, ensuring it's sanitized. If not set, use the product name.
        if (!empty($get_alt)) {
            $alt_description = sanitize_text_field($get_alt);
        } else {
            $alt_description = $product->get_name();
        }

        // Assign the poster image URL. If not set, use the product's main image.
        if (!empty($get_poster)) {
            $poster_file_url = $get_poster;
        } else {
            $poster_file_url = wp_get_attachment_url($product->get_image_id());
        }

        // Include the display template to showcase the AR/3D viewer to the user.
        include 'partials/byrst-woocommerce-plugin-public-display.php';
    }

    /**
     * Determine the appropriate 'loading' attribute value for content based on the input parameter.
     *
     * The 'loading' attribute can be used on certain HTML elements to provide hints
     * on how the content should be loaded in relation to the viewport.
     *
     * @param int $loading An integer indicating the loading type (1: auto, 2: lazy, 3: eager).
     * @return string The string representation of the 'loading' attribute value.
     */
    public function byrst_woocommerce_plugin_loading_type($loading)
    {
        // Switch case to determine the loading attribute based on input
        switch ($loading) {
            case 1:
                // 'auto' loading behavior: Let the browser determine the best loading method.
                return 'auto';
            case 2:
                // 'lazy' loading behavior: Defers loading of the content until it reaches a calculated distance from the viewport.
                return 'lazy';
            case 3:
                // 'eager' loading behavior: Loads the content immediately, regardless of where it's located relative to the viewport.
                return 'eager';
            default:
                // If no valid input is provided, return an empty string to indicate no 'loading' attribute should be added.
                return '';
        }
    }

    /**
     * Determine the appropriate 'reveal' attribute value for content based on the input parameter.
     *
     * The 'reveal' attribute provides hints on how the content should be revealed
     * or shown in the user interface.
     *
     * @param int $reveal An integer indicating the reveal type (1: auto, 2: interaction, 3: manual).
     * @return string The string representation of the 'reveal' attribute value.
     */
    public function byrst_woocommerce_plugin_reveal_type($reveal)
    {
        // Determine the appropriate 'reveal' attribute value based on the provided input.
        switch ($reveal) {
            case 1:
                // Use 'auto' reveal behavior: Content reveal behavior is determined automatically by the system.
                return 'auto';
                break;
            case 2:
                // Use 'interaction' reveal behavior: Content is revealed upon some form of user interaction.
                return 'interaction';
                break;
            case 3:
                // Use 'manual' reveal behavior: Content reveal is handled manually through scripting or other methods.
                return 'manual';
                break;
            default:
                // If no valid input is provided, return the input value as-is.
                return $reveal;
                break;
        }
    }

    /**
     * Determine the appropriate poster color based on the input parameter.
     *
     * This function returns the specified poster color if it's set. If not, it defaults to 'transparent'.
     *
     * @param string $poster_color The desired color for the poster. Can be any valid CSS color value.
     * @return string The chosen poster color, or 'transparent' if no valid color was provided.
     */
    public function byrst_woocommerce_plugin_poster_color($poster_color)
    {
        // Check if the provided poster color is set.
        if (isset($poster_color)) {
            // If set, return the provided poster color.
            return $poster_color;
        } else {
            // If not set, default to 'transparent'.
            $poster_color = 'transparent';
            return $poster_color;
        }
    }

    /**
     * Determine if the 'ar' attribute should be added based on the provided input.
     *
     * This function checks if the 'ar' attribute should be set for a particular element. If the input `$ar` is set
     * and equals to 1, it will return 'ar'. Otherwise, it will return an empty string.
     *
     * @param int $ar The flag indicating whether the 'ar' attribute should be set (1) or not.
     * @return string Returns 'ar' if the condition is met, otherwise returns an empty string.
     */
    public function byrst_woocommerce_plugin_ar($ar)
    {
        // Check if the provided value for $ar is set and equals to 1.
        if (isset($ar) && $ar == 1) {
            // If the condition is met, return 'ar'.
            return 'ar';
        } else {
            // If the condition is not met, return an empty string.
            return '';
        }
    }

    /**
     * Construct a string of AR modes based on the provided input.
     *
     * This function processes the given `$ar_mode` array and determines the appropriate
     * AR modes ('webxr', 'scene-viewer', 'quick-look') to be set for a particular element.
     *
     * @param array $ar_mode An array of integers representing different AR modes.
     * @return string Returns a space-separated string of the AR modes based on the input array.
     */
    public function byrst_woocommerce_plugin_ar_modes($ar_mode)
    {
        if (!is_array($ar_mode)) {
            // If $ar_mode is not an array, return an empty string to avoid errors.
            return '';
        }

        $modes = [];

        foreach ($ar_mode as $mode_for_ar) {
            switch ($mode_for_ar) {
                case 1:
                    $modes[] = 'webxr';
                    break;
                case 2:
                    $modes[] = 'scene-viewer';
                    break;
                case 3:
                    $modes[] = 'quick-look';
                    break;
            }
        }

        // Combine the set modes into a single space-separated string.
        $ar_mode_combined = implode(' ', $modes);

        return $ar_mode_combined;
    }

    /**
     * Determine the AR scale attribute value based on the provided input.
     *
     * This function processes the given `$scale` parameter and returns the appropriate
     * AR scale attribute value for a model-viewer element.
     *
     * @param int $scale An integer representing the AR scale mode.
     * @return string Returns the corresponding AR scale attribute value based on the input.
     */
    public function byrst_woocommerce_plugin_ar_scale($scale)
    {
        // Switch on the provided $scale value to determine the corresponding AR scale attribute.
        switch ($scale) {
            case 1:
                return 'auto';
            case 2:
                return 'fixed';
            default:
                // It's a good practice to have a controlled default value
                return 'auto'; // or 'fixed', depending on what makes more sense as a default
        }
    }

    /**
     * Determine the AR placement attribute value based on the provided input.
     *
     * This function processes the given `$placement` parameter and returns the appropriate
     * AR placement attribute value for a model-viewer element.
     *
     * @param int $placement An integer representing the AR placement mode.
     * @return string Returns the corresponding AR placement attribute value based on the input.
     */
    public function byrst_woocommerce_plugin_ar_placement($placement)
    {
        // Switch on the provided $placement value to determine the corresponding AR placement attribute.
        switch ($placement) {
            case 1:
                // If the value is 1, set the placement mode to "floor".
                return 'floor';
                break;
            case 2:
                // If the value is 2, set the placement mode to "wall".
                return 'wall';
                break;
            default:
                // For any other value, return the original $placement value.
                return $placement;
                break;
        }
    }

    /**
     * Determine the AR XR environment attribute value based on the provided input.
     *
     * This function processes the given `$xr` parameter and returns the appropriate
     * XR environment attribute value for a model-viewer element.
     *
     * @param int $xr An integer representing the XR environment mode.
     * @return string Returns the corresponding XR environment attribute value based on the input.
     */
    public function byrst_woocommerce_plugin_ar_xr_environment($xr)
    {
        // Switch on the provided $xr value to determine the corresponding XR environment attribute.
        switch ($xr) {
            case 1:
                // If the value is 1, set the XR environment mode to "xr-environment".
                return 'xr-environment';
                break;
            case 2:
                // If the value is 2, the XR environment mode is disabled, so return an empty string.
                return '';
                break;
            default:
                // For any other value, return the original $xr value.
                return '';
                break;
        }
    }

    /**
     * Determine if the AR button should be customized based on the provided input.
     *
     * This function processes the given `$btn_custom` parameter and returns a boolean
     * indicating whether the AR button should be customized or not.
     *
     * @param int $btn_custom An integer indicating whether the AR button should be customized.
     *                        A value of 1 means customize; any other value means don't customize.
     * @return bool Returns `true` if `$btn_custom` is 1 (indicating customization),
     *              otherwise returns `false`.
     */
    public function byrst_woocommerce_plugin_ar_btn_custom($btn_custom)
    {
        // Check if the provided $btn_custom value is 1.
        if ($btn_custom == 1) {
            // If the value is 1, return `true` to indicate that the AR button should be customized.
            return true;
        } else {
            // For any other value, return `false` indicating no customization for the AR button.
            return false;
        }
    }

}
