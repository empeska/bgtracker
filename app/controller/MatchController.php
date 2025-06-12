<?php
require_once '../app/model/GameMatchRepo.php';
require_once '../app/model/GameRepo.php';
require_once '../app/model/PlayerRepo.php';

class MatchController {
   private $gameMatchRepo;
   private $gameRepo;
   private $playerRepo;

   public function __construct($db) {
      $this->gameMatchRepo = new GameMatchRepo($db);
      $this->gameRepo = new GameRepo($db);
      $this->playerRepo = new PlayerRepo($db);
   }

   public function index() {
      $matches = $this->gameMatchRepo->getAll();
      require '../app/view/match/index.php';
   }

   public function create() {
      $games = $this->gameRepo->getAll();
      $players = $this->playerRepo->getAll();
      $error = null;
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         var_dump($_POST);
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
         if ($this->gameMatchRepo->create($gameID, $gameMode, $date, $duration, $notes, $players)) {
            header('Location: /match');
            exit;
         } else {
            $error = "Error creating match: Duplicate players selected.";
         }
      }
      require '../app/view/match/create.php';
   }

   public function delete() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
         $id = $_POST['id'] ?? 0;
         if ($this->gameMatchRepo->delete($id)) {
            header('Location: /matches');
            exit;
         } else {
            echo "Error deleting match.";
         }
      }
   }
}
