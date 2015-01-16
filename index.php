<?php

//Define some initial settings and start the application
define("_APPDIR", __DIR__ . "/");
define("_SFDIR", _APPDIR . "sfbin/");
define("_BASEURL", $_SERVER['HTTP_HOST']);
require_once _SFDIR . "bootstrap/start.php";

?>