<?php

/** @var \Ocore\Application $app */

$app->router->get('/', [\App\Controllers\SiteController::class, 'index']);
$app->router->get('/about', function () {
    return view('about/index', ['title' => 'About Page']);
});
$app->router->get('/contact', [App\Controllers\ContactController::class, 'index']);
$app->router->post('/contact', [App\Controllers\ContactController::class, 'send']);