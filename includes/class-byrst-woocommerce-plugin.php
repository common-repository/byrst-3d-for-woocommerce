<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.byrst.com
 * @since      1.0.0
 *
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Byrst_Woocommerce_Plugin
 * @subpackage Byrst_Woocommerce_Plugin/includes
 * @author     Byrst
 */
class Byrst_Woocommerce_Plugin
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Byrst_Woocommerce_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The unique prefix of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
     */
    protected $plugin_prefix;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        if (defined('BYRST_WOOCOMMERCE_PLUGIN_VERSION')) {

            $this->version = BYRST_WOOCOMMERCE_PLUGIN_VERSION;

        } else {

            $this->version = '1.0.0';

        }

        $this->plugin_name = 'byrst-woocommerce-plugin';
        $this->plugin_prefix = 'byrst_woocommerce_plugin_';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Byrst_Woocommerce_Plugin_Loader. Orchestrates the hooks of the plugin.
     * - Byrst_Woocommerce_Plugin_i18n. Defines internationalization functionality.
     * - Byrst_Woocommerce_Plugin_Admin. Defines all hooks for the admin area.
     * - Byrst_Woocommerce_Plugin_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-byrst-woocommerce-plugin-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-byrst-woocommerce-plugin-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-byrst-woocommerce-plugin-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-byrst-woocommerce-plugin-public.php';

        /**
         * The class responsible for defining all actions that occur to connect to Byrst API
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-byrst-woocommerce-plugin-api.php';

        /**
         * The class responsible for defining all actions that occur in the product page
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-byrst-woocommerce-plugin-admin-product.php';

         /**
         * The class responsible for defining all actions that occur in the settings page
         *
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-byrst-woocommerce-plugin-admin-settings.php';

        $this->loader = new Byrst_Woocommerce_Plugin_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Byrst_Woocommerce_Plugin_I18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Byrst_Woocommerce_Plugin_I18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        /**
         * Creates an instance of the Byrst_Woocommerce_Plugin_Admin class.
         *
         * @var Byrst_Woocommerce_Plugin_Admin $plugin_admin Holds the instance of the admin class.
         */
        $plugin_admin = new Byrst_Woocommerce_Plugin_Admin($this->get_plugin_name(), $this->get_plugin_prefix(), $this->get_version());
        $plugin_admin_product = new Byrst_Woocommerce_Plugin_Admin_Product($this->get_plugin_name(), $this->get_plugin_prefix(), $this->get_version());
        $plugin_admin_settings =  new Byrst_Woocommerce_Plugin_Admin_Settings($this->get_plugin_name(), $this->get_plugin_prefix(), $this->get_version());
        /**
         * Check if WooCommerce plugin is active.
         * If not, display an admin notice about the requirement.
         */
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $this->loader->add_action('admin_notices', $plugin_admin, 'byrst_woocommerce_plugin_notice');
        }

        /**
         * Enqueue the admin styles.
         */
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');

        /**
         * Enqueue the admin scripts.
         */
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        /**
         * Sets the extension and mime type for Android (.gbl) and IOS (.usdz) files.
         */
        $this->loader->add_filter('wp_check_filetype_and_ext', $plugin_admin, 'byrst_woocommerce_plugin_file_and_ext', 10, 4);

        /**
         * Adds the Android (.gbl) and IOS (.usdz) file types to allowed mimes.
         */
        $this->loader->add_filter('upload_mimes', $plugin_admin, 'byrst_woocommerce_plugin_mime_types');

        /**
         * Define the metabox and field configurations for CMB2.
         */
        $this->loader->add_action('cmb2_admin_init', $plugin_admin, 'byrst_woocommerce_plugin_cmb2_metaboxes');

        /**
         * Get the current theme details.
         *
         * @var WP_Theme $theme_actual Contains the current theme details.
         */
        $theme_actual = wp_get_theme();

        /**
         * Check if the active theme is 'Bloksy'.
         * If so, apply a specific filter for Blocksy theme.
         */
        if ($theme_actual->name === 'Blocksy') {
            $this->loader->add_filter('blocksy:woocommerce:product-view:use-default', $plugin_admin, 'byrst_woocommerce_plugin_blocksy_fix');
        }

        $this->loader->add_action('wp_ajax_byrst_woocommerce_plugin_get_data_models', $plugin_admin_product, 'byrst_woocommerce_plugin_get_data_models');
        $this->loader->add_action('wp_ajax_nopriv_byrst_woocommerce_plugin_get_data_models', $plugin_admin_product, 'byrst_woocommerce_plugin_get_data_models');

        $this->loader->add_action('wp_ajax_byrst_woocommerce_plugin_get_data_model', $plugin_admin_product, 'byrst_woocommerce_plugin_get_data_model');
        $this->loader->add_action('wp_ajax_nopriv_byrst_woocommerce_plugin_get_data_model', $plugin_admin_product, 'byrst_woocommerce_plugin_get_data_model');

        $this->loader->add_action('wp_ajax_byrst_woocommerce_save_models_in_custom_fields', $plugin_admin_product, 'byrst_woocommerce_save_models_in_custom_fields');
        $this->loader->add_action('wp_ajax_norpriv_byrst_woocommerce_save_models_in_custom_fields', $plugin_admin_product, 'byrst_woocommerce_save_models_in_custom_fields');

        $this->loader->add_action('wp_ajax_byrst_woocommerce_remove_models_in_custom_fields', $plugin_admin_product, 'byrst_woocommerce_remove_models_in_custom_fields');
        $this->loader->add_action('wp_ajax_nopriv_byrst_woocommerce_remove_models_in_custom_fields', $plugin_admin_product, 'byrst_woocommerce_remove_models_in_custom_fields');

        $this->loader->add_action('wp_ajax_byrst_settings_save_claim_id_and_token', $plugin_admin_settings, 'byrst_settings_save_claim_id_and_token');
        $this->loader->add_action('wp_ajax_nopriv_byrst_settings_save_claim_id_and_token', $plugin_admin_settings, 'byrst_settings_save_claim_id_and_token');

        $this->loader->add_action('wp_ajax_byrst_settings_remove_claim_id_and_token', $plugin_admin_settings, 'byrst_settings_remove_claim_id_and_token');
        $this->loader->add_action('wp_ajax_nopriv_byrst_settings_remove_claim_id_and_token', $plugin_admin_settings, 'byrst_settings_remove_claim_id_and_token');

        $this->loader->add_action('wp_ajax_byrst_woocommerce_plugin_get_data_view', $plugin_admin, 'byrst_woocommerce_plugin_get_data_view');
        $this->loader->add_action('wp_ajax_nopriv_byrst_woocommerce_plugin_get_data_view', $plugin_admin, 'byrst_woocommerce_plugin_get_data_view');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        // Instantiate the public-facing functionality class
        $plugin_public = new Byrst_Woocommerce_Plugin_Public($this->get_plugin_name(), $this->get_plugin_prefix(), $this->get_version());

        // Enqueue styles for the public-facing side of the site
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        // Enqueue scripts for the public-facing side of the site
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        // Add Custom attributes
        $this->loader->add_filter('script_loader_tag', $plugin_public, 'byrst_woocommerce_plugin_add_attributes', 10, 3);

        // Retrieve plugin settings from the options table
        $byrst_woocommerce_plugin_settings = get_option('byrst_woocommerce_plugin_settings');

        // Determine where the button should appear based on the plugin's settings
        switch (isset($byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_btn'])) {
            case 1:
                $this->loader->add_action('woocommerce_before_single_product_summary', $plugin_public, 'byrst_woocommerce_plugin_button');
                break;
            case 2:
                $this->loader->add_action('woocommerce_after_single_product_summary', $plugin_public, 'byrst_woocommerce_plugin_button');
                break;
            case 3:
                $this->loader->add_action('woocommerce_before_single_product', $plugin_public, 'byrst_woocommerce_plugin_button');
                break;
            case 4:
                $this->loader->add_action('woocommerce_after_single_product', $plugin_public, 'byrst_woocommerce_plugin_button');
                break;
            case 5:
                $this->loader->add_action('woocommerce_after_add_to_cart_form', $plugin_public, 'byrst_woocommerce_plugin_button');
                break;
            case 6:
                $this->loader->add_action('woocommerce_before_add_to_cart_form', $plugin_public, 'byrst_woocommerce_plugin_button');
                break;
        }

        if (isset($byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_single_product_tabs'])) {
            // Determine if a button should appear in the product tabs based on the plugin's settings
            if ($byrst_woocommerce_plugin_settings['byrst_woocommerce_plugin_single_product_tabs'] == 'yes') {
                $this->loader->add_filter('woocommerce_product_tabs', $plugin_public, 'byrst_woocommerce_plugin_tab');
            }
        }

        // Code to register a shortcode for the plugin.
        // NOTE: Consider removing this for the production environment.
        // Ensure that the shortcode name matches the third parameter in shortcode_atts().
        //$this->loader->add_shortcode($this->get_plugin_prefix() . 'shortcode', $plugin_public, 'byrst_woocommerce_plugin_shortcode_func');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The unique prefix of the plugin used to uniquely prefix technical functions.
     *
     * @since     1.0.0
     * @return    string    The prefix of the plugin.
     */
    public function get_plugin_prefix()
    {
        return $this->plugin_prefix;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Byrst_Woocommerce_Plugin_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
