<?php

function app(): \Ocore\Application
{
    return \Ocore\Application::$app;
}

function view(string $view = '', array $data = [], $layout = null): string|\Ocore\View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }
    return app()->view;
}

function base_url($url = '/'): string
{
    if (str_starts_with($url, '/')) {
        return SITE_PATH . $url;
    }
    return SITE_PATH . DIRECTORY_SEPARATOR . $url;
}

function request(): \Ocore\Request
{
    return app()->request;
}