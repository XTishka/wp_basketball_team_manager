<?php
class Admin_Staff_Posts extends Basketball_Team_Manager_Admin {

	private $plugin_name;

	public function register_staff_posts() {
		$labels = [
			'name'               => _x( 'Members', 'Post Type General Name', $this->plugin_name ),
			'singular_name'      => _x( 'Member', 'Post Type Singular Name', $this->plugin_name ),
			'menu_name'          => __( 'BT Staff', $this->plugin_name ),
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
			'label'               => __( 'bt-staff', $this->plugin_name ),
			'description'         => __( 'Staff members', $this->plugin_name ),
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
			'menu_position'       => 33,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'menu_icon'           => $this->menuIcon,

		];

		register_post_type( 'bt-staff', $args );
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

		register_taxonomy( 'staff-member', 'bt-staff', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'staff-member' ),
		) );
	}

	public function staff_member_meta_box() {
		add_meta_box(
			'btm-staff-member-meta_box',
			'Staff member data',
			array( $this, 'staff_member_meta_box_callback' ),
			array( 'bt-staff' ),
			'advanced',
			'high'
		);
	}

	public function staff_member_meta_box_callback( $post, $meta ) {
		$screens = $meta['args'];
		wp_nonce_field( plugin_basename( __FILE__ ), 'bt_staff_member_noncename' );

		ob_start();
		include_once( BASKETBALL_TEAM_MANAGER_PLUGIN_PATH . 'admin/partials/staff-member-data-form.php' );
		staff_member_data_form(  );
		$form = ob_get_contents();
		ob_end_clean();

		echo $form;
	}

	public function remove_staff_member_meta_box_duplicate() {
		global $post, $wp_meta_boxes;
		unset( $wp_meta_boxes['bt-staff']['advanced'] );
	}
}