<?php

if ( ! class_exists( 'Admin_Staff_Index' ) ) {

	class Admin_Staff_Index {

		public $plugin_name;

		public function __construct( $plugin_name ) {
			$this->plugin_name = $plugin_name;
		}

		public function init() {
			add_filter( 'manage_bt-staff_posts_columns', array( $this, 'set_staff_posts_columns' ) );
			add_action( 'manage_bt-staff_posts_custom_column', array( $this, 'populate_staff_columns' ), 10, 2 );
		}

		public function set_staff_posts_columns( $columns ) {
			$columns = array(
				'cb'                      => $columns['cb'],
				'member_photo'            => '',
				'title'                   => __( 'Team member', $this->plugin_name ),
				'taxonomy-staff-position' => __( 'Position', $this->plugin_name ),
				'member_birthdate'        => __( 'Birthday', $this->plugin_name ),
				'member_in_club_since'    => __( 'In club since', $this->plugin_name ),
				'date'                    => $columns['date'],
			);

			return $columns;
		}

		public function populate_staff_columns( $column, $post_id ) {
			if ( 'member_photo' === $column ) {
				if (has_post_thumbnail($post_id) == true) {
					echo get_the_post_thumbnail( $post_id, array(80, 80) );
				} else {
					echo '<img src="' . BASKETBALL_TEAM_MANAGER_PLUGIN_URL . 'admin/img/staff-member-default.png' . '" alt="" style="width: 80px">';
				}
			}

			if ( 'member_birthdate' === $column ) {
				echo get_post_meta( $post_id, 'member_birthdate', true );
			}

			if ( 'member_in_club_since' === $column ) {
				echo get_post_meta( $post_id, 'member_in_club_since', true );
			}
		}
	}
}