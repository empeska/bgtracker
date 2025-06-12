<?php
/**
 * @file
 * @ingroup Controller
 * Klasa PlayerController zarządza modelami związanymi z zapisanymi graczami
 */
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

   public function stats() {
      $id = $_GET['id'] ?? 0;
      $player = $this->playerRepo->getById($id);
      $mostPlayed = $this->playerRepo->getMostPlayedGames($id);
      $mostWon = $this->playerRepo->getMostWonGames($id);
      $globalWinrate = $this->playerRepo->getGlobalWinrate($id);

      require '../app/view/player/stats.php';
   }
}
