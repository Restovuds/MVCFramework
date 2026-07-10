<?php

namespace Ocore;

use Ocore\security\Security;

class Application
{
    public string $uri;
    public Request $request;
    public Response $response;
    public Router $router;
    public View $view;
    public Database $db;
    public Session $session;
    public Security $security;
    public Cache $cache;

    private array $container = [];

    public function __construct()
    {
        self::$app = $this;
        $this->uri = $_SERVER['QUERY_STRING'];
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View(DEFAULT_LAYOUT);
        $this->db = new Database();
        $this->session = new Session();
        $this->security = new Security();
        $this->cache = new Cache();
    }
    public static Application $app;

    public function run()
    {
        echo $this->router->dispatch();
    }

    public function containerGet(string $key, mixed $default = null): mixed
    {
        return $this->container[$key] ?? $default;
    }

    public function containerSet(string $key, mixed $value): void
    {
        $this->container[$key] = $value;
    }
}