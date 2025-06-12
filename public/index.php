<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$db = require '../config/database.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_filter(explode('/', trim($uri, '/')));

$controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : null;

$method = !empty($segments[1]) ? $segments[1] : 'index';

$controllerMap = [
    'PlayerController' => __DIR__ . '/../app/controller/PlayerController.php',
    'GameController' => __DIR__ . '/../app/controller/GameController.php',
    'MatchController' => __DIR__ . '/../app/controller/MatchController.php',
];

// Check if the controller name is valid and exists in the map

if ($controllerName && isset($controllerMap[$controllerName])) {
   // Load the controller file
   require_once $controllerMap[$controllerName];
   if (class_exists($controllerName)) {
      $controller = new $controllerName($db);
      // Check if the method exists in the controller
      if (method_exists($controller, $method)) {
         $controller->$method();
      } else {
         http_response_code(404);
         echo "Method Not Found";
      }
   } else {
      http_response_code(404);
      echo "Controller Not Found";
   }
} else {
   require __DIR__ . '/../app/view/home/index.php';
}
