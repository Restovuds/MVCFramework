<?php

namespace Ocore;

class Application
{
    public string $uri;
    public Request $request;
    public Response $response;
    public Router $router;
    public View $view;
    public Database $db;
    public Session $session;
    public static Application $app;

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
    }

    public function run()
    {
        echo $this->router->dispatch();
    }
}