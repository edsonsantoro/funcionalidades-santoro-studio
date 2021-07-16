<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://santoro.studio
 * @since             1.0.0
 * @package           Funcionalidades_Santoro_Studio
 *
 * @wordpress-plugin
 * Plugin Name:       Funcionalidades - Santoro Studio 
 * Plugin URI:        https://santoro.studio
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Edson Santoro
 * Author URI:        https://santoro.studio
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       funcionalidades-santoro-studio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FUNCIONALIDADES_SANTORO_STUDIO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-funcionalidades-santoro-studio-activator.php
 */
function activate_funcionalidades_santoro_studio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-funcionalidades-santoro-studio-activator.php';
	Funcionalidades_Santoro_Studio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-funcionalidades-santoro-studio-deactivator.php
 */
function deactivate_funcionalidades_santoro_studio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-funcionalidades-santoro-studio-deactivator.php';
	Funcionalidades_Santoro_Studio_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_funcionalidades_santoro_studio' );
register_deactivation_hook( __FILE__, 'deactivate_funcionalidades_santoro_studio' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-funcionalidades-santoro-studio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_funcionalidades_santoro_studio() {

	$plugin = new Funcionalidades_Santoro_Studio();
	$plugin->run();

}
run_funcionalidades_santoro_studio();
