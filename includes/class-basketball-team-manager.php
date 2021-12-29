<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/XTishka
 * @since      1.0.0
 *
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/includes
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
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/includes
 * @author     Takhir Berdyiev <takhir.berdyiev@gmail.com>
 */
class Basketball_Team_Manager {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Basketball_Team_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'BASKETBALL_TEAM_MANAGER_VERSION' ) ) {
			$this->version = BASKETBALL_TEAM_MANAGER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'basketball-team-manager';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_admin_game_posts_hooks();
		$this->define_admin_team_posts_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Basketball_Team_Manager_Loader. Orchestrates the hooks of the plugin.
	 * - Basketball_Team_Manager_i18n. Defines internationalization functionality.
	 * - Basketball_Team_Manager_Admin. Defines all hooks for the admin area.
	 * - Basketball_Team_Manager_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-basketball-team-manager-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-basketball-team-manager-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-basketball-team-manager-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-game-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-team-posts.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-basketball-team-manager-public.php';

		$this->loader = new Basketball_Team_Manager_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Basketball_Team_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Basketball_Team_Manager_i18n();

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

		$plugin_admin = new Basketball_Team_Manager_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Register settings menu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_setting_menu' );
	}

	private function define_admin_game_posts_hooks() {
		$plugin_admin = new Admin_Game_Posts( $this->get_plugin_name(), $this->get_version() );

		// Register taxonomies
		$this->loader->add_action( 'init', $plugin_admin, 'register_seasons_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_tournaments_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_teams_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_arenas_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_tv_channels_taxonomy' );

		//  Register new post types
		$this->loader->add_action( 'init', $plugin_admin, 'register_games_posts' );

		// Register metaboxes
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'game_meta_box' );
		$this->loader->add_action( 'edit_form_after_title', $plugin_admin, 'move_game_meta_box_to_the_top' );

		// Save custom posts data
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_game_post' );
	}

	private function define_admin_team_posts_hooks() {
		$plugin_admin = new Admin_Team_Posts( $this->get_plugin_name(), $this->get_version() );

		// Register taxonomies
		$this->loader->add_action( 'init', $plugin_admin, 'register_staff_taxonomy' );

		//  Register new post types
		$this->loader->add_action( 'init', $plugin_admin, 'register_team_posts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Basketball_Team_Manager_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Basketball_Team_Manager_Loader    Orchestrates the hooks of the plugin.
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
