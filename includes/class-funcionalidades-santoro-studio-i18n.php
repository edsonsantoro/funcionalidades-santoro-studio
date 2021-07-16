<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://santoro.studio
 * @since      1.0.0
 *
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/includes
 * @author     Edson Santoro <edson@santoro.studio>
 */
class Funcionalidades_Santoro_Studio_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'funcionalidades-santoro-studio',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
