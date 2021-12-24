<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/XTishka
 * @since      1.0.0
 *
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/includes
 * @author     Takhir Berdyiev <takhir.berdyiev@gmail.com>
 */
class Basketball_Team_Manager_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'basketball-team-manager',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
