<?php

class Admin_Players_Posts extends Basketball_Team_Manager_Admin {

	private $plugin_name;

	public function register_players_posts() {
		$labels = [
			'name'               => _x( 'Players', 'Post Type General Name', $this->plugin_name ),
			'singular_name'      => _x( 'Player', 'Post Type Singular Name', $this->plugin_name ),
			'menu_name'          => __( 'BT Team', $this->plugin_name ),
			'parent_item_colon'  => __( 'Parent Player', $this->plugin_name ),
			'all_items'          => __( 'All Players', $this->plugin_name ),
			'view_item'          => __( 'View Player', $this->plugin_name ),
			'add_new_item'       => __( 'Add New Player', $this->plugin_name ),
			'add_new'            => __( 'Add Player', $this->plugin_name ),
			'edit_item'          => __( 'Edit Player', $this->plugin_name ),
			'update_item'        => __( 'Update Player', $this->plugin_name ),
			'search_items'       => __( 'Search Player', $this->plugin_name ),
			'not_found'          => __( 'Not Found', $this->plugin_name ),
			'not_found_in_trash' => __( 'Not found in Trash', $this->plugin_name ),
		];

		$args = [
			'label'               => __( 'bt-players', $this->plugin_name ),
			'description'         => __( 'Team players', $this->plugin_name ),
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

		register_post_type( 'bt-players', $args );
	}

	public function register_position_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Positions', 'taxonomy general name' ),
			'singular_name'              => _x( 'Position', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Positions' ),
			'popular_items'              => __( 'Popular Positions' ),
			'all_items'                  => __( 'All Positions' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Position' ),
			'update_item'                => __( 'Update Position' ),
			'add_new_item'               => __( 'Add New Position' ),
			'new_item_name'              => __( 'New Position Name' ),
			'separate_items_with_commas' => __( 'Separate positions with commas' ),
			'add_or_remove_items'        => __( 'Add or remove positions' ),
			'choose_from_most_used'      => __( 'Choose from the most used positions' ),
			'menu_name'                  => __( 'Positions' ),
		);

		register_taxonomy( 'player-position', 'bt-players', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'player-position' ),
		) );
	}

	public function player_meta_box() {
		add_meta_box(
			'btm-player-meta_box',
			'Player data',
			array( $this, 'player_meta_box_callback' ),
			array( 'bt-players' ),
			'advanced',
			'high'
		);
	}

	public function player_meta_box_callback( $post, $meta ) {
		$screens = $meta['args'];
		wp_nonce_field( plugin_basename( __FILE__ ), 'bt_player_noncename' );

		$playerData = array(
			'player_name'             => get_post_meta( $post->ID, 'player_name', 1 ),
			'player_position'         => get_post_meta( $post->ID, 'player_position', 1 ),
			'player_number'           => get_post_meta( $post->ID, 'player_number', 1 ),
			'player_total_games'      => get_post_meta( $post->ID, 'player_total_games', 1 ),
			'player_total_points'     => get_post_meta( $post->ID, 'player_total_points', 1 ),
			'player_total_3_pointers' => get_post_meta( $post->ID, 'player_total_3_pointers', 1 ),
			'player_birthdate'        => get_post_meta( $post->ID, 'player_birthdate', 1 ),
			'player_nationality'      => get_post_meta( $post->ID, 'player_nationality', 1 ),
			'player_weight'           => get_post_meta( $post->ID, 'player_weight', 1 ),
			'player_height'           => get_post_meta( $post->ID, 'player_height', 1 ),
		);

		$positionTerms = get_terms(
			array(
				'taxonomy'   => 'player-position',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		ob_start();
		include_once( BASKETBALL_TEAM_MANAGER_PLUGIN_PATH . 'admin/partials/player-data-form.php' );
		player_data_form( $post, $this->plugin_name, $playerData, $positionTerms );
		$form = ob_get_contents();
		ob_end_clean();

		echo $form;
	}

	public function remove_player_meta_box_duplicate() {
		global $post, $wp_meta_boxes;
		unset( $wp_meta_boxes['bt-players']['advanced'] );
	}

	public function save_players_data( $post_id ) {
		$post_type = $_POST['post_type'] ?? '';
		if ( isset( $_POST ) and $post_type == 'bt-players' ) {
			$playerData = array(
				'player_name',
				'player_position',
				'player_number',
				'player_total_games',
				'player_total_points',
				'player_total_3_pointers',
				'player_birthdate',
				'player_nationality',
				'player_weight',
				'player_height',
			);
		}

		$noncename = $_POST['bt_player_noncename'] ?? '';
		if ( ! wp_verify_nonce( $noncename, plugin_basename( __FILE__ ) ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		foreach ( $playerData as $field ) {
			update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
		}

		$this->updatePostTaxonomySingle( $post_id, $_POST['player_position'], 'player-position' );
	}

	private function updatePostTaxonomySingle( $post_id, $termData, $taxonomy ) {
		$term = get_term( $termData, $taxonomy );
		if ( isset( $term ) ) {
			wp_set_object_terms( $post_id, $term->term_id, $taxonomy );
		}
	}
}