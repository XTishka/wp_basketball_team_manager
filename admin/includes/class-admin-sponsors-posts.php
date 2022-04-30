<?php

class Admin_Sponsor_Posts extends Basketball_Team_Manager_Admin
{

	private $plugin_name;

	public function register_sponsor_posts()
	{
		$labels = [
			'name'               => _x('Sponsors', 'Post Type General Name', $this->plugin_name),
			'singular_name'      => _x('Sponsor', 'Post Type Singular Name', $this->plugin_name),
			'menu_name'          => __('BT Sponsors', $this->plugin_name),
			'parent_item_colon'  => __('Parent Sponsor', $this->plugin_name),
			'all_items'          => __('All Sponsors', $this->plugin_name),
			'view_item'          => __('View Sponsor', $this->plugin_name),
			'add_new_item'       => __('Add New Sponsor', $this->plugin_name),
			'add_new'            => __('Add Sponsor', $this->plugin_name),
			'edit_item'          => __('Edit Sponsor', $this->plugin_name),
			'update_item'        => __('Update Sponsor', $this->plugin_name),
			'search_items'       => __('Search Sponsor', $this->plugin_name),
			'not_found'          => __('Not Found', $this->plugin_name),
			'not_found_in_trash' => __('Not found in Trash', $this->plugin_name),
		];

		$args = [
			'label'               => __('bt-sponsors', $this->plugin_name),
			'description'         => __('Team sponsors', $this->plugin_name),
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
			'menu_position'       => 34,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'menu_icon'           => $this->menuIcon,

		];

		register_post_type('bt-sponsors', $args);
	}

	public function register_category_taxonomy()
	{
		$labels = array(
			'name'                       => _x('Categories', 'taxonomy general name'),
			'singular_name'              => _x('Category', 'taxonomy singular name'),
			'search_items'               => __('Search Categories'),
			'popular_items'              => __('Popular Categories'),
			'all_items'                  => __('All Categories'),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __('Edit Category'),
			'update_item'                => __('Update Category'),
			'add_new_item'               => __('Add New Category'),
			'new_item_name'              => __('New Category Name'),
			'separate_items_with_commas' => __('Separate categories with commas'),
			'add_or_remove_items'        => __('Add or remove categories'),
			'choose_from_most_used'      => __('Choose from the most used categories'),
			'menu_name'                  => __('Categories'),
		);

		register_taxonomy('sponsor-category', 'bt-sponsors', array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'sponsor-category'),
		));
	}

	public function sponsor_meta_box()
	{
		add_meta_box(
			'btm-sponsor-meta_box',
			'Sponsor data',
			array($this, 'sponsor_meta_box_callback'),
			array('bt-sponsors'),
			'advanced',
			'high'
		);
	}

	public function sponsor_meta_box_callback($post, $meta)
	{
		$screens = $meta['args'];
		wp_nonce_field(plugin_basename(__FILE__), 'bt_sponsor_noncename');

		$sponsorData = array(
			'sponsors_link' => get_post_meta($post->ID, 'sponsors_link', 1),
			'sponsors_category'   => get_post_meta($post->ID, 'sponsors_category', 1),
		);

		$sponsorCategories = array();
		$sponsorCategoriesTaxonomies = get_the_terms($post->ID, 'sponsor-category');
		if (!empty($sponsorCategoriesTaxonomies)) {
			foreach ($sponsorCategoriesTaxonomies as $taxonomy) {
				array_push($sponsorCategories, $taxonomy->name);
			}
		}

		$categoryTerms = get_terms(
			array(
				'taxonomy'   => 'sponsor-category',
				'hide_empty' => false,
				'orderby'    => 'id',
				'order'      => 'ASC',
			)
		);

		ob_start();
		include_once(BASKETBALL_TEAM_MANAGER_PLUGIN_PATH . 'admin/partials/sponsor-data-form.php');
		sponsor_data_form($post, $this->plugin_name, $sponsorData, $categoryTerms, $sponsorCategories);
		$form = ob_get_contents();
		ob_end_clean();

		echo $form;
	}

	public function remove_sponsor_meta_box_duplicate()
	{
		global $post, $wp_meta_boxes;
		unset($wp_meta_boxes['bt-sponsors']['advanced']);
	}

	public function save_sponsor_data($post_id)
	{
		$post_type = $_POST['post_type'] ?? '';
		if (isset($_POST) and $post_type == 'bt-sponsors') {
			$playerData = array(
				'sponsors_link',
				'sponsors_category',
			);
		}

		$noncename = $_POST['bt_sponsor_noncename'] ?? '';
		if (!wp_verify_nonce($noncename, plugin_basename(__FILE__))) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		foreach ($playerData as $field) {
			update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
		}

		$this->updatePostTaxonomyMultiple($post_id, $_POST['sponsors_category'], 'sponsor-category');
	}

	private function updatePostTaxonomySingle($post_id, $termData, $taxonomy)
	{
		$term = get_term($termData, $taxonomy);
		if (isset($term)) {
			wp_set_object_terms($post_id, $term->term_id, $taxonomy);
		}
	}

	private function updatePostTaxonomyMultiple($post_id, $termData, $taxonomy)
	{
		$terms = array();
		foreach ($termData as $term) {
			$termName = get_term($term, $taxonomy);
			if (isset($termName)) {
				array_push($terms, $termName->name);
			}
		}
		wp_set_object_terms($post_id, $terms, $taxonomy);
	}
}
