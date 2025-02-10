<?php

use Core\Router;
use Core\Dispatcher;

spl_autoload_register(function (string $className) {
  $className = str_replace('\\', '/', $className);
  require "src/$className.php";
});


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// FOR THIS CASE ONLY
$path = str_replace('/phpmvc', '', $path);

$router = new Router;

$router->add('/admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('/{title}/{id:\d+}/{page:\d+}', ['controller' => 'products', 'action' => 'showPage']);
$router->add('/{controller}/{id:\d+}/{action}');
$router->add('/', ['controller' => 'home', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/products/view', ['controller' => 'products', 'action' => 'view']);
$router->add('/{controller}/{action}');

$dispatcher = new Dispatcher($router);
$dispatcher->handle($path);
