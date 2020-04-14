<?php

error_log("BRN Slack API");

$data = json_decode(file_get_contents('php://input'), true);

function debug($msg) {
	$bt = debug_backtrace();
	$caller = array_shift($bt);

	$file = explode('/', $caller['file']);
	$file = end($file);
	$line = $caller['line'];
	error_log("$file:$line-- ".print_r($msg, true));
}

if (isset($data["challenge"])) {
	header("Content-Type: text/plain");
	header('X-PHP-Response-Code: 200', true, 200);
	file_put_contents('php://output', $data["challenge"]);
	return;
}

$input = array_merge($data ?: [], $_GET ?: []);
if (empty($input) || !$input){
	return;
}

$input = ['payload' => '{"type":"block_actions","user":{"id":"U011QRSS6NM","username":"briandle89","name":"briandle89","team_id":"T011QRSS6E5"},"api_app_id":"A011FNUEY10","token":"MkLM99j5BsHuhYCdyKApK5aQ","container":{"type":"message","message_ts":"1586839078.000200","channel_id":"C011QRSSHBK","is_ephemeral":false},"trigger_id":"1059682809253.1058876890481.a2f370be7443c497605d3163c7da321a","team":{"id":"T011QRSS6E5","domain":"samus-workspace"},"channel":{"id":"C011QRSSHBK","name":"general"},"message":{"bot_id":"B011Q4W9Q7M","type":"message","text":"Check out the kit yooo","user":"U011QRSS6NM","ts":"1586839078.000200","team":"T011QRSS6E5","blocks":[{"type":"section","block_id":"4LvHY","text":{"type":"mrkdwn","text":"This is a section block","verbatim":false},"accessory":{"type":"button","action_id":"button","text":{"type":"plain_text","text":"Click Me","emoji":true},"value":"click_me_123"}},{"type":"actions","block_id":"actionblock789","elements":[{"type":"button","action_id":"oHs","text":{"type":"plain_text","text":"Primary Button","emoji":true},"style":"primary","value":"click_me_456"},{"type":"button","action_id":"jIk","text":{"type":"plain_text","text":"Link Button","emoji":true},"url":"https:\/\/api.slack.com\/block-kit"}]}]},"response_url":"https:\/\/hooks.slack.com\/actions\/T011QRSS6E5\/1059682809173\/RwswrNGGhXe7toCMfc6szypC","actions":[{"action_id":"button","block_id":"4LvHY","text":{"type":"plain_text","text":"Click Me","emoji":true},"value":"click_me_123","type":"button","action_ts":"1586839121.455937"}]}'];

require __dir__."/../SlackController.php";
$slackController = new SlackController();
$slackController->run($input);