<?php

use Core\Router;

spl_autoload_register(function (string $className) {
  $className = str_replace('\\', '/', $className);
  require "src/$className.php";
});


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// FOR THIS CASE ONLY
$path = str_replace('/phpmvc', '', $path);

$router = new Router;
// we add the patterns to the router
$router->add('/', ['controller' => 'home', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/products/view', ['controller' => 'products', 'action' => 'view']);
$router->add('/{controller}/{action}');
$router->add('/{controller}/{id:\d+}/{action}');


$params = $router->match($path);
echo '<pre>';
echo 'params: ';
print_r($params);
echo '</pre>';
if ($params === false) {
  http_response_code(404);
  echo '404 - Page not found';
  exit;
}
$controller = "App\Controllers\\" . ucwords($params['controller']);
$action = $params['action'];


$controller_obj = new $controller;
$controller_obj->$action();
