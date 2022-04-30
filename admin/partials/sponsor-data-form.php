<?php
function sponsor_data_form($post, $plugin_name, $sponsorData, $categoryTerms, $sponsorCategories)
{ ?>

    <div class="sponsor-wrapper">
        <div class="form">
            <div class="row">
                <label for="sponsors_link"><?php echo __("Sponsors link", $plugin_name); ?></label>
                <input type="text" id="sponsors_link" name="sponsors_link" value="<?php echo $sponsorData['sponsors_link']; ?>" />
            </div>

            <div class="row">
                <label for="sponsors_category"><?php echo __("Category", $plugin_name); ?></label>
                <select name="sponsors_category[]" id="sponsors_category" class="video-category" multiple="multiple">
		            <?php foreach ($categoryTerms as $position) : ?>
			            <?php $selected = (in_array($position->name, $sponsorCategories) ? 'selected' : '') ?>
                        <option value="<?php echo $position->term_id ?>" <?php echo $selected ?>>
				            <?php echo $position->name ?>
                        </option>
		            <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
<?php
}
