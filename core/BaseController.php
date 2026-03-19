<?php

namespace Ocore;

abstract class BaseController
{
    public function render(string $view, array $data = [], $layout = null): string
    {
        return app()->view->render($view, $data, $layout);
    }
}