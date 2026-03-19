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