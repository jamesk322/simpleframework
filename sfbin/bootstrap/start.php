<?php

//Bootstrap application startup
//Load config files
require_once _SFDIR . "bootstrap/loadconfig.php";

//Load classes
require_once _SFDIR . "bootstrap/classautoloader.php";

App::run();

?>