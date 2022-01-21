<?php
function player_data_form($post, $plugin_name, $playerData, $positionTerms, $statusTerms)
{ ?>

    <div class="player-wrapper">
        <div class="featured_image" style="max-height: 300px; overflow: hidden;">
            <?php $featured_image = get_the_post_thumbnail_url($post->ID, 'thumbnail') ?? '' ?>
            <?php if ($featured_image != '') : ?>
                <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'large') ?>" alt="">
            <?php else : ?>
                <img src="<?php echo BASKETBALL_TEAM_MANAGER_PLUGIN_URL . 'admin/img/player-default.png' ?>" alt="">
            <?php endif; ?>
        </div>

        <div class="form">
            <div class="row">
                <div class="player_name">
                    <label for="player_name"><?php echo __("Name", $plugin_name); ?></label>
                    <input type="text" id="player_name" name="player_name" value="<?php echo $playerData['player_name']; ?>" />
                </div>

                <div class="player_position">
                    <label for="player_position"><?php echo __("Position", $plugin_name); ?></label>
                    <select name="player_position" id="player_position">
                        <?php foreach ($positionTerms as $position) : ?>
                            <?php $selected = ($playerData['player_position'] == $position->term_id ? 'selected' : '') ?>
                            <option value="<?php echo $position->term_id ?>" <?php echo $selected ?>>
                                <?php echo $position->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="player_number">
                    <label for="player_number"><?php echo __("Number", $plugin_name); ?></label>
                    <input type="text" id="player_number" name="player_number" type="number" value="<?php echo $playerData['player_number']; ?>" />
                </div>

                <div class="player_status">
                    <label for="player_status"><?php echo __("Status", $plugin_name); ?></label>
                    <select name="player_status" id="player_status" class="game-status">
                        <?php foreach ($statusTerms as $status) : ?>
                            <?php $selected = ($playerData['player_status'] == $status->term_id ? 'selected' : '') ?>
                            <option value="<?php echo $status->term_id ?>" <?php echo $selected ?>>
                                <?php echo $status->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="total_games">
                    <label for="player_total_games"><?php echo __("Total games", $plugin_name); ?></label>
                    <input type="text" id="player_total_games" name="player_total_games" value="<?php echo $playerData['player_total_games']; ?>" />
                </div>

                <div class="player_total_points">
                    <label for="player_total_points"><?php echo __("Total points", $plugin_name); ?></label>
                    <input type="text" id="player_total_points" name="player_total_points" value="<?php echo $playerData['player_total_points']; ?>" />
                </div>

                <div class="player_total_3_pointers">
                    <label for="player_total_3_pointers"><?php echo __("Total 3-pointers", $plugin_name); ?></label>
                    <input type="text" id="player_total_3_pointers" name="player_total_3_pointers" value="<?php echo $playerData['player_total_3_pointers']; ?>" />
                </div>
            </div>

            <div class="row">
                <div class="player_birthdate">
                    <label for="player_birthdate"><?php echo __("Birthday", $plugin_name); ?></label>
                    <input type="text" id="player_birthdate" name="player_birthdate" value="<?php echo $playerData['player_birthdate']; ?>" autocomplete="off" />
                </div>

                <div class="player_nationality">
                    <label for="player_nationality"><?php echo __("Nationality", $plugin_name); ?></label>
                    <input type="text" id="player_nationality" name="player_nationality" value="<?php echo $playerData['player_nationality']; ?>" />
                </div>

                <div class="player_weight">
                    <label for="player_weight"><?php echo __("Weight", $plugin_name); ?></label>
                    <input type="text" id="player_weight" name="player_weight" value="<?php echo $playerData['player_weight']; ?>" />
                </div>

                <div class="player_height">
                    <label for="player_height"><?php echo __("Height", $plugin_name); ?></label>
                    <input type="text" id="player_height" name="player_height" value="<?php echo $playerData['player_height']; ?>" />
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery('#player_birthdate').datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });
    </script>

<?php
}
