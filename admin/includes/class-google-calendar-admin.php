<?php

class GoogleCalendarAdmin {
	public $timeZone = 'Europe/Copenhagen';

	public $calendarId = 'ko3k9ovgss83mtsggml7hl9pr4@group.calendar.google.com';

	/**
	 * Returns an authorized API client.
	 * @return Google_Client the authorized client object
	 */
	public function getClient() {
		$client = new Google_Client();
		$client->setApplicationName( 'Google Calendar API PHP Quickstart' );
		$client->setScopes( Google_Service_Calendar::CALENDAR_EVENTS );

		$client->setAuthConfig( plugin_dir_path( __FILE__ ) . '../../includes/credentials.json' );
		$client->setAccessType( 'online' );
		$client->setPrompt( 'select_account consent' );

		// Load previously authorized token from a file, if it exists.
		// The file token.json stores the user's access and refresh tokens, and is
		// created automatically when the authorization flow completes for the first
		// time.
		$tokenPath = plugin_dir_path( __FILE__ ) . '../../includes/token.json';
		if ( file_exists( $tokenPath ) ) {
			$accessToken = json_decode( file_get_contents( $tokenPath ), true );
			$client->setAccessToken( $accessToken );
		}

		// If there is no previous token or it's expired.
		if ( $client->isAccessTokenExpired() ) {
			// Refresh the token if possible, else fetch a new one.
			if ( $client->getRefreshToken() ) {
				$client->fetchAccessTokenWithRefreshToken( $client->getRefreshToken() );
			} else {
				// Request authorization from the user.
				$authUrl = $client->createAuthUrl();
				printf( "Open the following link in your browser:\n%s\n", $authUrl );
				print 'Enter verification code: ';
				$authCode = trim( fgets( STDIN ) );

				// Exchange authorization code for an access token.
				$accessToken = $client->fetchAccessTokenWithAuthCode( $authCode );
				$client->setAccessToken( $accessToken );

				// Check to see if there was an error.
				if ( array_key_exists( 'error', $accessToken ) ) {
					throw new Exception( join( ', ', $accessToken ) );
				}
			}
			// Save the token to a file.
			if ( ! file_exists( dirname( $tokenPath ) ) ) {
				mkdir( dirname( $tokenPath ), 0700, true );
			}
			file_put_contents( $tokenPath, json_encode( $client->getAccessToken() ) );
		}

		return $client;
	}


	public function createEvent( $data ) {
		$client  = $this->getClient();
		$service = new Google_Service_Calendar( $client );

//		echo $this->getSummary( $data );
//		echo '<br>';
//		echo $this->getDescription( $data );
//		echo '<br>';
//		echo $this->getStartTime( $data );
//		echo '<br>';
//		echo $this->getEndTime( $data );

		$event = new Google_Service_Calendar_Event( array(
			'summary'     => $this->getSummary( $data ),
			'description' => $this->getDescription( $data ),
			'start'       => array(
				'dateTime' => $this->getStartTime( $data ),
				'timeZone' => $this->timeZone,
			),
			'end'         => array(
				'dateTime' => $this->getEndTime( $data ),
				'timeZone' => $this->timeZone,
			),
		) );

		$event = new Google_Service_Calendar_Event(array(
			'summary' => 'Google I/O 2015',
			'location' => '800 Howard St., San Francisco, CA 94103',
			'description' => 'A chance to hear more about Google\'s developer products.',
			'start' => array(
				'dateTime' => '2022-02-28T09:00:00-07:00',
				'timeZone' => 'America/Los_Angeles',
			),
			'end' => array(
				'dateTime' => '2022-02-28T17:00:00-07:00',
				'timeZone' => 'America/Los_Angeles',
			),
			'recurrence' => array(
				'RRULE:FREQ=DAILY;COUNT=2'
			),
			'attendees' => array(
				array('email' => 'lpage@example.com'),
				array('email' => 'sbrin@example.com'),
			),
			'reminders' => array(
				'useDefault' => FALSE,
				'overrides' => array(
					array('method' => 'email', 'minutes' => 24 * 60),
					array('method' => 'popup', 'minutes' => 10),
				),
			),
		));

//		echo '<pre>';
//		print_r( $data );
//		echo '</pre>';
//
//		echo '<pre>';
//		print_r( $client );
//		echo '</pre>';
//
//		wp_die( 'test' );

		return $service->events->insert( $this->calendarId, $event );
	}

