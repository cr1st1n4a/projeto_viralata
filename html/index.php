<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$app = AppFactory::create(); 
require __DIR__ . '/../app/helpers/settings.php';
require __DIR__ . '/../app/routes/routes.php';


$app->run();