<?php
function staff_member_data_form($post, $plugin_name, $memberData, $positionTerms, $staffPositions)
{ ?>

    <div class="player-wrapper">
        <div class="featured_image">
            <?php $featured_image = get_the_post_thumbnail_url($post->ID, 'thumbnail') ?? '' ?>
            <?php if ($featured_image != '') : ?>
                <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'large') ?>" alt="">
            <?php else : ?>
                <img src="<?php echo BASKETBALL_TEAM_MANAGER_PLUGIN_URL . 'admin/img/staff-member-default.png' ?>" alt="">
            <?php endif; ?>
        </div>

        <div class="form">
            <div class="row">
                <div class="member_name">
                    <label for="member_name"><?php echo __("Name", $plugin_name); ?></label>
                    <input type="text" id="member_name" name="member_name" value="<?php echo $memberData['member_name']; ?>" />
                </div>

                <div class="member_position">
                    <label for="member_position"><?php echo __("Position", $plugin_name); ?></label>
                    <select name="member_position" id="member_position">
                        <option value="">None</option>
                        <?php foreach ($positionTerms as $position) : ?>
                            <?php $selected = (in_array($position->name, $staffPositions) ? 'selected' : '') ?>
                            <option value="<?php echo $position->term_id ?>" <?php echo $selected ?>>
                                <?php echo $position->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="member_birthdate">
                    <label for="member_birthdate"><?php echo __("Birthday", $plugin_name); ?></label>
                    <input type="text" id="member_birthdate" name="member_birthdate" value="<?php echo $memberData['member_birthdate']; ?>" autocomplete="off" />
                </div>

                <div class="member_in_club_since">
                    <label for="member_in_club_since"><?php echo __("In club since", $plugin_name); ?></label>
                    <input type="text" id="member_in_club_since" name="member_in_club_since" value="<?php echo $memberData['member_in_club_since']; ?>" autocomplete="off" />
                </div>

            </div>
        </div>
    </div>

    <script>
        jQuery('#member_birthdate').datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });

        jQuery('#member_in_club_since').datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });
    </script>

<?php
}
