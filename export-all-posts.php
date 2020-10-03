<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/
 * @since             1.0.0
 * @package           Export_All_Posts
 *
 * @wordpress-plugin
 * Plugin Name:       Export All Posts
 * Plugin URI:        https://github.com/vishalsharma1988/export-all-posts
 * Description:       This plugin will exports all the posts from default post-type.
 * Version:           1.0.0
 * Author:            vishal sharma
 * Author URI:        https://github.com/vishalsharma1988/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       export-all-posts
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
define( 'EXPORT_ALL_POSTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-export-all-posts-activator.php
 */
function activate_export_all_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-export-all-posts-activator.php';
	Export_All_Posts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-export-all-posts-deactivator.php
 */
function deactivate_export_all_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-export-all-posts-deactivator.php';
	Export_All_Posts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_export_all_posts' );
register_deactivation_hook( __FILE__, 'deactivate_export_all_posts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-export-all-posts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_export_all_posts() {

	$plugin = new Export_All_Posts();
	$plugin->run();

}
run_export_all_posts();
