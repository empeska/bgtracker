<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$db = require '../config/database.php';
$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($uri === '') {
    require '../app/view/home/index.php';
} elseif ($uri === '/players') {
    require '../app/controller/PlayerController.php';
    (new PlayerController($db))->index();
} elseif ($uri === '/players/create') {
    require '../app/controller/PlayerController.php';
    (new PlayerController($db))->create();
} elseif ($uri === '/players/delete') {
    require '../app/controller/PlayerController.php';
    (new PlayerController($db))->delete();
} elseif ($uri === '/games') {
    require '../app/controller/GameController.php';
    (new GameController($db))->index();
} elseif ($uri === '/games/create') {
    require '../app/controller/GameController.php';
    (new GameController($db))->create();
} elseif ($uri === '/games/delete') {
    require '../app/controller/GameController.php';
    (new GameController($db))->delete();
} elseif ($uri === '/matches') {
    require '../app/controller/MatchController.php';
    (new MatchController($db))->index();
} elseif ($uri === '/matches/create') {
    require '../app/controller/MatchController.php';
    (new MatchController($db))->create();
} elseif ($uri === '/matches/delete') {
    require '../app/controller/MatchController.php';
    (new MatchController($db))->delete();
} else {
    http_response_code(404);
    echo "Not Found";
}
