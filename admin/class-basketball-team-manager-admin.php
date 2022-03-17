<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/XTishka
 * @since      1.0.0
 *
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/admin
 * @author     Takhir Berdyiev <takhir.berdyiev@gmail.com>
 */
class Basketball_Team_Manager_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	public $menuIcon;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->menuIcon    = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="color: #fff;"><path d="M212.3 10.3c-43.8 6.3-86.2 24.1-122.2 53.8l77.4 77.4c27.8-35.8 43.3-81.2 44.8-131.2zM248 222L405.9 64.1c-42.4-35-93.6-53.5-145.5-56.1-1.2 63.9-21.5 122.3-58.7 167.7L248 222zM56.1 98.1c-29.7 36-47.5 78.4-53.8 122.2 50-1.5 95.5-17 131.2-44.8L56.1 98.1zm272.2 204.2c45.3-37.1 103.7-57.4 167.7-58.7-2.6-51.9-21.1-103.1-56.1-145.5L282 256l46.3 46.3zM248 290L90.1 447.9c42.4 34.9 93.6 53.5 145.5 56.1 1.3-64 21.6-122.4 58.7-167.7L248 290zm191.9 123.9c29.7-36 47.5-78.4 53.8-122.2-50.1 1.6-95.5 17.1-131.2 44.8l77.4 77.4zM167.7 209.7C122.3 246.9 63.9 267.3 0 268.4c2.6 51.9 21.1 103.1 56.1 145.5L214 256l-46.3-46.3zm116 292c43.8-6.3 86.2-24.1 122.2-53.8l-77.4-77.4c-27.7 35.7-43.2 81.2-44.8 131.2z"/></svg>');
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
		 * defined in Basketball_Team_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Basketball_Team_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/basketball-team-manager-admin.css', array(), $this->version, 'all');
		wp_enqueue_style('jquery-datetimepicker', plugin_dir_url(__FILE__) . 'css/jquery.datetimepicker.css', array(), $this->version, 'all');
		wp_enqueue_style('btm-selectize', plugin_dir_url(__FILE__) . 'css/selectize.css', array(), $this->version, 'all');
		wp_enqueue_style('btm-selectize-default', plugin_dir_url(__FILE__) . 'css/selectize.default.css', array(), $this->version, 'all');
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
		 * defined in Basketball_Team_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Basketball_Team_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/basketball-team-manager-admin.js', array('jquery'), $this->version, false);
		wp_enqueue_script('btm-datetime-picker', plugin_dir_url(__FILE__) . 'js/datetime-picker.js', array('jquery'), $this->version, false);
		wp_enqueue_script('btm-selectize', plugin_dir_url(__FILE__) . 'js/selectize.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script('taxonomy-image-field', plugin_dir_url(__FILE__) . 'js/taxonomy-image-field.js', array('jquery'), $this->version, false);
	}

	public function register_setting_menu()
	{
		add_menu_page(
			'Basketball Team Manager',
			'BT Manager',
			'manage_options',
			'bt-manager',
			array($this, 'btm_dashboard'),
			$this->menuIcon,
			30
		);
	}

	public function btm_dashboard()
	{
		$currentTab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'settings';

		$tabs = array(
			'settings' => __( 'Settings', $this->plugin_name ),
			'calendar' => __( 'Calendar', $this->plugin_name )
		);

		$teams = get_terms(
			array(
				'taxonomy'   => 'teams',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		ob_start();
		include_once(BASKETBALL_TEAM_MANAGER_PLUGIN_PATH . 'admin/partials/btm-settings.php');
		btm_settings_tabs($this->plugin_name, $tabs, $currentTab, $teams);
		$tabs_view = ob_get_contents();
		ob_end_clean();
		echo $tabs_view;
	}

	public function btm_register_option_settings() {
		register_setting( 'btm-settings-group', 'btm_default_team' );
		register_setting( 'btm-settings-calendar-group', 'btm_post_to_google_calendar' );
		register_setting( 'btm-settings-calendar-group', 'btm_google_calendar_id' );
		register_setting( 'btm-settings-calendar-group', 'btm_google_calendar_time_zone' );
		register_setting( 'btm-settings-calendar-group', 'btm_google_secret_key' );
	}
}
