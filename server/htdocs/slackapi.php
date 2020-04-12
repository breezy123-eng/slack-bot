<?php

error_log("BRN Slack API");

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data["challenge"])) {
    error_log(print_r($data, true)); 
}

else {

    header("Content-Type: text/plain");
    header('X-PHP-Response-Code: 200', true, 200);
    echo $data["challenge"];
}

?>
