<?php

namespace Core;

class Router
{
  private $routes = [];

  public function add(string $path, array $params = []): void
  {
    $this->routes[] = [
      'path' => $path,
      'params' => $params
    ];
  }

  public function match(string $path): array|bool
  {
    $path = trim($path, '/');

    foreach ($this->routes as $route) {
      $pattern = $this->getPatternFromRoutePath($route['path']);
      if (preg_match($pattern, $path, $matches)) {
        $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        $params = array_merge($route['params'], $matches);

        return $params;
      }
    }

    return false;
  }

  private function getPatternFromRoutePath(string $route_path): string
  {
    $route_path = trim($route_path, '/');
    $segments = explode('/', $route_path);
    $segments = array_map(function (string $segment): string|array {
      if (preg_match('#^\{([a-z][a-z0-9]*)\}#', $segment, $matches)) {
        return '(?<' . $matches[1] . '>[^/]*)';
      }
      if (preg_match('#^\{([a-z][a-z0-9]*):(.+)\}#', $segment, $matches)) {
        return '(?<' . $matches[1] . '>' . $matches[2] . ')';
      }
      return $segment;
    }, $segments);

    $pattern = '#^' . implode('/', $segments) . '$#i';
    return $pattern;
  }
}
