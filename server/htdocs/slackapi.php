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

require __dir__."/../SlackController.php";
$slackController = new SlackController();
$slackController->run($input);