<?php
require_once '../app/model/Game.php';

class GameController {
    private $db;
    private $game;

    public function __construct($db) {
        $this->db = $db;
        $this->game = new Game($db);
    }

    public function index() {
        $games = $this->game->getAll();
        require '../app/view/games/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $defaultMode = $_POST['defaultMode'] ?? 'PVP';
            if ($this->game->create($name, $description, $defaultMode)) {
                header('Location: /games');
                exit;
            }
        }
        require '../app/view/games/create.php';
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $id = $_POST['id'] ?? 0;
            if ($this->game->delete($id)) {
                header('Location: /games');
                exit;
            } else {
                echo "Error deleting game.";
            }
        }
    }
}
