<?php

namespace Ocore;

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];
    public array $rootParams = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function get($path, $callback): void
    {
        $path = trim($path, '/');
        $this->routes['GET']["/$path"] = $callback;
    }

    public function post($path, $callback): void
    {
        $path = trim($path, '/');
        $this->routes['POST']["/$path"] = $callback;
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $handler = $this->matchRoute($method, $path);

        if (false === $handler) {
            abort();
        }
        if (is_array($handler)) {
            $handler[0] = new $handler[0];
        }

        return call_user_func($handler);
    }

    public function getRootParam($name, $default = null): string
    {
        return $this->rootParams[$name] ?? $default;

    }

    protected function matchRoute(string $method, string $path)
    {
        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match( "#^{$pattern}$#", DIRECTORY_SEPARATOR.$path, $matches )) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $this->rootParams[$k] = $v;
                    }
                }

                $route[1] = 'action' . ucfirst($route[1]);
                dump($route);
                return $route;
            }
        }
        return false;
    }
}
