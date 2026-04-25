<?php

namespace Ocore;

class Request
{
    public const string METHOD_POST = 'POST';
    public const string METHOD_GET = 'GET';

    public string $uri;

    public function __construct(string $uri)
    {
        $this->uri = trim(urldecode($uri), '/');
    }

    public function getPath(): string
    {
        return $this->removeQueryString();
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    private function removeQueryString(): string
    {
        if ($this->uri) {
            $params = explode('&', $this->uri);
            if (false === str_contains($params[0], '=')) {
                return trim($params[0], '/');
            }
        }
        return '';
    }

    public function isGet():bool
    {
        return self::METHOD_GET == $this->getMethod();
    }

    public function isPost():bool
    {
        return self::METHOD_POST == $this->getMethod();
    }

    public function get($name, $default = null): null|string
    {
        return $_GET[$name] ?? $default;
    }

    public function post($name = null, $default = null): null|array|string
    {
        if (is_null($name)) {
            return $_POST;
        }
        return $_POST[$name] ?? $default;
    }

    public function getData(): array
    {
        $data = [];

        $request_data = $this->isGet() ? $_GET : $_POST;
        foreach ($request_data as $k => $v) {
            $data[$k] = trim($v);
        }

        return $data;
    }
}