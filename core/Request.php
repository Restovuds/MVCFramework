<?php

namespace Ocore;

class Request
{
    private const string METHOD_POST = 'POST';
    private const string METHOD_GET = 'GET';

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

    public function get($name, $default = null): null|string
    {
        return $_GET[$name] ?? $default;
    }
}