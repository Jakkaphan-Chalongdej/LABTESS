<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Welcome Heroku test Dialogflow and Abdul</h1>
</body>
</html>


<?php
http_response_code(200);

$datas = file_get_contents('php://input');
    
$deCode = json_decode($datas,true);

// write log RAW json 
file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

$replyToken = $deCode['events'][0]['replyToken'];
$botText = $deCode['events'][0]['message']['text'];
$type = $deCode['events'][0]['message']['type'];
$uid = $deCode['events'][0]['source']['userId'];


if ($type == 'text') {

    $url = "https://dialogflow.cloud.google.com/v1/integrations/line/webhook/f53b38db-d98d-41d6-914c-86726c8e3485";
    $headers = getallheaders();
    $headers['Host'] = "bots.dialogflow.com";
    $json_headers = array();

    foreach ($headers as $k => $v) {
        $json_headers[] = $k . ":" . $v;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $json_headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
} else {

    // proxy do
}



?>
