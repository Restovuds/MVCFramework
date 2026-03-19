<?php

/** @var \Ocore\Application $app */

$app->router->get('/', function () {
    return view('main');
});
$app->router->get('/about', function () {
    return view('about');
});
$app->router->get('/contact', [App\Controllers\ContactController::class, 'index']);
$app->router->post('/contact', [App\Controllers\ContactController::class, 'send']);