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

    public function get($path, $callback): self
    {
        return $this->add($path, $callback, 'GET');
    }

    public function post($path, $callback): self
    {
        return $this->add($path, $callback, 'POST');
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $handler = $this->matchRoute($method, $path);

        if (false === $handler || false === $handler['callback']) {
            abort();
        }

        if (is_array($handler['callback'])) {
            $handler['callback'][0] = new $handler['callback'][0];
        }

        return call_user_func($handler['callback']);
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

                if (!($route['callback'] instanceof \Closure)) {
                    $route['callback'][1] = 'action' . ucfirst($route['callback'][1]);
                }
                return $route;
            }
        }
        return false;
    }

    public function add($path, $callback, string|array $method): self
    {
        if (empty($method)) {
            throw new \Exception('Method is required. Router configuration error occurred');
        }
        if (is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
        }

        $path = trim($path, '/');

        foreach ($method as $item_method) {
            $this->routes[$item_method]["/$path"] = [
                'callback' => $callback,
                'middleware' => null,
            ];
        }

        return $this;
    }
}
