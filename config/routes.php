<?php

/** @var \Ocore\Application $app */

$app->router->get('/', [\App\Controllers\SiteController::class, 'index']);

$app->router->get('/about', function () {
    return view('about/index', ['title' => 'About Page']);
});

// contact
$app->router->get('/contact', [App\Controllers\ContactController::class, 'index']);
$app->router->post('/contact', [App\Controllers\ContactController::class, 'send']);

// posts
$app->router->get('/posts/create', [App\Controllers\PostController::class, 'create']);
$app->router->post('/posts/store', [App\Controllers\PostController::class, 'store']);
$app->router->get('/posts/edit', [App\Controllers\PostController::class, 'edit']);
$app->router->post('/posts/update', [App\Controllers\PostController::class, 'update']);
$app->router->get('/posts/delete', [App\Controllers\PostController::class, 'delete']);
$app->router->get('/posts/(?P<slug>[a-z0-9-]+)', [App\Controllers\PostController::class, 'view']);

// user
$app->router->add('/register', [\App\Controllers\UserController::class, 'register'], ['get', 'post']);
$app->router->add('/login', [\App\Controllers\UserController::class, 'login'], ['get', 'post']);
$app->router->get('/logout', [\App\Controllers\UserController::class, 'logout']);
