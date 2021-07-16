<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://santoro.studio
 * @since      1.0.0
 *
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/includes
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
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/includes
 * @author     Edson Santoro <edson@santoro.studio>
 */
class Funcionalidades_Santoro_Studio {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Funcionalidades_Santoro_Studio_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'FUNCIONALIDADES_SANTORO_STUDIO_VERSION' ) ) {
			$this->version = FUNCIONALIDADES_SANTORO_STUDIO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'funcionalidades-santoro-studio';

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
	 * - Funcionalidades_Santoro_Studio_Loader. Orchestrates the hooks of the plugin.
	 * - Funcionalidades_Santoro_Studio_i18n. Defines internationalization functionality.
	 * - Funcionalidades_Santoro_Studio_Admin. Defines all hooks for the admin area.
	 * - Funcionalidades_Santoro_Studio_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-funcionalidades-santoro-studio-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-funcionalidades-santoro-studio-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-funcionalidades-santoro-studio-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-funcionalidades-santoro-studio-public.php';

		$this->loader = new Funcionalidades_Santoro_Studio_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Funcionalidades_Santoro_Studio_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Funcionalidades_Santoro_Studio_i18n();

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

		$plugin_admin = new Funcionalidades_Santoro_Studio_Admin( $this->get_plugin_name(), $this->get_version() );

		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Set customer to 'visiting' for orders created by admin, shop managers and shop workers
		$this->loader->add_action( 'wp_insert_post', $plugin_admin, 'sds_update_customer_for_admin_orders', 10, 3 );
		$this->loader->add_action( 'woocommerce_order_status_pending_to_cancelled', $plugin_admin,  'sds_increase_stock_levels', 10, 2);

		// Automatically increase stock levels of itens in cancelled orders
		$this->loader->add_action( 'woocommerce_order_status_on-hold_to_cancelled',  $plugin_admin, 'sds_increase_stock_levels', 10, 2);
		$this->loader->add_action( 'woocommerce_order_status_processing_to_cancelled',  $plugin_admin, 'sds_increase_stock_levels', 10, 2);
		$this->loader->add_action( 'woocommerce_order_status_completed_to_cancelled',  $plugin_admin, 'sds_increase_stock_levels', 10, 2);
		$this->loader->add_action( 'woocommerce_order_status_pending',  $plugin_admin, 'sds_reduce_stock_for_manual_orders', 10, 2);
		
		// Hold itens on order for pending orders
		$this->loader->add_action( 'woocommerce_order_status_on-hold_to_pending', $plugin_admin, 'reduce_stock_levels', 10, 2);
		$this->loader->add_action( 'woocommerce_order_status_processing_to_pending', $plugin_admin, 'reduce_stock_levels', 10, 2);
		$this->loader->add_action( 'woocommerce_order_status_completed_to_pending', $plugin_admin, 'reduce_stock_levels', 10, 2);
		$this->loader->add_action( 'woocommerce_order_status_reservado_to_pending', $plugin_admin, 'reduce_stock_levels', 10, 2);
		$this->loader->add_action( 'woocommerce_order_status_reserved_to_pending', $plugin_admin, 'reduce_stock_levels', 10, 2);

		// Call register settings function
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'sds_create_menu');
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_sds_settings' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Funcionalidades_Santoro_Studio_Public( $this->get_plugin_name(), $this->get_version() );

		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_checkout_process', $plugin_admin, 'sds_update_customer_for_public_orders', 10, 1 );
		

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
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Funcionalidades_Santoro_Studio_Loader    Orchestrates the hooks of the plugin.
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
