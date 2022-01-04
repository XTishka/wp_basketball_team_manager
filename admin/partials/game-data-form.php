<?php
function game_data_form( $gameData, $plugin_name, $teamsTerms, $arenasTerms, $seasonsTerms, $tournamentsTerms, $tvTerms, $sponsorsTerms ) { ?>

    <div class="game-row">
        <div class="team-row">
            <div class="team">
                <label for="game_home_team"><?php echo __( "Home team", $plugin_name ); ?></label>
                <div class="home-team">
                    <select name="game_home_team" id="game_home_team">
						<?php foreach ( $teamsTerms as $team ) : ?>
                            <?php $selected = ($gameData['home_team'] == $team->term_id ? 'selected' : '' ) ?>
                            <option value="<?php echo $team->term_id ?>" <?php echo $selected ?> >
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
                    <select name="game_guest_team" id="game_guest_team">
						<?php foreach ( $teamsTerms as $team ) : ?>
							<?php $selected = ($gameData['guest_team'] == $team->term_id ? 'selected' : '' ) ?>
                            <option value="<?php echo $team->term_id ?>" <?php echo $selected ?> >
                                <?php echo $team->name ?>
                            </option>
						<?php endforeach; ?>
                    </select>
                </div>
                <label class="guest" for="game_guest_team"><?php echo __( "Guest team", $plugin_name ); ?></label>
            </div>
        </div>
    </div>

    <div class="game-row">
        <div class="time-and-place-row">
            <div class="date">
                <label for="game_date"><?php echo __( "Game Date", $plugin_name ); ?></label>
                <input type="text" id="game_date" name="game_date" value="<?php echo $gameData['date']; ?>" autocomplete="off" />
            </div>

            <div class="time">
                <label for="game_time"><?php echo __( "Game Time", $plugin_name ); ?></label>
                <input type="text" id="game_time" name="game_time" value="<?php echo $gameData['time']; ?>"  autocomplete="off" />
            </div>

            <div class="arena">
                <label for="game_arena"><?php echo __( "Game Arena", $plugin_name ); ?></label>
                <select name="game_arena" id="game_arena" class="game-arena">
	                <?php foreach ( $arenasTerms as $arena ) : ?>
		                <?php $selected = ($gameData['arena'] == $arena->term_id ? 'selected' : '' ) ?>
                        <option value="<?php echo $arena->term_id ?>" <?php echo $selected ?> >
			                <?php echo $arena->name ?>
                        </option>
	                <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="taxonomies-row">
            <div class="season">
                <label for="game_season"><?php echo __( "Season", $plugin_name ); ?></label>
                <select name="game_season" id="game_season" class="game-season">
	                <?php foreach ( $seasonsTerms as $season ) : ?>
		                <?php $selected = ($gameData['season'] == $season->term_id ? 'selected' : '' ) ?>
                        <option value="<?php echo $season->term_id ?>" <?php echo $selected ?> >
			                <?php echo $season->name ?>
                        </option>
	                <?php endforeach; ?>
                </select>
            </div>
            <div class="tournament">
                <label for="game_tournament"><?php echo __( "Tournament", $plugin_name ); ?></label>
                <select name="game_tournament" id="game_tournament" class="game-tournament">
	                <?php foreach ( $tournamentsTerms as $tournament ) : ?>
		                <?php $selected = ($gameData['tournament'] == $tournament->term_id ? 'selected' : '' ) ?>
                        <option value="<?php echo $tournament->term_id ?>" <?php echo $selected ?> >
			                <?php echo $tournament->name ?>
                        </option>
	                <?php endforeach; ?>
                </select>
            </div>
            <div class="sponsor">
                <label for="game_sponsor"><?php echo __( "Game Sponsor", $plugin_name ); ?></label>
                <select name="game_sponsor" id="game_sponsor" class="game-sponsor">
		            <?php foreach ( $sponsorsTerms as $sponsor ) : ?>
			            <?php $selected = ($gameData['sponsor'] == $sponsor->term_id ? 'selected' : '' ) ?>
                        <option value="<?php echo $sponsor->term_id ?>" <?php echo $selected ?> >
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
                <label for="game_tv"><?php echo __( "TV", $plugin_name ); ?></label>
                <select name="game_tv" id="game_tv">
		            <?php foreach ( $tvTerms as $tv ) : ?>
			            <?php $selected = ($gameData['tv'] == $tv->term_id ? 'selected' : '' ) ?>
                        <option value="<?php echo $tv->term_id ?>" <?php echo $selected ?> >
				            <?php echo $tv->name ?>
                        </option>
		            <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="game_tv_link"><?php echo __( "TV Link", $plugin_name ); ?></label>
                <input type="text" id="game_tv_link" name="game_tv_link" value="<?php echo $gameData['tv_link']; ?>"  autocomplete="off" />
            </div>
        </div>
    </div>

    <script>
        jQuery('#game_date').datetimepicker(
            {
                timepicker: false,
                format: 'Y-m-d'
            }
        );

        jQuery('#game_time').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });
    </script>

	<?php
}
