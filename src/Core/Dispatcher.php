<?php

namespace Core;

use ReflectionClass;
use ReflectionMethod;

class Dispatcher
{
  public function __construct(private Router $route) {}

  public function handle(string $path): void
  {
    $params = $this->route->match($path);

    if ($params === false) {
      http_response_code(404);
      exit('404 - Page not found');
    }
    $controller = $this->getControllerName($params);
    $action = $this->getActionName($params);

    $actionParameters = $this->getActionParameters($controller, $action, $params);

    $controller_obj = $this->getObject($controller);
    $controller_obj->$action(...$actionParameters);
  }

  private function getObject(string $class_name): object
  {
    $dependencies = [];
    $reflection = new ReflectionClass($class_name);

    $constructor = $reflection->getConstructor();

    if ($constructor === null) {
      return new $class_name;
    }
    $parameters = $constructor->getParameters();

    foreach ($parameters as $parameter) {
      $type = (string) $parameter->getType();
      $dependencies[] = $this->getObject($type);
    }
    return new $class_name(...$dependencies);
  }

  private function getActionParameters(string $controller, string $action, array $params): array
  {
    $args = [];
    $reflection = new ReflectionMethod($controller, $action);
    $parameters = $reflection->getParameters();
    foreach ($parameters as $parameter) {
      $args[$parameter->getName()] = $params[$parameter->getName()];
    }
    return $args;
  }

  private function getControllerName(array $params): string
  {
    $controller = str_replace('-', '', ucwords($params['controller'], '-'));
    $namespace = "App\Controllers";
    if (array_key_exists('namespace', $params)) {
      $namespace .= '\\' . $params['namespace'];
    }
    return $namespace . '\\' . $controller;
  }

  private function getActionName(array $params): string
  {
    $action = str_replace('-', '', ucwords($params['action'], '-'));
    return $action;
  }
}
