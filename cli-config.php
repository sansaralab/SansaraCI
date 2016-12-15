<?php

require_once 'vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with mechanism to retrieve EntityManager in your app
$core = new Core\Core();
$core->bootstrap();
$entityManager = $core->getOrm();

return ConsoleRunner::createHelperSet($entityManager);
