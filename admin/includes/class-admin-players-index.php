<?php

if (!class_exists('Admin_Players_Index')) {

	class Admin_Players_Index
	{

		public $plugin_name;

		public function __construct($plugin_name)
		{
			$this->plugin_name = $plugin_name;
		}

		public function init()
		{
			add_filter('manage_bt-players_posts_columns', array($this, 'set_player_posts_columns'));
			add_action('manage_bt-players_posts_custom_column', array($this, 'populate_player_columns'), 10, 2);
		}

		public function set_player_posts_columns($columns)
		{
			$columns = array(
				'cb'                       => $columns['cb'],
				'player_photo'             => '',
				'title'                    => __('Player', $this->plugin_name),
				'player_number'            => __('Number', $this->plugin_name),
				'taxonomy-player-position' => __('Position', $this->plugin_name),
				'player_total_games'       => __('Total games', $this->plugin_name),
				'player_total_points'      => __('Total points', $this->plugin_name),
				'player_total_3_pointers'  => __('Total 3-pointers', $this->plugin_name),
				'taxonomy-player-status'   => __('Status', $this->plugin_name),
				'date'                     => $columns['date'],
			);

			return $columns;
		}

		public function populate_player_columns($column, $post_id)
		{
			if ('player_photo' === $column) {
				if (has_post_thumbnail($post_id) == true) {
					echo get_the_post_thumbnail($post_id, array(80, 80));
				} else {
					echo '<img src="' . BASKETBALL_TEAM_MANAGER_PLUGIN_URL . 'admin/img/player-default.png' . '" alt="" style="width: 80px">';
				}
			}

			if ('player_number' === $column) {
				echo get_post_meta($post_id, 'player_number', true);
			}

			if ('player_total_games' === $column) {
				echo get_post_meta($post_id, 'player_total_games', true);
			}

			if ('player_total_points' === $column) {
				echo get_post_meta($post_id, 'player_total_points', true);
			}

			if ('player_total_3_pointers' === $column) {
				echo get_post_meta($post_id, 'player_total_3_pointers', true);
			}
		}
	}
}
