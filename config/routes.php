<?php

/** @var \Ocore\Application $app */

$app->router->get('/', function () {
    return view('main', ['title' => 'Home Page']);
});
$app->router->get('/about', function () {
    return view('about', ['title' => 'About Page']);
});
$app->router->get('/contact', [App\Controllers\ContactController::class, 'index']);
$app->router->post('/contact', [App\Controllers\ContactController::class, 'send']);