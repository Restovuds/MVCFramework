<?php

namespace Ocore;

class View
{
    public string $layout;
    public string $content = '';

    public function __construct(string $layout)
    {
        $this->layout = $layout;
    }

    public function render(string $view, array $data = [], $layout = null): string
    {
        extract($data);
        $view = str_contains($view, '.php') ? $view : "{$view}.php";
        $viewFile = VIEWS . DIRECTORY_SEPARATOR . $view;
        if (is_file($viewFile)) {
            ob_start();
            require $viewFile;
            return ob_get_clean();
        } else {
            app()->response->setStatusCode(500);
            return view('errors/error', [
                'code' => 500, 'title' => 'Internal Server Error', 'message' => 'Sorry, something went wrong.'
            ]);
        }
    }
}