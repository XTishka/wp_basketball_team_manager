<?php

/**
 * Plugin class
 **/
if (!class_exists('Admin_Taxonomy_Field_Subcategory')) {

	class Admin_Taxonomy_Field_Subcategory
	{

		public $taxonomy;

		public function __construct($taxonomy)
		{
			$this->taxonomy = $taxonomy;
		}

		/*
		 * Initialize the class and start calling our hooks and filters
		 * @since 1.0.0
		*/
		public function init()
		{
			add_action($this->taxonomy . '_add_form_fields', array($this, 'add_subcategory_field'), 10, 2);
			add_action('created_' . $this->taxonomy, array($this, 'save_subcategory'), 10, 2);
			add_action($this->taxonomy . '_edit_form_fields', array($this, 'update_subcategory'), 10, 2);
			add_action('edited_' . $this->taxonomy, array($this, 'updated_category_image'), 10, 2);
		}

		/*
		 * Add a form field in the new category page
		 * @since 1.0.0
		*/
		public function add_subcategory_field($taxonomy)
		{ ?>
			<div class="form-field">
				<label for="taxonomy_subcategory">Category</label>
				<select name="taxonomy_subcategory[]" id="taxonomy_subcategory" multiple="multiple">
						<?php foreach ($this->getAllSubcategories() as $subcategory) : ?>
							<option value="<?php echo $subcategory ?>"><?php echo $subcategory ?></option>
						<?php endforeach; ?>
					</select>
				<p>Select or create new taxonomy category</p>
			</div>
		<?php
		}

		/*
		 * Save the form field
		 * @since 1.0.0
		*/
		public function save_subcategory($term_id, $tt_id)
		{
			if (isset($_POST['taxonomy_subcategory']) && '' !== $_POST['taxonomy_subcategory']) {
				$image = $_POST['taxonomy_subcategory'];
				add_term_meta($term_id, 'taxonomy_subcategory', $image, true);
			}
		}

		/*
		 * Edit the form field
		 * @since 1.0.0
		*/
		public function update_subcategory($term, $taxonomy)
		{ ?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="taxonomy_subcategory">Category</label>
				</th>
				<td>
					<select name="taxonomy_subcategory[]" id="taxonomy_subcategory" multiple="multiple">
						<?php $subcategories = get_term_meta($term->term_id, 'taxonomy_subcategory', true); ?>
						<?php foreach ($this->getAllSubcategories() as $subcategory) : ?>
							<?php if (in_array($subcategory, $subcategories)) : ?>
								<option value="<?php echo $subcategory ?>" selected><?php echo $subcategory ?></option>
							<?php else : ?>
								<option value="<?php echo $subcategory ?>"><?php echo $subcategory ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
					<p>Select or create new taxonomy category</p>
				</td>
			</tr>
<?php
		}

		/*
		 * Update the form field value
		 * @since 1.0.0
		 */
		public function updated_category_image($term_id, $tt_id)
		{
			if (isset($_POST['taxonomy_subcategory']) && '' !== $_POST['taxonomy_subcategory']) {
				$image = $_POST['taxonomy_subcategory'];
				update_term_meta($term_id, 'taxonomy_subcategory', $image);
			} else {
				update_term_meta($term_id, 'taxonomy_subcategory', '');
			}
		}

		public function getAllSubcategories() {
			$categories = get_terms(array(
				'hide_empty'  => 0,
				'orderby'     => 'name',
				'order'       => 'ASC',
				'taxonomy'    => $this->taxonomy,
				'pad_counts'  => 1
			));

			$taxonomySubcategories = array();
			foreach ($categories as $category) {
				$subcategories = get_term_meta($category->term_id, 'taxonomy_subcategory', true);
				foreach ($subcategories as $subcategory) {
					array_push($taxonomySubcategories, $subcategory);
				}
			}

			return $taxonomySubcategories;
		}
	}
}
