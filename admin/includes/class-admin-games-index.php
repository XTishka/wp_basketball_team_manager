<?php

if (!class_exists('Admin_Games_Index')) {

	class Admin_Games_Index
	{

		public $plugin_name;

		// TODO: get team ID from configs
		public $my_team_id = 5;

		public function __construct($plugin_name)
		{
			$this->plugin_name = $plugin_name;
		}

		public function init()
		{
			add_filter('manage_bt-games_posts_columns', array($this, 'set_game_posts_columns'));
			add_action('manage_bt-games_posts_custom_column', array($this, 'populate_game_columns'), 10, 2);
		}

		public function set_game_posts_columns($columns)
		{
			$columns = array(
				'cb'                   => $columns['cb'],
				'title'                => __('Game Date', $this->plugin_name),
				'home_team'            => __('Home team', $this->plugin_name),
				'score'                => __('Score', $this->plugin_name),
				'guest_team'           => __('Guest team', $this->plugin_name),
				'taxonomy-seasons'     => __('Season', $this->plugin_name),
				'taxonomy-tournaments' => __('Tournament', $this->plugin_name),
				'taxonomy-arenas'      => __('Arena', $this->plugin_name),
				'date'                 => $columns['date'],
			);

			return $columns;
		}

		public function populate_game_columns($column, $post_id)
		{
			if ('home_team' === $column) {
				echo $this->get_team_name($post_id, 'teams', 'taxonomy_game_home_team');
			}

			if ('guest_team' === $column) {
				echo $this->get_team_name($post_id, 'teams', 'taxonomy_game_guest_team');
			}

			if ('score' === $column) {
				echo $this->get_score($post_id);
			}
		}

		private function get_team_name($post_id, $taxonomy, $meta_field)
		{
			$home_team = get_post_meta($post_id, $meta_field, true);
			$term      = get_term($home_team, $taxonomy);

			return $term->name;
		}

		private function get_term_name($post_id, $key, $taxonomy)
		{
			$home_team = get_post_meta($post_id, $key, true);
			$term      = get_term($home_team, $taxonomy);

			return $term->name;
		}

		private function get_score($post_id)
		{
			$home_team      = get_post_meta($post_id, 'taxonomy_game_home_team', true);
			$guest_team     = get_post_meta($post_id, 'taxonomy_game_guest_team', true);
			$homeTeamScore  = get_post_meta($post_id, 'game_home_team_score', true);
			$guestTeamScore = get_post_meta($post_id, 'game_guest_team_score', true);
			$score          = '';

			if (
				($home_team == $this->my_team_id and ($homeTeamScore > $guestTeamScore)) or
				($guest_team == $this->my_team_id and ($guestTeamScore > $homeTeamScore))
			) {
				$color  = '#00a32a';
				$result = __('win', $this->plugin_name);
			} else {
				$color  = '#e65054';
				$result = __('loss', $this->plugin_name);
			}

			if (
				($home_team == $this->my_team_id and ($homeTeamScore == $guestTeamScore)) or
				($guest_team == $this->my_team_id and ($guestTeamScore == $homeTeamScore))
			) {
				$color  = '#3582c4';
				$result = __('draw', $this->plugin_name);
			}

			if ($home_team != $this->my_team_id and $guest_team != $this->my_team_id) {
				$color  = '#787c82';
				$result = '';
			}

			if (!empty($homeTeamScore) and !empty($guestTeamScore)) {
				$score .= '<div style="color: ' . $color . '">';
				$score .= $homeTeamScore . ' :: ' . $guestTeamScore . '<br>' . $result;
				$score .= '</div>';
			} else {
				$score .= __('No game results', $this->plugin_name);
			}

			return $score;
		}
	}
}
