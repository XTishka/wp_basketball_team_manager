<?php
class Admin_Team_Posts extends Basketball_Team_Manager_Admin {

	private $plugin_name;

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
}