<?php

if ( ! class_exists( 'Admin_Taxonomy_Filters' ) ) {

	class Admin_Taxonomy_Filters {

		public $post_type;
		public $taxonomy;

		public function __construct( $post_type, $taxonomy ) {
			$this->post_type = $post_type;
			$this->taxonomy  = $taxonomy;
		}

		public function init() {
			add_action( 'restrict_manage_posts', array( $this, 'filter_games_by_seasons' ) );
			add_action( 'parse_query', array( $this, 'filter_games_by_seasons_query' ) );
		}

		public function filter_games_by_seasons() {
			global $typenow;
			if ( $typenow == $this->post_type ) {
				$selected      = isset( $_GET[ $this->taxonomy ] ) ? $_GET[ $this->taxonomy ] : '';
				$info_taxonomy = get_taxonomy( $this->taxonomy );
				wp_dropdown_categories( array(
					'show_option_all' => sprintf( __( 'Show all %s', 'textdomain' ), $info_taxonomy->label ),
					'taxonomy'        => $this->taxonomy,
					'name'            => $this->taxonomy,
					'orderby'         => 'name',
					'selected'        => $selected,
					'show_count'      => true,
					'hide_empty'      => true,
				) );
			};
		}

		function filter_games_by_seasons_query( $query ) {
			global $pagenow;
			$taxonomy  = $this->taxonomy;
			$q_vars    = &$query->query_vars;
			if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $this->post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
				$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
				$q_vars[ $taxonomy ] = $term->slug;
			}
		}
	}
}
