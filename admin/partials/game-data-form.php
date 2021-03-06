<?php
function game_data_form( $gameData, $plugin_name, $teamsTerms, $arenasTerms, $seasonsTerms, $tournamentsTerms, $tvTerms, $sponsorsTerms, $arenas, $tournaments, $tv_channels, $teams ) {

	?>

    <div class="game-row">
        <div class="team-row">
            <div class="team">
                <label for="taxonomy_game_home_team"><?php echo __( "Home team", $plugin_name ); ?></label>
                <div class="home-team">
                    <select name="taxonomy_game_home_team" id="taxonomy_game_home_team">
						<?php foreach ( $teamsTerms as $team ) : ?>
							<?php if ( ! empty( $gameData['home_team'] ) ) : ?>
								<?php $selected = ( $gameData['home_team'] == $team->term_id ? 'selected' : '' ) ?>
							<?php else : ?>
								<?php $selected = ( esc_attr( get_option( 'btm_default_team' )) == $team->term_id ? 'selected' : '' ) ?>
							<?php endif; ?>
                            <option value="<?php echo $team->term_id ?>" <?php echo $selected ?>>
								<?php echo $team->name ?>
                            </option>
						<?php endforeach; ?>
                    </select>
                </div>
                <input type="text" id="game_home_team_score" name="game_home_team_score"
                       value="<?php echo $gameData['home_team_score']; ?>" placeholder="Score"/>
            </div>

            <p>:</p>

            <div class="team">
                <input type="text" id="game_guest_team_score" name="game_guest_team_score"
                       value="<?php echo $gameData['guest_team_score']; ?>" placeholder="Score"/>
                <div class="guest-team">
                    <select name="taxonomy_game_guest_team" id="taxonomy_game_guest_team">
						<?php foreach ( $teamsTerms as $team ) : ?>
							<?php if ( ! empty( $gameData['guest_team'] ) ) : ?>
								<?php $selected = ( $gameData['guest_team'] == $team->term_id ? 'selected' : '' ) ?>
							<?php else : ?>
								<?php $selected = ( esc_attr( get_option( 'btm_default_team' )) == $team->term_id ? 'selected' : '' ) ?>
							<?php endif; ?>
                            <option value="<?php echo $team->term_id ?>" <?php echo $selected ?>>
								<?php echo $team->name ?>
                            </option>
						<?php endforeach; ?>
                    </select>
                </div>
                <label class="guest"
                       for="taxonomy_game_guest_team"><?php echo __( "Guest team", $plugin_name ); ?></label>
            </div>
        </div>
    </div>

    <div class="game-row">
        <div class="time-and-place-row">
            <div class="date">
                <label for="game_date"><?php echo __( "Game Date", $plugin_name ); ?></label>
                <input type="text" id="game_date" name="game_date" value="<?php echo $gameData['date']; ?>"
                       autocomplete="off"/>
            </div>

            <div class="time">
                <label for="game_time"><?php echo __( "Game Time", $plugin_name ); ?></label>
                <input type="text" id="game_time" name="game_time" value="<?php echo $gameData['time']; ?>"
                       autocomplete="off"/>
            </div>

            <div class="arena">
                <label for="taxonomy_game_arena"><?php echo __( "Game Arena", $plugin_name ); ?></label>
                <select name="taxonomy_game_arena" id="taxonomy_game_arena" class="game-arena">
                    <option value="">Select a value ...</option>
					<?php foreach ( $arenasTerms as $arena ) : ?>
						<?php $selected = ( in_array( $arena->name, $arenas ) ? 'selected' : '' ) ?>
                        <option value="<?php echo $arena->term_id ?>" <?php echo $selected ?>>
							<?php echo $arena->name ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="taxonomies-row">
            <div class="season">
                <label for="taxonomy_game_season"><?php echo __( "Season", $plugin_name ); ?></label>
                <select name="taxonomy_game_season" id="taxonomy_game_season" class="game-season">
					<?php foreach ( $seasonsTerms as $season ) : ?>
						<?php $selected = ( $gameData['season'] == $season->term_id ? 'selected' : '' ) ?>
                        <option value="<?php echo $season->term_id ?>" <?php echo $selected ?>>
							<?php echo $season->name ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>
            <div class="tournament">
                <label for="taxonomy_game_tournament"><?php echo __( "Tournament", $plugin_name ); ?></label>
                <select name="taxonomy_game_tournament" id="taxonomy_game_tournament" class="game-tournament">
                    <option value="">Select a value ...</option>
					<?php foreach ( $tournamentsTerms as $tournament ) : ?>
						<?php $selected = ( in_array( $tournament->name, $tournaments ) ? 'selected' : '' ) ?>
                        <option value="<?php echo $tournament->term_id ?>" <?php echo $selected ?>>
							<?php echo $tournament->name ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>
            <div class="sponsor">
                <label for="taxonomy_game_sponsor"
                       style="display: none"><?php echo __( "Game Sponsor", $plugin_name ); ?></label>
                <select name="taxonomy_game_sponsor" id="taxonomy_game_sponsor" class="game-sponsor"
                        style="display: none;">
                    <option value="">Select a value ...</option>
                    <option value="__blank__">None</option>
					<?php foreach ( $sponsorsTerms as $sponsor ) : ?>
						<?php $selected = ( $gameData['sponsor'] == $sponsor->term_id ? 'selected' : '' ) ?>
                        <option value="<?php echo $sponsor->term_id ?>" <?php echo $selected ?>>
							<?php echo $sponsor->name ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>
        </div>

    </div>

    <div class="game-row">
        <div class="share-row">
            <div>
                <label for="game_statistics_link"><?php echo __( "Game Statistics link", $plugin_name ); ?></label>
                <input type="text" id="game_statistics_link" name="game_statistics_link"
                       value="<?php echo $gameData['statistics_link']; ?>" size="25"/>
            </div>

            <div>
                <label for="taxonomy_game_tv"><?php echo __( "TV", $plugin_name ); ?></label>
                <select name="taxonomy_game_tv" id="taxonomy_game_tv">
                    <option value="">Select a value ...</option>
					<?php foreach ( $tvTerms as $tv ) : ?>
						<?php $selected = ( in_array( $tv->name, $tv_channels ) ? 'selected' : '' ) ?>
                        <option value="<?php echo $tv->term_id ?>" <?php echo $selected ?>>
							<?php echo $tv->name ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="game_tv_link"><?php echo __( "TV Link", $plugin_name ); ?></label>
                <input type="text" id="game_tv_link" name="game_tv_link" value="<?php echo $gameData['tv_link']; ?>"
                       autocomplete="off"/>
            </div>
        </div>
    </div>

    <div class="game-row">
        <div class="calendar-row">
            <div>
                <label for="game_calendar_event_id"><?php echo __( "Google Calendar Event ID", $plugin_name ); ?></label>
                <input type="text" id="game_calendar_event_id" name="game_calendar_event_id"
                       value="<?php echo $gameData['calendar_event_id']; ?>" size="25"/>
            </div>
        </div>
    </div>

    <script>
        // jQuery('#game_date').datetimepicker({
        //     timepicker: false,
        //     format: 'Y-m-d'
        // });
        //
        // jQuery('#game_time').datetimepicker({
        //     datepicker: false,
        //     format: 'H:i'
        // });
    </script>

	<?php
}
