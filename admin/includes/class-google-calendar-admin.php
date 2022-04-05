<?php

class GoogleCalendarAdmin {
	public $timeZone = 'Europe/Copenhagen';
	public $calendarId;

	public function __construct() {
		$this->timeZone   = esc_attr( get_option( 'btm_google_calendar_time_zone' ) );
		$this->calendarId = esc_attr( get_option( 'btm_google_calendar_id' ) );
	}

	public function getClient(): Google_Client {
		$client = new Google_Client();
		$client->setApplicationName( 'Google Calendar API PHP Quickstart' );
		$client->setScopes( Google_Service_Calendar::CALENDAR_EVENTS );
		$client->setAuthConfig( plugin_dir_path( dirname( __FILE__ ) ) . '../credentials.json' );
		$client->setAccessType( 'offline' );
		$client->setPrompt( 'select_account consent' );

		// Load previously authorized token from a file, if it exists.
		// The file token.json stores the user's access and refresh tokens, and is
		// created automatically when the authorization flow completes for the first
		// time.
		$tokenPath = plugin_dir_path( dirname( __FILE__ ) ) . '../token.json';
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

	public function createEvent( $postData ) {
		$client     = $this->getClient();
		$service    = new Google_Service_Calendar( $client );
		$eventData = array(
			'summary'     => $this->getSummary( $postData ),
			'description' => $this->getDescription( $postData ),
			'start'       => array(
				'dateTime' => $this->getStartTime( $postData ),
				'timeZone' => $this->timeZone,
			),
			'end'         => array(
				'dateTime' => $this->getEndTime( $postData ),
				'timeZone' => $this->timeZone,
			),
		);

		$serviceEvent = new Google_Service_Calendar_Event( $eventData );
		$event = $service->events->insert($this->calendarId, $serviceEvent);

		try {
			$event = $service->events->insert($this->calendarId, $serviceEvent);
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
		}

		return $event;
	}

	public function updateEvent($postData) {
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);

		$event = $service->events->get($this->calendarId, $postData['game_calendar_event_id']);
		$event->setSummary($this->getSummary($postData));
		$event->setDescription($this->getDescription($postData));

		$Start = new Google_Service_Calendar_EventDateTime();
		$Start->setDateTime($this->getStartTime($postData));
		$Start->setTimeZone($this->timeZone);
		$event->setStart($Start);

		$end = new Google_Service_Calendar_EventDateTime();
		$end->setDateTime($this->getEndTime($postData));
		$end->setTimeZone($this->timeZone);
		$event->setEnd($end);

		$service->events->update($this->calendarId, $event->getId(), $event);

		return $event;
	}

//	public function deleteEvent($postData)
//	{
//		wp_die('delete');
//		$client = $this->getClient();
//		$service = new Google_Service_Calendar($client);
//		$service->events->delete($this->calendarId, $postData['game_calendar_event_id']);
//	}

	private function getStartTime( $data ) {
		return $data['game_date'] . 'T' . $data['game_time'] . ':00+01:00';
	}

	private function getEndTime( $data ) {
		$hours   = stristr( $data['game_time'], ':', true ) + 2;
		$minutes = stristr( $data['game_time'], ':' );

		return $data['game_date'] . 'T' . $hours . $minutes . ':00+01:00';
	}

	private function getSummary( $data ) {
		$homeTeam = get_term( $data['taxonomy_game_home_team'], 'teams' );
		$guestTeam = get_term( $data['taxonomy_game_guest_team'], 'teams' );
		if ( empty( $data['game_home_team_score'] ) or empty( $data['game_guest_team_score'] ) ) {
			$summary = "$homeTeam->name - $guestTeam->name";
		} else {
			$summary = "$homeTeam->name ($data[game_home_team_score]) - $guestTeam->name ($data[game_guest_team_score])";
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