<?php

declare(strict_types=1);

// FRONT CONTROLLER

//  General settings
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();

define('ROOT', dirname(__FILE__));

// Load Composer's autoloader
require_once ROOT . '/vendor/autoload.php';

// Router call with fully qualified namespace
$router = new \App\Core\Router();
$router->run();
