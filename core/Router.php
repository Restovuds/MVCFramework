<?php

namespace Ocore;

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];

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
        $handler = $this->routes[$method]["/$path"] ?? function () {
            $this->response->setStatusCode(404);
            return view('errors/error', [
                'code' => 404, 'title' => 'Page not found', 'message' => 'Sorry, the page you are looking for does not exist.'
            ]);
        };
        if (is_array($handler)) {
            $handler[0] = new $handler[0];
        }

        return call_user_func($handler);
    }
}