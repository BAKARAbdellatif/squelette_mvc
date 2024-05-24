<?php
require_once __DIR__ . "/../app/Controllers/HomeController.php";
require_once __DIR__ . "/../config/config.php";
require __DIR__ . "/../app/core/Helper.php";

if (ENV === "Dev") {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(E_ERROR | E_PARSE);
}
date_default_timezone_set('Africa/Casablanca');
new HomeController();
