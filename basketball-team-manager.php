<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/XTishka
 * @since             1.0.0
 * @package           Basketball_Team_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Basketball Team Manager
 * Plugin URI:        https://github.com/XTishka/wp_basketball_team_manager
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Takhir Berdyiev
 * Author URI:        https://github.com/XTishka
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       basketball-team-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BASKETBALL_TEAM_MANAGER_VERSION', '1.0.0');
define('BASKETBALL_TEAM_MANAGER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('BASKETBALL_TEAM_MANAGER_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-basketball-team-manager-activator.php
 */
function activate_basketball_team_manager()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-basketball-team-manager-activator.php';
	Basketball_Team_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-basketball-team-manager-deactivator.php
 */
function deactivate_basketball_team_manager()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-basketball-team-manager-deactivator.php';
	Basketball_Team_Manager_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_basketball_team_manager');
register_deactivation_hook(__FILE__, 'deactivate_basketball_team_manager');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-basketball-team-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_basketball_team_manager()
{

	$plugin = new Basketball_Team_Manager();
	$plugin->run();
}
run_basketball_team_manager();
