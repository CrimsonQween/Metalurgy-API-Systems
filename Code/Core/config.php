<?php

//Database Details

$db_name = "metalurgy-api-systems";
$db_username = "root";
$db_password = "";

// Genre Database Keys - LastFm
$lastfm_api_key = '223fe2ea7fdb302d649ebec2a63d4f74'; 
$lastfm_secret_key = '293f24132c0f9fae409638117e42a250';

$db = new PDO("mysql:host=localhost;dbname=$db_name;charset=utf8", $db_username, $db_password);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
