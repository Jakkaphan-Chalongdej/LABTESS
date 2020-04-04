<?php
date_default_timezone_set("Asia/Bangkok");
$date_ = date("d-m-Y");
$time_ = date("H:i:s");
$serverName = "test1.csw86ar6olyd.us-west-2.rds.amazonaws.com";
$userName = "admin";
$userPassword = "admin123456";
$dbName = "testDB";
$connect = mysqli_connect($serverName, $userName, $userPassword, $dbName) or die("connect error" . mysqli_error());
mysqli_set_charset($connect, "utf8");
$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'AJeYHUJbVy6d/VeCU+yJ7ShyCtmMl8yUv1LJPjDGFjIvSTBDgBtYp/0/VX6QJtONwP1CLuWMZCsAIb7ZI4JPPe2FADwvipoxDrpqBqypvBZ47D9vvObZ0C4oXgc8pnIHTpxc/TtDAdy+2swhHhD5wgdB04t89/1O/w1cDnyilFU='; // Access Token จาก Line developer
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer AJeYHUJbVy6d/VeCU+yJ7ShyCtmMl8yUv1LJPjDGFjIvSTBDgBtYp/0/VX6QJtONwP1CLuWMZCsAIb7ZI4JPPe2FADwvipoxDrpqBqypvBZ47D9vvObZ0C4oXgc8pnIHTpxc/TtDAdy+2swhHhD5wgdB04t89/1O/w1cDnyilFU=');
$request = file_get_contents('php://input');
$request_array = json_decode($request, true);
if (sizeof($request_array['events']) > 0) {
    foreach ($request_array['events'] as $event) {
    $reply_message = '';
    $reply_token = $event['replyToken'];
    $user_id = $event['source']['userId'];
    if ($event['type'] == 'message') {
        $opts = [
        "http" => [
                "header" => "Content-Type: application/json" . 'Authorization: Bearer AJeYHUJbVy6d/VeCU+yJ7ShyCtmMl8yUv1LJPjDGFjIvSTBDgBtYp/0/VX6QJtONwP1CLuWMZCsAIb7ZI4JPPe2FADwvipoxDrpqBqypvBZ47D9vvObZ0C4oXgc8pnIHTpxc/TtDAdy+2swhHhD5wgdB04t89/1O/w1cDnyilFU=',
            ],
        ];
    }
    $context = stream_context_create($opts);
    $profile_json = file_get_contents('https://api.line.me/v2/bot/profile/' . $user_id, false, $context);
    $profile_array = json_decode($profile_json, true);
    $pic_ = $profile_array[pictureUrl];
    $name_ = $profile_array[displayName];
    {
        if ($event['message']['type'] == 'text') {
            $text = $event['message']['text'];
            $userid = $event['source']['userId'];
            /* $myfile = fopen("log.txt", "a") or die("Unable to open file!");
            $log = $userid . '-' . $text . '-' . $pic_ . '-' . $name_ . '-' . $date_ . '-' . $time_;
            fwrite($myfile, $log);
            fclose($myfile); */
            $query = "INSERT INTO chatbot_log(user_id,name,pic,text,date_time) VALUE ('$user_id','$name_','$pic_' ,'$text',NOW())";
            $resource = mysqli_query($connect, $query) or die("error" . mysqli_error());
            $url = "https://dialogflow.cloud.google.com/v1/integrations/line/webhook/f53b38db-d98d-41d6-914c-86726c8e3485";
            $headers = getallheaders();
            $headers['Host'] = "bots.dialogflow.com";
            $json_headers = array();
            foreach ($headers as $k => $v) {
                $json_headers[] = $k.":". $v;
            }
            $inputJSON = file_get_contents('php://input');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $inputJSON);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $json_headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            exit;
        } else {
                $text ="user send image location or sticker";
                /* $myfile = fopen(“log_easy.txt”, “a”) or die(“Unable to open file!”);
                $log = $userid . ‘-’ . $text . ‘-’ . $pic_ . ‘-’ . $name_ . ‘-’ . $date_ . ‘-’ . $time_;
                fwrite($myfile, $log);
                fclose($myfile); */
                $query = "INSERT INTO chatbot_log(user_id,name,pic,text,date_time) VALUE ('$user_id','$name_','$pic_' ,'$text',NOW())";
                $resource = mysqli_query($connect, $query) or die("error" . mysqli_error());
                $url = "https://abdul.in.th/callback/9b30aacdf0cd3dbcbdef08c1c948775b.php";
                $headers = getallheaders();
                $headers['Host'] = "abdul.in.th";
                $json_headers = array();
                foreach ($headers as $k => $v) {
                    $json_headers[] = $k . ":" . $v;
                }
                $inputJSON = file_get_contents('php://input');
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $inputJSON);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $json_headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);
                exit;
            }
        }
    }
}
?>
