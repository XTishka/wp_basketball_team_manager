<?php


class Admin_Game_Posts extends Basketball_Team_Manager_Admin {

	private $plugin_name;

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
			'show_admin_column' => false,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'tv_channels' ),
		) );
	}

	public function register_sponsors_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Sponsors', 'taxonomy general name' ),
			'singular_name'              => _x( 'Sponsor', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Sponsor' ),
			'popular_items'              => __( 'Popular Sponsors' ),
			'all_items'                  => __( 'All Sponsors' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Sponsor' ),
			'update_item'                => __( 'Update Sponsor' ),
			'add_new_item'               => __( 'Add New Sponsor' ),
			'new_item_name'              => __( 'New Sponsor Name' ),
			'separate_items_with_commas' => __( 'Separate Sponsors with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Sponsors' ),
			'choose_from_most_used'      => __( 'Choose from the most used Sponsors' ),
			'menu_name'                  => __( 'Sponsors' ),
		);

		register_taxonomy( 'sponsors', 'bt-games', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => false,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'sponsors' ),
		) );
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
			'arena'            => get_post_meta( $post->ID, 'taxonomy_game_arena', 1 ),
			'home_team'        => get_post_meta( $post->ID, 'taxonomy_game_home_team', 1 ),
			'guest_team'       => get_post_meta( $post->ID, 'taxonomy_game_guest_team', 1 ),
			'home_team_score'  => get_post_meta( $post->ID, 'game_home_team_score', 1 ),
			'guest_team_score' => get_post_meta( $post->ID, 'game_guest_team_score', 1 ),
			'season'           => get_post_meta( $post->ID, 'taxonomy_game_season', 1 ),
			'tournament'       => get_post_meta( $post->ID, 'taxonomy_game_tournament', 1 ),
			'statistics_link'  => get_post_meta( $post->ID, 'game_statistics_link', 1 ),
			'tv'               => get_post_meta( $post->ID, 'taxonomy_game_tv', 1 ),
			'tv_link'          => get_post_meta( $post->ID, 'game_tv_link', 1 ),
			'sponsor'          => get_post_meta( $post->ID, 'game_sponsor', 1 ),
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

		$sponsorsTerms = get_terms(
			array(
				'taxonomy'   => 'sponsors',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		ob_start();
		include_once( BASKETBALL_TEAM_MANAGER_PLUGIN_PATH . 'admin/partials/game-data-form.php' );
		game_data_form( $gameData, $this->plugin_name, $teamsTerms, $arenasTerms, $seasonsTerms, $tournamentsTerms, $tvTerms, $sponsorsTerms );
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
		$post_type = $_POST['post_type'] ?? '';
		if ( isset( $_POST ) and $post_type == 'bt-games' ) {
			$gameData = array(
				'taxonomy_game_home_team',
				'game_home_team_score',
				'game_guest_team_score',
				'taxonomy_game_guest_team',
				'game_date',
				'game_time',
				'taxonomy_game_arena',
				'taxonomy_game_season',
				'taxonomy_game_tournament',
				'game_statistics_link',
				'taxonomy_game_tv',
				'game_tv_link',
				'taxonomy_game_sponsor',
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

			$this->updatePostTaxonomyTeams( $post_id );
			$this->updatePostTaxonomySingle( $post_id, $_POST['taxonomy_game_arena'], 'arenas' );
			$this->updatePostTaxonomySingle( $post_id, $_POST['taxonomy_game_season'], 'seasons' );
			$this->updatePostTaxonomySingle( $post_id, $_POST['taxonomy_game_tournament'], 'tournaments' );
			$this->updatePostTaxonomySingle( $post_id, $_POST['taxonomy_game_tv'], 'tv_channels' );
			$this->updatePostTaxonomySingle( $post_id, $_POST['taxonomy_game_sponsor'], 'sponsors' );
		}
	}

	private function updatePostTaxonomySingle( $post_id, $termData, $taxonomy ) {
		if ($termData != '') {
			$term = get_term( $termData, $taxonomy );
			if ( isset( $term ) ) {
				wp_set_object_terms( $post_id, $term->term_id, $taxonomy );
			}
		}
	}

	private function updatePostTaxonomyTeams( $post_id ) {
		$homeTeamTerm  = get_term( $_POST['taxonomy_game_home_team'], 'teams' );
		$guestTeamTerm = get_term( $_POST['taxonomy_game_guest_team'], 'teams' );
		if ( isset( $homeTeamTerm ) and isset( $guestTeamTerm ) ) {
			wp_set_object_terms( $post_id, array( $homeTeamTerm->term_id, $guestTeamTerm->term_id ), 'teams' );
		}
	}


}