<?php
function video_data_form($post, $plugin_name, $videoData, $categoryTerms, $videoCategories)
{ ?>
    <div class="video-wrapper">

        <div class="form">
            <div class="row">
                <label for="video_category"><?php echo __("Category", $plugin_name); ?></label>
                <select name="video_category[]" id="video_category" class="video-category" multiple="multiple">
                    <?php foreach ($categoryTerms as $category) : ?>
                        <?php $selected = (in_array($category->name, $videoCategories) ? 'selected' : '') ?>
                        <option value="<?php echo $category->term_id ?>" <?php echo $selected ?>>
                            <?php echo $category->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <hr>

            <div class="row">
                <label for="video_youtube_id"><?php echo __("Youtube ID", $plugin_name); ?></label>
                <input type="text" id="video_youtube_id" name="video_youtube_id" value="<?php echo $videoData['video_youtube_id']; ?>" />
            </div>

            <div class="row">
                <label for="video_link"><?php echo __("Link to video", $plugin_name); ?></label>
                <input type="text" id="video_link" name="video_link" value="<?php echo $videoData['video_link']; ?>" />
            </div>

            <div class="row">
                <label for="video_embed"><?php echo __("Embed video", $plugin_name); ?></label>
                <input type="text" id="video_embed" name="video_embed" value="<?php echo $videoData['video_embed']; ?>" />
            </div>
        </div>
    </div>
<?php
}
