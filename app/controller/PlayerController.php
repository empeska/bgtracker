<?php
require_once '../app/model/PlayerRepo.php';

class PlayerController {
    private $playerRepo;

    public function __construct($db) {
       $this->playerRepo = new PlayerRepo($db);
    }

    public function index() {
        $players = $this->playerRepo->getAll();
        require '../app/view/player/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $nickname = $_POST['nickname'] ?? '';
            if ($this->playerRepo->create($firstName, $lastName, $nickname)) {
                header('Location: /player');
                exit;
            }
        }
        require '../app/view/player/create.php';
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $id = $_POST['id'] ?? 0;
            if ($this->playerRepo->delete($id)) {
                header('Location: /player');
                exit;
            } else {
                echo "Error deleting player.";
            }
        }
    }
}