	public function updateEvent( $data ) {
		$client  = $this->getClient();
		$service = new Google_Service_Calendar( $client );

		$event = $service->events->get( $this->calendarId, $data['calendar_event_id'] );
		$event->setSummary( $this->getSummary( $data ) );
		$event->setDescription( $this->getDescription( $data ) );

		$Start = new Google_Service_Calendar_EventDateTime();
		$Start->setDateTime( $this->getStartTime( $data ) );
		$Start->setTimeZone( $this->timeZone );
		$event->setStart( $Start );

		$end = new Google_Service_Calendar_EventDateTime();
		$end->setDateTime( $this->getEndTime( $data ) );
		$end->setTimeZone( $this->timeZone );
		$event->setEnd( $end );

		$service->events->update( $this->calendarId, $event->getId(), $event );
	}


	public function editEvent( $data ) {
		$client  = $this->getClient();
		$service = new Google_Service_Calendar( $client );

		$event = $service->events->get( 'primary', $data['calendar_event_id'] );
		$event->setSummary( $this->getSummary( $data ) );
		$event->setDescription( $this->getDescription( $data ) );

		$Start = new Google_Service_Calendar_EventDateTime();
		$Start->setDateTime( $this->getStartTime( $data ) );
		$Start->setTimeZone( $this->timeZone );
		$event->setStart( $Start );

		$end = new Google_Service_Calendar_EventDateTime();
		$end->setDateTime( $this->getEndTime( $data ) );
		$end->setTimeZone( $this->timeZone );
		$event->setEnd( $end );

		$calendarId = 'primary';

		if ( empty( $data['calendar_event_id'] ) ) {
			$event = $service->events->insert( $calendarId, $event );
		} else {
			$service->events->update( $calendarId, $event->getId(), $event );
		}

		return $event->id;
	}

	public function deleteEvent( $eventId ) {
		$client     = $this->getClient();
		$calendarId = 'primary';
		$service    = new Google_Service_Calendar( $client );
		$service->events->delete( $calendarId, $eventId );
	}

	private function getStartTime( $data ) {
		return $data['game_date'] . 'T' . $data['game_time'] . ':00+01:00';
	}

	private function getEndTime( $data ) {
		$hours   = stristr( $data['game_time'], ':', true ) + 2;
		$minutes = stristr( $data['game_time'], ':' );

		return $data['game_date'] . 'T' . $hours . $minutes . ':00+01:00';
	}

	private function getSummary( $data ) {
		if ( empty( $data['game_home_team_score'] ) or empty( $data['game_guest_team_score'] ) ) {
			$summary = "$data[taxonomy_game_home_team] - $data[taxonomy_game_guest_team]";
		} else {
			$summary = "$data[taxonomy_game_home_team] ($data[game_home_team_score]) -  $data[taxonomy_game_guest_team] ($data[game_guest_team_score])";
		}

		return $summary;
	}

	private function getDescription( $data ) {
		$arena            = $data['tax_input']['arenas'];
		$statistics_link  = $data['game_statistics_link'];
		$tv_channel       = $data['tax_input']['tv_channels'];
		$eventDescription = '';

		if ( ! empty( $arena ) ) {
			$eventDescription .= "<strong>Arena:</strong> $arena<br>";
		}
		if ( ! empty( $statistics_link ) ) {
			$eventDescription .= "<strong>Statistics Link:</strong> <a href='$statistics_link'>basketligaen.dk</a><br>";
		}
		if ( ! empty( $data['game_tv_link'] ) ) {
			$eventDescription .= "<strong>TV:</strong> <a href='$data[game_tv_link]'>$tv_channel</a><br>";
		}

		return $eventDescription;
	}
}