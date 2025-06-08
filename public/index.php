<?php
$db = require '../config/database.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/players') {
   require '../app/controller/PlayerController.php';
} else {
   echo "Not Found";
}
