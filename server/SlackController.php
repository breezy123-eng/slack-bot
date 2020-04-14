<?php

require __dir__.'/../vendor/autoload.php';
require __dir__.'/../vendor/threadmeup/slack-sdk/src/Client.php';

use CoryKeane\Slack\Client;

class SlackController {
	function __construct() {
		echo "Inside of slack controller\n";
		$config = include(__dir__.'/config/config.php');

		$this->slack = new Client($config);
		$this->chat = $this->slack->chat('#general');
	}

	public function run($input) {
		debug("Input is:".print_r($input, true));

		if (isset($input['post_message'])) {
			$this->sendBlockChatMsg("Check out the kit yooo");
		}
		elseif (isset($input['response_url'])) {
			$this->dispatchEvent($input['response_url']);
		}
		elseif (isset($input['payload'])) {
			$this->handlePayload(json_decode($input['payload']));
		}

		$this->listen();
	}

	public function sendChatMsg($msg, $blocks = null) {
		$this->chat->send($msg, null, $blocks);
	}

	public function sendBlockChatMsg($msg) {
		$blocks = [
		    [
		        'type' => 'section',
		        'text' => [
		            'type' => 'mrkdwn',
		            'text' => 'This is a section block',
		        ],
		        'accessory' => [
		            'type' => 'button',
		            'text' => [
		                'type' => 'plain_text',
		                'text' => 'Click Me',
		            ],
		            'value' => 'click_me_123',
		            'action_id' => 'button',
		        ],
		    ],
		    [
		        'type' => 'actions',
		        'block_id' => 'actionblock789',
		        'elements' => [
		            [
		                'type' => 'button',
		                'text' => [
		                    'type' => 'plain_text',
		                    'text' => 'Primary Button',
		                ],
		                'style' => 'primary',
		                'value' => 'click_me_456',
		            ],
		            [
		                'type' => 'button',
		                'text' => [
		                    'type' => 'plain_text',
		                    'text' => 'Link Button',
		                ],
		                'url' => 'https://api.slack.com/block-kit',
		            ]
		        ],
		    ]
		];

		$this->sendChatMsg($msg, $blocks);
	}

	public function dispatchEvent($event) {

	}

	public function listen() {
		error_log("BRN Listen");
		$incoming = $this->slack->listen();
		if ($incoming)
		{
			error_log("BRN incoming");
		    switch($incoming->text())
		    {
		        case "What time is it?":
		            $incoming->respond("It is currently ".date('g:m A T'));
		        break;
		        default:
		            $incoming->respond("I don't understand what you're asking.");
		        break;
		    }
		}

		error_log("BRN incoming done");
	}

	public function handlePayload($payload) {
		debug($payload);
		$actions = $payload->actions;
		$this->sendChatMsg("hey <@U011QRSS6NM>, ".$actions[0]->value);
	}
}