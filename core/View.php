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

    public function render(string $view, array $data = [], $layout = null): string|View
    {
        extract($data);
        $viewFile = self::getPath(fileName: $view, const: VIEWS);
        if (is_file($viewFile)) {
            ob_start();
            require $viewFile;
            $this->content = ob_get_clean();
        } else {
            abort(code: 500, message: "View $view not found");
        }

        if (false === $layout) {
            return $this->content;
        }

        $layoutFileName = $layout ?: $this->layout;
        $layoutFile = self::getPath(fileName: $layoutFileName, const: LAYOUTS);

        if (is_file($layoutFile)) {
            ob_start();
            require_once $layoutFile;
            return ob_get_clean();
        } else {
            abort(code: 500, message: "Layout $layoutFileName not found");
        }
    }

    public function renderPartial(string $view, array $data = []): string
    {
        extract($data);
        $viewFile = self::getPath(fileName: $view, const: VIEWS);
        if (is_file($viewFile)) {
            require $viewFile;
        }
        return ""; // it is not necessary to return anything in that case
    }

    // --------------
    // static methods
    // --------------
    protected static function getPath(string $fileName, string $const): string
    {
        $file = str_contains($fileName, '.php') ? $fileName : "{$fileName}.php";
        return $const . DIRECTORY_SEPARATOR . $file;
    }
}