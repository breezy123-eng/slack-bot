<?php

require __dir__.'/../vendor/autoload.php';
require __dir__.'/../vendor/threadmeup/slack-sdk/src/Client.php';

use CoryKeane\Slack\Client;

class SlackController {
	function __construct() {
		echo "Inside of slack controller\n";
		$config = [
		    'token' => 'xoxb-1058876890481-1051231960758-qIla9jC7Eg2NF0P1eeEJ7wJJ',
		    // 'team' => 'YOUR-TEAM',
		    'username' => 'grittool',
		    'icon' => 'ICON', // Auto detects if it's an icon_url or icon_emoji
		    'parse' => '', // __construct function in Client.php calls for the parse parameter 
		];

		$this->slack = new Client($config);
		$this->chat = $this->slack->chat('#general');
	}

	public function sendChatMsg($msg) {
		$this->chat->send($msg);
	}
}
