<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/XTishka
 * @since      1.0.0
 *
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/includes
 * @author     Takhir Berdyiev <takhir.berdyiev@gmail.com>
 */
class Basketball_Team_Manager_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::registerGamesPost();
	}
}
