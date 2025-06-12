<?php
require_once __DIR__ . '/Game.php';

class GameRepo {
   private $db;

   public function __construct() {
      $this->db = require __DIR__ . '/../../config/database.php';
   }

   public function getAll() {
      $stmt = $this->db->query("SELECT * FROM Game");
      $games = [];
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
         $games[] = new Game($row['ID'], $row['name'], $row['description'], $row['defaultMode']);
      }
      return $games;
   }

   public function create($name, $description, $defaultMode) {
      $stmt = $this->db->prepare("INSERT INTO Game (name, description, defaultMode) VALUES (?, ?, ?)");
      $ret = $stmt->execute([$name, $description, $defaultMode]);
      return $ret;
   }

   public function delete($id) {
      $stmt = $this->db->prepare("DELETE FROM Game WHERE ID = ?");
      return $stmt->execute([$id]);
   }

   public function getGameStats($gameID) {
      $query = "
            SELECT 
                COUNT(DISTINCT gm.ID) as total_matches,
                GROUP_CONCAT(DISTINCT (
                    SELECT p.nickname 
                    FROM Match_Players mp2 
                    JOIN Player p ON p.ID = mp2.playerID 
                    WHERE mp2.matchID = gm.ID 
                    AND mp2.points = (
                        SELECT MAX(points) 
                        FROM Match_Players mp3 
                        WHERE mp3.matchID = gm.ID
                    )
                )) as top_players,
                GROUP_CONCAT(DISTINCT (
                    SELECT p.nickname 
                    FROM Match_Players mp4 
                    JOIN Player p ON p.ID = mp4.playerID 
                    WHERE mp4.matchID = gm.ID
                    GROUP BY p.ID 
                    ORDER BY COUNT(*) DESC 
                    LIMIT 1
                )) as most_frequent_players
            FROM GameMatch gm
            WHERE gm.gameID = :gameID
        ";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['gameID' => $gameID]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
   }
}
