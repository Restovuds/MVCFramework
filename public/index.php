<?php

use Ocore\Application;

if (PHP_MAJOR_VERSION < 8) {
    die('PHP 8 or higher is required.');
}

require_once __DIR__ . '/../config/init.php';
require_once ROOT . '/vendor/autoload.php';
require_once HELPERS . '/helpers.php';

$app = new \Ocore\Application();
require_once CONFIG . '/routes.php';

$app->run();


