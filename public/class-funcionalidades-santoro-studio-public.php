<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://santoro.studio
 * @since      1.0.0
 *
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/public
 * @author     Edson Santoro <edson@santoro.studio>
 */
class Funcionalidades_Santoro_Studio_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Funcionalidades_Santoro_Studio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Funcionalidades_Santoro_Studio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/funcionalidades-santoro-studio-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Funcionalidades_Santoro_Studio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Funcionalidades_Santoro_Studio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/funcionalidades-santoro-studio-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Definir usuário como convidado para pedidos criados pela equipe
	 * no front-end possibilitando que qualquer pessoa com o link efetue pagamento.
	 *
	 * @since	1.0.0
	 */
	function sds_update_customer_for_public_orders($order_id)
	{

		// Não vamos rodar a função se o $post_id não existe OU se o post type não foi ORDER OU se estiverem atualizando $update = 1
		if (!$order_id) {
			return;
		}

		$order = wc_get_order($order_id);

		// Se temos o pedido e o consumidor não é convidade (0) e se o usuário existe (!= false) mudamos ele para convidado
		if ($order && $order->customer_id > 0 && get_user_by('id', $order->customer_id) != false) {

			// Vamos tentar atualizar o consumidor para convidado caso o pedido tenha sido criado por funcionários.
			$role = array_values(get_userdata($order->customer_id)->roles)[0];
			if ($role = 'shop_manager' || $role = 'shop_accountant' || $role = 'shop_vendor' || $role = 'outlet_manager' || $role = 'shop_worker' || $role = 'administrator') {
				update_post_meta($post_id, '_customer_user', 0);
			}
		}
	}

}
