<?php
require_once '../app/model/Player.php';

class PlayerController {
    private $db;
    private $player;

    public function __construct($db) {
        $this->db = $db;
        $this->player = new Player($db);
    }

    public function index() {
        $players = $this->player->getAll();
        require '../app/view/players/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $nickname = $_POST['nickname'] ?? '';
            if ($this->player->create($firstName, $lastName, $nickname)) {
                header('Location: /players');
                exit;
            }
        }
        require '../app/view/players/create.php';
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $id = $_POST['id'] ?? 0;
            if ($this->player->delete($id)) {
                header('Location: /players');
                exit;
            } else {
                echo "Error deleting player.";
            }
        }
    }
}
