<?php

use helpers\ErrorHelper;

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

function response(): \Ocore\Response
{
    return app()->response;
}

function specChars($string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function old($fieldName): string|null
{
    return isset($_POST[$fieldName]) ? specChars($_POST[$fieldName]) : null;
}

function getError($fieldName, $errors = []): string|null
{
    if (isset($errors[$fieldName])) {
        return '<div class="invalid-feedback d-block">' . $errors[$fieldName] . '</div>';
    }
    return null;
}

function getBootstrapValidationClass($fieldName, $errors = [], $shouldReturnValidClass = true): string|null
{
    $validClass = $shouldReturnValidClass ? 'is-valid' : null;
    $invalidClass = 'is-invalid';

    if (empty($errors)) {
        return null;
    }

    return isset($errors[$fieldName]) ? $invalidClass : $validClass;
}

function mergeClasses($classes = []): string
{
    return implode(' ', $classes);
}

function abort(int $code = 404, string|null $error = null, string|null $message = null): \Ocore\View
{
    if (is_null($error)) {
        $error = ErrorHelper::errors[$code]['error'];
    }
    if (is_null($message)) {
        $message = ErrorHelper::errors[$code]['description'];
    }

    response()->setStatusCode($code);
    echo view('errors/error', [
        'code' => $code, 'title' => $error, 'message' => $message
    ], 'errorLayout');
    die;
}