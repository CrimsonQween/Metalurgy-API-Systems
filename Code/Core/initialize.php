<?php

// Define directory separator based on the server OS
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

// Dynamically define the SITE_ROOT to the root of your project
defined("SITE_ROOT") ? null : define("SITE_ROOT", __DIR__ . DS . "..");

// Define paths for core and includes directories
defined("CORE_PATH") ? null : define("CORE_PATH", SITE_ROOT . DS . "core");
defined("INC_PATH") ? null : define("INC_PATH", SITE_ROOT . DS . "includes");

// Load the config file for DB connection
require_once(CORE_PATH . DS . "config.php");

// Load other necessary classes
require_once(INC_PATH . DS . "users.php");
require_once(INC_PATH . DS . "bands.php");
?>
