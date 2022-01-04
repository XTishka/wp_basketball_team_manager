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
	 * @var      Basketball_Team_Manager_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-games-index.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-players-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-players-index.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-staff-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-staff-index.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-taxonomy-filters.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/class-admin-taxonomy-field-image.php';

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

		/**
		 * Admin Common Hooks
		 * */
		$plugin_admin = new Basketball_Team_Manager_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Register settings menu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_setting_menu' );


		/**
		 * Admin Games hooks
		 **/
		$plugin_admin_game = new Admin_Game_Posts( $this->get_plugin_name(), $this->get_version() );

		// Register game post type
		$this->loader->add_action( 'init', $plugin_admin_game, 'register_games_posts' );

		// Register games taxonomies
		$this->loader->add_action( 'init', $plugin_admin_game, 'register_seasons_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin_game, 'register_tournaments_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin_game, 'register_teams_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin_game, 'register_arenas_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin_game, 'register_tv_channels_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin_game, 'register_sponsors_taxonomy' );

		// Register metaboxes
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin_game, 'game_meta_box' );
		$this->loader->add_action( 'edit_form_after_title', $plugin_admin_game, 'move_game_meta_box_to_the_top' );

		// Save custom posts data
		$this->loader->add_action( 'save_post', $plugin_admin_game, 'save_game_post' );

		// Taxonomy field Image
		$gameTeamLogo = new Admin_Taxonomy_Field_Image( 'teams' );
		$gameTeamLogo->init();

		$gameTVChannelLogo = new Admin_Taxonomy_Field_Image( 'tv_channels' );
		$gameTVChannelLogo->init();

		$gameSponsorLogo = new Admin_Taxonomy_Field_Image( 'sponsors' );
		$gameSponsorLogo->init();

		// All posts custom columns
		$gameDateColumn = new Admin_Games_Index( $this->plugin_name );
		$gameDateColumn->init();

		// Taxonomy filters
		$gameTournamentFilter = new Admin_Taxonomy_Filters( 'bt-games', 'seasons' );
		$gameTournamentFilter->init();

		$gameTournamentFilter = new Admin_Taxonomy_Filters( 'bt-games', 'tournaments' );
		$gameTournamentFilter->init();

		$gameTournamentFilter = new Admin_Taxonomy_Filters( 'bt-games', 'teams' );
		$gameTournamentFilter->init();


		/**
		 * Admin Players hooks
		 **/
		$plugin_admin_player = new Admin_Players_Posts( $this->get_plugin_name(), $this->get_version() );

		// Register player post type
		$this->loader->add_action( 'init', $plugin_admin_player, 'register_players_posts' );
		// Register players taxonomies
		$this->loader->add_action( 'init', $plugin_admin_player, 'register_position_taxonomy' );
		$this->loader->add_action( 'init', $plugin_admin_player, 'register_status_taxonomy' );

		// Register metaboxes
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin_player, 'player_meta_box' );
		$this->loader->add_action( 'edit_form_after_title', $plugin_admin_player, 'remove_player_meta_box_duplicate' );

		// Save custom posts data
		$this->loader->add_action( 'save_post', $plugin_admin_player, 'save_players_data' );

		// Taxonomy filters
		$playerPositionFilter = new Admin_Taxonomy_Filters( 'bt-players', 'player-position' );
		$playerPositionFilter->init();

		$playerStatusFilter = new Admin_Taxonomy_Filters( 'bt-players', 'player-status' );
		$playerStatusFilter->init();

		// Players Index
		$playersIndexColumns = new Admin_Players_Index( $this->plugin_name );
		$playersIndexColumns->init();


		/**
		 * Admin Staff hooks
		 **/
		$plugin_admin_staff_member = new Admin_Staff_Posts( $this->get_plugin_name(), $this->get_version() );

		// Register staff post type
		$this->loader->add_action( 'init', $plugin_admin_staff_member, 'register_staff_posts' );

		// Register staff taxonomies
		$this->loader->add_action( 'init', $plugin_admin_staff_member, 'register_position_taxonomy' );

		// Register metaboxes
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin_staff_member, 'staff_member_meta_box' );
		$this->loader->add_action( 'edit_form_after_title', $plugin_admin_staff_member, 'remove_staff_member_meta_box_duplicate' );

		// Save custom posts data
		$this->loader->add_action( 'save_post', $plugin_admin_staff_member, 'save_staff_member_data' );

		// Taxonomy filters
		$staffPositionFilter = new Admin_Taxonomy_Filters( 'bt-staff', 'staff-position' );
		$staffPositionFilter->init();

		// Staff Index
		$staffIndexColumns = new Admin_Staff_Index( $this->plugin_name );
		$staffIndexColumns->init();
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
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Basketball_Team_Manager_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

}
