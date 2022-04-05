<?php
/**
 * @package GCal_Poster
 * @version 1.0.0
 */
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
	throw new Exception('This application must be run on the command line.');
}

class Gcal {

	/**
	 * Returns an authorized API client.
	 * @return Google_Client the authorized client object
	 * @throws \Google\Exception
	 */
	public function getClient(): Google_Client {
		$client = new Google_Client();
		$client->setApplicationName('Google Calendar API PHP Quickstart');
		$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
		$client->setAuthConfig('credentials.json');
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');

		// Load previously authorized token from a file, if it exists.
		// The file token.json stores the user's access and refresh tokens, and is
		// created automatically when the authorization flow completes for the first
		// time.
		$tokenPath = 'token.json';
		if (file_exists($tokenPath)) {
			$accessToken = json_decode(file_get_contents($tokenPath), true);
			$client->setAccessToken($accessToken);
		}

		// If there is no previous token or it's expired.
		if ($client->isAccessTokenExpired()) {
			// Refresh the token if possible, else fetch a new one.
			if ($client->getRefreshToken()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			} else {
				// Request authorization from the user.
				$authUrl = $client->createAuthUrl();
				printf("Open the following link in your browser:\n%s\n", $authUrl);
				print 'Enter verification code: ';
				$authCode = trim(fgets(STDIN));

				// Exchange authorization code for an access token.
				$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
				$client->setAccessToken($accessToken);

				// Check to see if there was an error.
				if (array_key_exists('error', $accessToken)) {
					throw new Exception(join(', ', $accessToken));
				}
			}
			// Save the token to a file.
			if (!file_exists(dirname($tokenPath))) {
				mkdir(dirname($tokenPath), 0700, true);
			}
			file_put_contents($tokenPath, json_encode($client->getAccessToken()));
		}
		return $client;
	}

	/**
	 * @throws \Google\Exception
	 */
	public function getLatestPosts($quantity = 10) {

		// Get the API client and construct the service object.
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);

		// Print the next 10 events on the user's calendar.
		$calendarId = 'primary';
		$optParams = array(
			'maxResults' => $quantity,
			'orderBy' => 'startTime',
			'singleEvents' => true,
			'timeMin' => date('c'),
		);
		$results = $service->events->listEvents($calendarId, $optParams);
		$events = $results->getItems();

		if (empty($events)) {
			print "No upcoming events found.\n";
		} else {
			print "Upcoming events:\n";
			foreach ($events as $event) {
				$start = $event->start->dateTime;
				if (empty($start)) {
					$start = $event->start->date;
				}
				printf("%s (%s)\n", $event->getSummary(), $start);
			}
		}
	}

	public function createEvent() {
		$client = $this->getClient();
		$service = new Google_Service_Calendar($client);

		$event = new Google_Service_Calendar_Event(array(
			'summary' => 'Test event creation',
			'location' => 'Большая Диевская 24Б, Днепр, Украина',
			'description' => 'Тестирование создания события через консольное приложение',
			'start' => array(
				'dateTime' => '2022-03-18T09:00:00-07:00',
				'timeZone' => 'Europe/Kiev',
			),
			'end' => array(
				'dateTime' => '2022-03-18T17:00:00-07:00',
				'timeZone' => 'Europe/Kiev',
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

		$calendarId = 'primary';
		$event = $service->events->insert($calendarId, $event);
		printf('Event created: %s\n', $event->htmlLink);
	}
}


$calendar = new Gcal();
$calendar->getLatestPosts();
$calendar->createEvent();