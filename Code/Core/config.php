<?php

//Database Details
$db_name = "metalurgy-api-systems";
$db_username = "root";
$db_password ="";

$db = new PDO("mysql:host=localhost;dbname=".$db_name.";charset=utf8;", $db_username, $db_password);

//Set down some Database Attributes
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>