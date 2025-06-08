<?php
require_once '../app/model/GameMatch.php';
require_once '../app/model/Game.php';
require_once '../app/model/Player.php';

class MatchController {
    private $db;
    private $match;
    private $game;
    private $player;

    public function __construct($db) {
        $this->db = $db;
        $this->match = new GameMatch($db);
        $this->game = new Game($db);
        $this->player = new Player($db);
    }

    public function index() {
        $matches = $this->match->getAll();
        require '../app/view/matches/index.php';
    }

    public function create() {
        $games = $this->game->getAll();
        $players = $this->player->getAll();
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gameID = $_POST['gameID'] ?? 0;
            $gameMode = $_POST['gameMode'] ?? 'PVP';
            $date = $_POST['date'] ?? date('Y-m-d H:i:s');
            $duration = $_POST['duration'] ?? '00:00:00';
            $notes = $_POST['notes'] ?? '';
            $playerData = $_POST['players'] ?? [];
            $players = [];
            foreach ($playerData as $p) {
                $players[] = ['playerID' => $p['playerID'], 'points' => $p['points']];
            }
            if ($this->match->create($gameID, $gameMode, $date, $duration, $notes, $players)) {
                header('Location: /matches');
                exit;
            } else {
                $error = "Error creating match: Duplicate players selected.";
            }
        }
        require '../app/view/matches/create.php';
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
            $id = $_POST['id'] ?? 0;
            if ($this->match->delete($id)) {
                header('Location: /matches');
                exit;
            } else {
                echo "Error deleting match.";
            }
        }
    }
}
