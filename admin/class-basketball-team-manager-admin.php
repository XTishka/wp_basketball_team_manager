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
class Basketball_Team_Manager_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->menuIcon    = 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="color: #fff;"><path d="M212.3 10.3c-43.8 6.3-86.2 24.1-122.2 53.8l77.4 77.4c27.8-35.8 43.3-81.2 44.8-131.2zM248 222L405.9 64.1c-42.4-35-93.6-53.5-145.5-56.1-1.2 63.9-21.5 122.3-58.7 167.7L248 222zM56.1 98.1c-29.7 36-47.5 78.4-53.8 122.2 50-1.5 95.5-17 131.2-44.8L56.1 98.1zm272.2 204.2c45.3-37.1 103.7-57.4 167.7-58.7-2.6-51.9-21.1-103.1-56.1-145.5L282 256l46.3 46.3zM248 290L90.1 447.9c42.4 34.9 93.6 53.5 145.5 56.1 1.3-64 21.6-122.4 58.7-167.7L248 290zm191.9 123.9c29.7-36 47.5-78.4 53.8-122.2-50.1 1.6-95.5 17.1-131.2 44.8l77.4 77.4zM167.7 209.7C122.3 246.9 63.9 267.3 0 268.4c2.6 51.9 21.1 103.1 56.1 145.5L214 256l-46.3-46.3zm116 292c43.8-6.3 86.2-24.1 122.2-53.8l-77.4-77.4c-27.7 35.7-43.2 81.2-44.8 131.2z"/></svg>' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/basketball-team-manager-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-datetimepicker', plugin_dir_url( __FILE__ ) . 'css/jquery.datetimepicker.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'btm-selectize', plugin_dir_url( __FILE__ ) . 'css/selectize.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'btm-selectize-default', plugin_dir_url( __FILE__ ) . 'css/selectize.default.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/basketball-team-manager-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'btm-datetime-picker', plugin_dir_url( __FILE__ ) . 'js/datetime-picker.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'btm-selectize', plugin_dir_url( __FILE__ ) . 'js/selectize.min.js', array( 'jquery' ), $this->version, false );
	}

	public function register_setting_menu() {
		add_menu_page(
			'Basketball Team Manager',
			'BT Manager',
			'manage_options',
			'bt-manager',
			array( $this, 'btm_dashboard' ),
			$this->menuIcon,
			30
		);
	}

	public function btm_dashboard() {
		echo '<h3>Basketball Team Manager</h3>';
	}

	public function register_seasons_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Seasons', 'taxonomy general name' ),
			'singular_name'              => _x( 'Season', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Seasons' ),
			'popular_items'              => __( 'Popular Seasons' ),
			'all_items'                  => __( 'All Seasons' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Season' ),
			'update_item'                => __( 'Update Season' ),
			'add_new_item'               => __( 'Add New Season' ),
			'new_item_name'              => __( 'New Season Name' ),
			'separate_items_with_commas' => __( 'Separate seasons with commas' ),
			'add_or_remove_items'        => __( 'Add or remove seasons' ),
			'choose_from_most_used'      => __( 'Choose from the most used seasons' ),
			'menu_name'                  => __( 'Seasons' ),
			'show_in_rest'               => true,
		);

		register_taxonomy( 'seasons', 'bt-games', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'seasons' ),
		) );
	}

	public function register_tournaments_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Tournaments', 'taxonomy general name' ),
			'singular_name'              => _x( 'Tournament', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Tournaments' ),
			'popular_items'              => __( 'Popular Tournaments' ),
			'all_items'                  => __( 'All Tournaments' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Tournament' ),
			'update_item'                => __( 'Update Tournament' ),
			'add_new_item'               => __( 'Add New Tournament' ),
			'new_item_name'              => __( 'New Tournament Name' ),
			'separate_items_with_commas' => __( 'Separate tournaments with commas' ),
			'add_or_remove_items'        => __( 'Add or remove tournaments' ),
			'choose_from_most_used'      => __( 'Choose from the most used tournaments' ),
			'menu_name'                  => __( 'Tournaments' ),
		);

		register_taxonomy( 'tournaments', 'bt-games', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'tournaments' ),
		) );
	}

	public function register_teams_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Teams', 'taxonomy general name' ),
			'singular_name'              => _x( 'Team', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Team' ),
			'popular_items'              => __( 'Popular Teams' ),
			'all_items'                  => __( 'All Teams' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Team' ),
			'update_item'                => __( 'Update Team' ),
			'add_new_item'               => __( 'Add New Team' ),
			'new_item_name'              => __( 'New Team Name' ),
			'separate_items_with_commas' => __( 'Separate teams with commas' ),
			'add_or_remove_items'        => __( 'Add or remove teams' ),
			'choose_from_most_used'      => __( 'Choose from the most used teams' ),
			'menu_name'                  => __( 'Teams' ),
		);

		register_taxonomy( 'teams', 'bt-games', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'teams' ),
		) );
	}

	public function register_arenas_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Arenas', 'taxonomy general name' ),
			'singular_name'              => _x( 'Arena', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Arena' ),
			'popular_items'              => __( 'Popular Arenas' ),
			'all_items'                  => __( 'All Arenas' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Arena' ),
			'update_item'                => __( 'Update Arena' ),
			'add_new_item'               => __( 'Add New Arena' ),
			'new_item_name'              => __( 'New Team Arena' ),
			'separate_items_with_commas' => __( 'Separate arenas with commas' ),
			'add_or_remove_items'        => __( 'Add or remove arenas' ),
			'choose_from_most_used'      => __( 'Choose from the most used arenas' ),
			'menu_name'                  => __( 'Arenas' ),
		);

		register_taxonomy( 'arenas', 'bt-games', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'arenas' ),
		) );
	}

	public function register_tv_channels_taxonomy() {
		$labels = array(
			'name'                       => _x( 'TV Channels', 'taxonomy general name' ),
			'singular_name'              => _x( 'TV channel', 'taxonomy singular name' ),
			'search_items'               => __( 'Search TV Channels' ),
			'popular_items'              => __( 'Popular TV Channels' ),
			'all_items'                  => __( 'All TV Channels' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit TV channel' ),
			'update_item'                => __( 'Update TV channel' ),
			'add_new_item'               => __( 'Add New TV channel' ),
			'new_item_name'              => __( 'New TV channel Name' ),
			'separate_items_with_commas' => __( 'Separate TV channels with commas' ),
			'add_or_remove_items'        => __( 'Add or remove TV channels' ),
			'choose_from_most_used'      => __( 'Choose from the most used TV channels' ),
			'menu_name'                  => __( 'TV Channels' ),
		);

		register_taxonomy( 'tv_channels', 'bt-games', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'tv_channels' ),
		) );
	}

	public function register_staff_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Staffs', 'taxonomy general name' ),
			'singular_name'              => _x( 'Staff', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Staffs' ),
			'popular_items'              => __( 'Popular Staffs' ),
			'all_items'                  => __( 'All Staffs' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Staff' ),
			'update_item'                => __( 'Update Staff' ),
			'add_new_item'               => __( 'Add New Staff' ),
			'new_item_name'              => __( 'New Staff Name' ),
			'separate_items_with_commas' => __( 'Separate staffs with commas' ),
			'add_or_remove_items'        => __( 'Add or remove staffs' ),
			'choose_from_most_used'      => __( 'Choose from the most used staffs' ),
			'menu_name'                  => __( 'Staffs' ),
		);

		register_taxonomy( 'staffs', 'bt-team', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'staffs' ),
		) );
	}

	public function register_games_posts() {
		$labels = [
			'name'               => _x( 'Games', 'Post Type General Name', $this->plugin_name ),
			'singular_name'      => _x( 'Game', 'Post Type Singular Name', $this->plugin_name ),
			'menu_name'          => __( 'BT Games', $this->plugin_name ),
			'parent_item_colon'  => __( 'Parent Game', $this->plugin_name ),
			'all_items'          => __( 'All Games', $this->plugin_name ),
			'view_item'          => __( 'View Game', $this->plugin_name ),
			'add_new_item'       => __( 'Add New Game', $this->plugin_name ),
			'add_new'            => __( 'Add New Game', $this->plugin_name ),
			'edit_item'          => __( 'Edit Game', $this->plugin_name ),
			'update_item'        => __( 'Update Game', $this->plugin_name ),
			'search_items'       => __( 'Search Game', $this->plugin_name ),
			'not_found'          => __( 'Not Found', $this->plugin_name ),
			'not_found_in_trash' => __( 'Not found in Trash', $this->plugin_name ),
		];

		$args = [
			'label'               => __( 'bt-games', $this->plugin_name ),
			'description'         => __( 'Team games', $this->plugin_name ),
			'labels'              => $labels,
			'supports'            => [
				'title',
				'editor',
				'custom-fields',
			],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 31,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'menu_icon'           => $this->menuIcon,
		];

		register_post_type( 'bt-games', $args );
	}

	public function register_team_posts() {
		$labels = [
			'name'               => _x( 'Team', 'Post Type General Name', $this->plugin_name ),
			'singular_name'      => _x( 'Team', 'Post Type Singular Name', $this->plugin_name ),
			'menu_name'          => __( 'BT Team', $this->plugin_name ),
			'parent_item_colon'  => __( 'Parent Member', $this->plugin_name ),
			'all_items'          => __( 'All Members', $this->plugin_name ),
			'view_item'          => __( 'View Member', $this->plugin_name ),
			'add_new_item'       => __( 'Add New Member', $this->plugin_name ),
			'add_new'            => __( 'Add Member', $this->plugin_name ),
			'edit_item'          => __( 'Edit Member', $this->plugin_name ),
			'update_item'        => __( 'Update Member', $this->plugin_name ),
			'search_items'       => __( 'Search Member', $this->plugin_name ),
			'not_found'          => __( 'Not Found', $this->plugin_name ),
			'not_found_in_trash' => __( 'Not found in Trash', $this->plugin_name ),
		];

		$args = [
			'label'               => __( 'bt-team', $this->plugin_name ),
			'description'         => __( 'Team members', $this->plugin_name ),
			'labels'              => $labels,
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
			],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 32,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'menu_icon'           => $this->menuIcon,

		];

		register_post_type( 'bt-team', $args );
	}

	public function game_meta_box() {
		add_meta_box(
			'btm-game-meta_box',
			'Game data',
			array( $this, 'game_meta_box_callback' ),
			array( 'bt-games' ),
			'advanced',
			'high'
		);
	}

	public function game_meta_box_callback( $post, $meta ) {
		$screens = $meta['args'];
		wp_nonce_field( plugin_basename( __FILE__ ), 'bt_game_noncename' );

		$gameData = array(
			'date'             => get_post_meta( $post->ID, 'game_date', 1 ),
			'time'             => get_post_meta( $post->ID, 'game_time', 1 ),
			'arena'            => get_post_meta( $post->ID, 'game_arena', 1 ),
			'home_team'        => get_post_meta( $post->ID, 'game_home_team', 1 ),
			'guest_team'       => get_post_meta( $post->ID, 'game_guest_team', 1 ),
			'home_team_score'  => get_post_meta( $post->ID, 'game_home_team_score', 1 ),
			'guest_team_score' => get_post_meta( $post->ID, 'game_guest_team_score', 1 ),
			'season'           => get_post_meta( $post->ID, 'game_season', 1 ),
			'tournament'       => get_post_meta( $post->ID, 'game_tournament', 1 ),
			'statistics_link'  => get_post_meta( $post->ID, 'game_statistics_link', 1 ),
			'tv'               => get_post_meta( $post->ID, 'game_tv', 1 ),
			'tv_link'          => get_post_meta( $post->ID, 'game_tv_link', 1 ),
		);

		$teamsTerms = get_terms(
			array(
				'taxonomy'   => 'teams',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		$arenasTerms = get_terms(
			array(
				'taxonomy'   => 'arenas',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'DESC',
			)
		);

		$seasonsTerms = get_terms(
			array(
				'taxonomy'   => 'seasons',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'DESC',
			)
		);

		$tournamentsTerms = get_terms(
			array(
				'taxonomy'   => 'tournaments',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		$tvTerms = get_terms(
			array(
				'taxonomy'   => 'tv_channels',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		ob_start();
		include_once( BASKETBALL_TEAM_MANAGER_PLUGIN_PATH . 'admin/partials/game-data-form.php' );
		game_data_form( $gameData, $this->plugin_name, $teamsTerms, $arenasTerms, $seasonsTerms, $tournamentsTerms, $tvTerms );
		$form = ob_get_contents();
		ob_end_clean();
		echo $form;
	}

	public function move_game_meta_box_to_the_top() {
		global $post, $wp_meta_boxes;
		do_meta_boxes( get_current_screen(), 'advanced', $post );
		unset( $wp_meta_boxes['bt-games']['advanced'] );
	}

	public function save_game_post( $post_id ) {
		if ( isset( $_POST ) and $_POST['post_type'] == 'bt-games' ) {
			$gameData = array(
				'game_home_team',
				'game_home_team_score',
				'game_guest_team_score',
				'game_guest_team',
				'game_date',
				'game_time',
				'game_arena',
				'game_season',
				'game_tournament',
				'game_statistics_link',
				'game_tv',
				'game_tv_link',
			);

			if ( ! wp_verify_nonce( $_POST['bt_game_noncename'], plugin_basename( __FILE__ ) ) ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			foreach ( $gameData as $field ) {
				update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
			}

			$homeTeamTerm  = get_term( $_POST['game_home_team'], 'teams' );
			$guestTeamTerm = get_term( $_POST['game_guest_team'], 'teams' );
			if ( isset( $homeTeamTerm ) and isset( $guestTeamTerm ) ) {
				wp_set_object_terms( $post_id, array( $homeTeamTerm->term_id, $guestTeamTerm->term_id ), 'teams' );
			}

			$arenaTerm = get_term( $_POST['game_arena'], 'arenas' );
			if ( isset( $arenaTerm ) ) {
				wp_set_object_terms( $post_id, $arenaTerm->term_id, 'arenas' );
			}

			$seasonTerm = get_term( $_POST['game_season'], 'seasons' );
			if ( isset( $seasonTerm ) ) {
				wp_set_object_terms( $post_id, $seasonTerm->term_id, 'seasons' );
			}

			$tournamentTerm = get_term( $_POST['game_tournament'], 'tournaments' );
			if ( isset( $tournamentTerm ) ) {
				wp_set_object_terms( $post_id, $tournamentTerm->term_id, 'tournaments' );
			}

			$tvTerm = get_term( $_POST['game_tv'], 'tv_channels' );
			if ( isset( $tvTerm ) ) {
				wp_set_object_terms( $post_id, $tvTerm->term_id, 'tv_channels' );
			}
		}
	}
}
