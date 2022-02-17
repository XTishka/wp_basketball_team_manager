<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/XTishka
 * @since      1.0.0
 *
 * @package    Basketball_Team_Manager
 * @subpackage Basketball_Team_Manager/admin/partials
 */
?>

<?php function btm_settings_tabs( $plugin_name, $tabs, $current_tab, $teams ) { ?>
    <div class="wrap">
        <h1>Basketball Team Manager</h1>

		<?php
		?>

        <h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $tab => $name ) : ?>
				<?php $class = ( $tab == $current_tab ) ? 'nav-tab-active' : ''; ?>
                <a class="nav-tab <?php echo $class ?>" href="?page=bt-manager&tab=<?php echo $tab; ?>">
					<?php echo $name; ?>
                </a>
			<?php endforeach; ?>
        </h2>


		<?php if ( $current_tab == 'settings' ) : ?>

            <form method="post" action="options.php">
				<?php settings_fields( 'btm-settings-group' ); ?>
				<?php do_settings_sections( 'btm-settings-group' ); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php echo __( 'Your team', $plugin_name ); ?></th>
                        <td>
                            <select name="btm_default_team" id="btm_default_team">
								<?php foreach ( $teams as $team ) : ?>
									<?php $selected = ( esc_attr( get_option( 'btm_default_team' ) ) == $team->term_id ? 'selected' : '' ) ?>
                                    <option value="<?php echo $team->term_id ?>" <?php echo $selected ?>>
										<?php echo $team->name ?>
                                    </option>
								<?php endforeach; ?>
                            </select>
                            <p class="description">
								<?php echo __( 'Select your team from the list', $plugin_name ); ?>
                            </p>
                        </td>
                    </tr>
                </table>

				<?php submit_button(); ?>
            </form>

		<?php elseif ( $current_tab == 'calendar' ) : ?>
            <form method="post" action="options.php">
				<?php settings_fields( 'btm-settings-calendar-group' ); ?>
				<?php do_settings_sections( 'btm-settings-calendar-group' ); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php echo __('Post Game events to Google Calendar?', $plugin_name) ?></th>
                        <td>
                            <?php $checked = (esc_attr( get_option('btm_post_to_google_calendar') == 'on') ? 'checked' : ''); ?>
                            <input type="checkbox" name="btm_post_to_google_calendar" <?php echo $checked; ?> />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><?php echo __('Google calendar ID', $plugin_name) ?></th>
                        <td>
                            <input type="text" name="btm_google_calendar_id" value="<?php echo esc_attr( get_option('btm_google_calendar_id') ); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><?php echo __('Time zone', $plugin_name) ?></th>
                        <td>
                            <input type="text" name="btm_google_calendar_time_zone" value="<?php echo esc_attr( get_option('btm_google_calendar_time_zone') ); ?>" />
                            <p class="description">
		                        <?php echo __( 'Example: Europe/Copenhagen', $plugin_name ); ?>
                            </p>
                        </td>
                    </tr>
                </table>

				<?php submit_button(); ?>

            </form>
		<?php endif; ?>
    </div>
<?php } ?>


