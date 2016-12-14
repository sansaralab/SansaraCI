<?php

require_once "../vendor/autoload.php";

$core = new Core\Core();
$core->registerRoutes();
$core->run();
