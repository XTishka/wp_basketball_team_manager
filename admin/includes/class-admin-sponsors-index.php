<?php

if (!class_exists('Admin_Sponsors_Index')) {

	class Admin_Sponsors_Index
	{

		public $plugin_name;

		public function __construct($plugin_name)
		{
			$this->plugin_name = $plugin_name;
		}

		public function init()
		{
			add_filter('manage_bt-sponsors_posts_columns', array($this, 'set_sponsor_posts_columns'));
			add_action('manage_bt-sponsors_posts_custom_column', array($this, 'populate_sponsor_columns'), 10, 2);
		}

		public function set_sponsor_posts_columns($columns)
		{
			$columns = array(
				'cb'                       	=> $columns['cb'],
				'title'                    	=> __('Sponsor', $this->plugin_name),
				'taxonomy-sponsor-category' => __('Category', $this->plugin_name),
				'logo'             			=> 'Logo',
				'date'                     	=> $columns['date'],
			);

			return $columns;
		}

		public function populate_sponsor_columns($column, $post_id)
		{
			if ('logo' === $column) {
				if (has_post_thumbnail($post_id) == true) {
					echo get_the_post_thumbnail($post_id, array(50,200));
				} else {
					echo '<img src="' . BASKETBALL_TEAM_MANAGER_PLUGIN_URL . 'admin/img/no-logo.png' . '" alt="" style="height: 50px">';
				}
			}
		}
	}
}
