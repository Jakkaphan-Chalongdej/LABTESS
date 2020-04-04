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

?>
