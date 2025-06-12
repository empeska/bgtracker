<?php
/**
 * @file
 * @ingroup Model
 * Klasa GameMatchRepo wykorzystywana jest do zarządzania danymi w bazie danych związanych z rozgrywkami.
 */
require_once __DIR__ . '/GameMatch.php';

class GameMatchRepo {
   private $db;

   public function __construct() {
      $this->db = require __DIR__ . '/../../config/database.php';
   }

   public function getAll() {
      $stmt = $this->db->query("SELECT m.*, g.name AS gameName, GROUP_CONCAT(p.nickname) AS players
         FROM `GameMatch` m
         JOIN `Game` g ON m.gameID = g.ID
         JOIN `Match_Players` mp ON m.ID = mp.matchID
         JOIN `Player` p ON mp.playerID = p.ID
         GROUP BY m.ID");
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $matches = [];
      foreach ($ret as $record) 
      {
         $matches[] = new GameMatch(
            $record['ID'],
            $record['gameID'],
            $record['gameName'],
            $record['gameMode'],
            $record['date'],
            $record['duration'],
            $record['notes'],
            $record['players']
         );
      }
      return $matches;
   }

   public function getMatchPlayers() {
      $stmt = $this->db->query("
            SELECT p.nickname
            FROM Player p
            
            ");
   }

   
   public function create($gameID, $gameMode, $date, $duration, $notes, $players) {
      $stmt = $this->db->prepare("INSERT INTO GameMatch (gameID, gameMode, date, duration, notes) VALUES (?, ?, ?, ?, ?)");
      $ret = $stmt->execute([$gameID, $gameMode, $date, $duration, $notes]);
      if ($ret) 
      {
         $matchID = $this->db->lastInsertId();
         foreach ($players as $player)
         {
            $this->addPlayerToMatch($matchID, $player['playerID'], $player['points']);
         }
      }
      return $ret;
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
