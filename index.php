<?php

spl_autoload_register(function (string $className) {
  $className = str_replace('\\', '/', $className);
  require "src/$className.php";
});


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// FOR THIS CASE ONLY
$path = str_replace('/phpmvc', '', $path);

$router = new Core\Router;
$router->add('/', ['controller' => 'home', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/products/view', ['controller' => 'products', 'action' => 'view']);


$params = $router->match($path);
if ($params === false) {
  http_response_code(404);
  echo '404 - Page not found';
  exit;
}
$controller = "App\Controllers\\" . ucwords($params['controller']);
$action = $params['action'];


$controller_obj = new $controller;
$controller_obj->$action();
