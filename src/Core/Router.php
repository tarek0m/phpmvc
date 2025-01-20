<?php

namespace Core;

class Router
{
  private $routes = [];

  public function add(string $path, array $params): void
  {
    $this->routes[] = [
      'path' => $path,
      'params' => $params
    ];
  }

  public function match(string $path): array|bool
  {
    foreach ($this->routes as $route) {
      if ($route['path'] === $path) {
        return $route['params'];
      }
    }
    return false;
  }
}
