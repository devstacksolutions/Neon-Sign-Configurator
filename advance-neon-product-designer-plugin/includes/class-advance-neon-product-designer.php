<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    advance-neon-product-designer
 * @subpackage advance-neon-product-designer/includes
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
 * @package    advance-neon-product-designer
 * @subpackage advance-neon-product-designer/includes
 * @author     Your Name <email@example.com>
 */
class ANPD {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      ANPD_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	public function __construct() {
		if ( defined( 'ANPD_VERSION' ) ) {
			$this->version = ANPD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'advance-neon-product-designer';

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
	 * - ANPD_Loader. Orchestrates the hooks of the plugin.
	 * - ANPD_i18n. Defines internationalization functionality.
	 * - ANPD_Admin. Defines all hooks for the admin area.
	 * - ANPD_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-advance-neon-product-designer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-advance-neon-product-designer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-advance-neon-product-designer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-advance-neon-product-designer-public.php';

		$this->loader = new ANPD_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ANPD_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new ANPD_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new ANPD_Admin( $this->get_ANPD(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_ANPD_parts_submenu' );

		$this->loader->add_action( 'init', $plugin_admin, 'Rigister_cpt_ANPD' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'anpd_colors_repeter_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'anpd_colors_meta_box_save', 1 );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'anpd_backgrounds_repeter_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'anpd_background_meta_box_save', 1 );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'anpd_backing_repeter_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'anpd_backing_meta_box_save', 1 );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'anpd_logo_button_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'anpd_logo_button_meta_box_save', 1 );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'anpd_font_repeter_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'anpd_font_meta_box_save', 1 );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'anpd_location_repeter_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'anpd_location_meta_box_save', 1 );
		$this->loader->add_action( 'woocommerce_product_options_general_product_data', $plugin_admin, 'get_product_config_selector' );
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'ANPD_woo_general_fields_save' );



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function define_public_hooks() {

		$plugin_public = new ANPD_Public( $this->get_ANPD(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'anpd_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'anpd_enqueue_scripts' );
		$this->loader->add_action('woocommerce_before_single_product', $plugin_public,'ANPD_Custom_product_template');
		$this->loader->add_action('wp_ajax_anpd_price_cacl', $plugin_public, 'ajax_anpd_price_cacl');
		$this->loader->add_action('wp_ajax_nopriv_anpd_price_cacl', $plugin_public, 'ajax_anpd_price_cacl');
		$plugin_public->ANPD_remove_hooks_product_page();

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_ANPD() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    ANPD_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
