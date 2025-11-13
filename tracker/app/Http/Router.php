<?php
namespace App\Http;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable $handler): void
    {
        $this->routes['GET'][$uri] = $handler;
    }

    public function post(string $uri, callable $handler): void
    {
        $this->routes['POST'][$uri] = $handler;
    }

    public function dispatch(string $method, string $uri)
    {
        $uri = '/' . trim(parse_url($uri, PHP_URL_PATH), '/');
        if ($uri === '//') {
            $uri = '/';
        }
        $routes = $this->routes[$method] ?? [];
        if (isset($routes[$uri])) {
            return call_user_func($routes[$uri]);
        }
        header('Content-Type: application/json', true, 404);
        echo json_encode(['message' => 'Not Found', 'uri' => $uri]);
        return null;
    }
}
