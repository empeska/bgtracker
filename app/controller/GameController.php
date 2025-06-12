<?php
require_once '../app/model/GameRepo.php';

class GameController {
   private $gameRepo;

   public function __construct($db) {
      $this->gameRepo = new GameRepo($db);
   }

   public function index() {
      $games = $this->gameRepo->getAll();
      require '../app/view/game/index.php';
   }

   public function create() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $name = $_POST['name'] ?? '';
         $description = $_POST['description'] ?? '';
         $defaultMode = $_POST['defaultMode'] ?? 'PVP';
         if ($this->gameRepo->create($name, $description, $defaultMode)) {
            header('Location: /game');
            exit;
         }
      }
      require '../app/view/game/create.php';
   }

   public function delete() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
         $id = $_POST['id'] ?? 0;
         if ($this->gameRepo->delete($id)) {
            header('Location: /game');
            exit;
         } else {
            echo "Error deleting game.";
         }
      }
   }

   public function stats() {
      $gameID = $_GET['id'] ?? 0;
      if ($gameID) {
         $stats = $this->gameRepo->getGameStats($gameID);
         if ($stats) {
            require '../app/view/game/stats.php';
         } else {
            echo "No stats found for this game.";
         }
      } else {
         echo "Invalid game ID.";
      }
   }
}
