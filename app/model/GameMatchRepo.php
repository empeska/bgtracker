<?php
require_once __DIR__ . '/GameMatch.php';

class GameMatchRepo {
   private $db;

   public function __construct() {
      $this->db = require __DIR__ . '/../../config/database.php';
   }

   public function getAll() {
      $stmt = $this->db->query("
            SELECT gm.*, g.name AS gameName
            FROM GameMatch gm
            JOIN Game g ON gm.gameID = g.ID
            ");
      $matches = [];
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
         $matches[] = new GameMatch(
            $row['ID'],
            $row['gameID'],
            $row['gameName'],
            $row['gameMode'],
            $row['date'],
            $row['duration'],
            $row['notes']
         );
      }
      return $matches;
   }

   public function create($gameID, $gameMode, $date, $duration, $notes) {
      $stmt = $this->db->prepare("INSERT INTO GameMatch (gameID, gameMode, date, duration, notes) VALUES (?, ?, ?, ?, ?)");
      return $stmt->execute([$gameID, $gameMode, $date, $duration, $notes]);
   }

   public function delete($id) {
      $stmt = $this->db->prepare("DELETE FROM GameMatch WHERE ID = ?");
      return $stmt->execute([$id]);
   }

   public function addPlayerToMatch($matchID, $playerID, $points) {
      $stmt = $this->db->prepare("INSERT INTO Match_Players (matchID, playerID, points) VALUES (?, ?, ?)");
      return $stmt->execute([$matchID, $playerID, $points]);
   }
}
