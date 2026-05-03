<?php

use Ocore\Application;

$startTime = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('PHP 8 or higher is required.');
}

require_once __DIR__ . '/../config/init.php';
require_once ROOT . '/vendor/autoload.php';
require_once HELPERS . '/helpers.php';

$app = new Application();
require_once CONFIG . '/routes.php';

$app->run();

if (DEBUG) {
    dump("Time: " . (microtime(true) - $startTime) . "s");
}
