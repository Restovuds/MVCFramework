<?php

namespace Ocore;

class View
{
    public string|bool $layout;
    public string $content = '';

    public function __construct(string $layout)
    {
        $this->layout = $layout;
    }

    public function render(string $view, array $data = [], $layout = null): string
    {
        extract($data);
        $view = str_contains($view, '.php') ? $view : "$view.php";
        $viewFile = VIEWS . DIRECTORY_SEPARATOR . $view;
        if (is_file($viewFile)) {
            ob_start();
            require $viewFile;
            $this->content = ob_get_clean();
        } else {
            app()->response->setStatusCode(500);
            return view('errors/error', [
                'code' => 500, 'title' => 'Internal Server Error', 'message' => 'Sorry, something went wrong.'
            ], 'errorLayout');
        }

        if (false === $layout) {
            return $this->content;
        }

        $layoutFileName = $layout ?: $this->layout;
        $includeExtension = !str_contains($layoutFileName, '.php');
        $layoutFile = LAYOUTS . DIRECTORY_SEPARATOR . (!$includeExtension ? $layoutFileName : "$layoutFileName.php");

        if (is_file($layoutFile)) {
            ob_start();
            require_once $layoutFile;
            return ob_get_clean();
        } else {
            app()->response->setStatusCode(500);
            return view('errors/error', [
                'code' => 500, 'title' => 'Internal Server Error', 'message' => 'Sorry, something went wrong.'
            ], false);
        }
    }
}