<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://santoro.studio
 * @since      1.0.0
 *
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/admin
 * @author     Edson Santoro <edson@santoro.studio>
 */
class Funcionalidades_Santoro_Studio_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/funcionalidades-santoro-studio-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/funcionalidades-santoro-studio-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Definir usuário como convidado para pedidos criados pela equipe
	 * possibilitando que qualquer pessoa com o link efetue pagamento.
	 *
	 * @since	1.0.0
	 */
	public function sds_update_customer_for_admin_orders($post_id, $post, $update)
	{

		// Não vamos rodar a função se o $post_id não existe OU se o post type não foi ORDER OU se estiverem atualizando $update = 1
		if (!$post_id || get_post_type($post_id) != 'shop_order') {
			return;
		}

		//$order = new Wc_Order();
		$order = wc_get_order($post_id);

		// Se o pedido foi criado manualmente, vamos reduzir o estoque.
		if ($order && $order->status == "pending") {
			wc_reduce_stock_levels($post_id);
		}

		// Se temos o pedido e o consumidor não é convidade (0) e se o usuário existe (!= false) mudamos ele para convidado
		if ($order && $order->customer_id > 0 && get_user_by('id', $order->customer_id) != false) {

			// Vamos tentar atualizar o consumidor para convidado caso o pedido tenha sido criado por funcionários.
			$role = array_values(get_userdata($order->customer_id)->roles)[0];
			if ($role = 'shop_manager' || $role = 'shop_accountant' || $role = 'shop_vendor' || $role = 'outlet_manager' || $role = 'shop_worker' || $role = 'administrator') {
				update_post_meta($post_id, '_customer_user', 0);
			}
		}
	}

	/**
	 * Aumenta estoque para pedidos
	 * 
	 * @since	1.0.0
	 */
	public function sds_increase_stock_levels($id, $instance){
		wc_increase_stock_levels($id);
	}


	/**
	 * Reduzir estoque para pedidos que estão com pagamento pendente (Reserva)
	 * 
	 * @since	1.0.0
	*/
	public function sds_reduce_stock_for_manual_orders($order_id){
		wc_reduce_stock_levels($order_id);
	}

	/**
	 * Quando se muda um pedido de status completo para aguardando, 
	 * O WooCommerce devolve os itens do pedido para o estoque. 
	 * Não queremos este comportamento, queremos que o WooCommerce segure o estoque.
	 * Para isso temos que trazer de volta o que foi retirado.
	 * 
	 * @since	1.0.0
	 */
	public function sds_reduce_stock_levels($order_id, $instance) {
		wc_maybe_reduce_stock_levels($order_id);
	}

	
	/**
	 * Register the plugin's menu page
	 * 
	 * @since	1.0.0
	 */
	public function sds_create_menu() {
		add_menu_page('Santoro Studio', 'Configurações', 'administrator', __FILE__, 'sds_settings_page' , plugins_url('/images/icon.png', __FILE__) );
	}

	
	/**
	 * Register this plugins settings
	 * 
	 * @since	1.0.0
	 */
	public function register_sds_settings() {
		//register our settings
		register_setting( 'sds-settings-group', 'new_option_name' );
		register_setting( 'sds-settings-group', 'some_other_option' );
		register_setting( 'sds-settings-group', 'option_etc' );
	}
}
