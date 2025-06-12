<?php
/**
 * @file
 * @ingroup Model
 * Klasa GameRepo wykorzystywana jest do zarządzania danymi w bazie danych związanych z grami.
 */
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
      WITH PlayerMatches AS (
         SELECT 
              mp.playerID,
              p.firstName,
              p.lastName,
              p.nickname,
              mp.matchID,
              mp.points,
              gm.gameID,
              ROW_NUMBER() OVER (PARTITION BY mp.matchID ORDER BY mp.points DESC) AS rank_in_match
          FROM 
              Match_Players mp
              JOIN GameMatch gm ON mp.matchID = gm.ID
              JOIN Player p ON mp.playerID = p.ID
              JOIN Game g ON gm.gameID = g.ID
          WHERE 
              g.ID = :gameID
      ),
      PlayerStats AS (
          SELECT 
              p.ID AS playerID,
              p.firstName,
              p.lastName,
              p.nickname,
              COUNT(mp.matchID) AS play_count,
              SUM(CASE WHEN pm.rank_in_match = 1 THEN 1 ELSE 0 END) AS wins
          FROM 
              Player p
              LEFT JOIN Match_Players mp ON p.ID = mp.playerID
              LEFT JOIN GameMatch gm ON mp.matchID = gm.ID
              LEFT JOIN Game g ON gm.gameID = g.ID
              LEFT JOIN PlayerMatches pm ON p.ID = pm.playerID AND pm.matchID = mp.matchID
          WHERE 
              g.ID = :gameID
          GROUP BY 
              p.ID, p.firstName, p.lastName, p.nickname
      )
      SELECT 
          firstName,
          lastName,
          nickname,
          play_count,
          CASE 
              WHEN play_count > 0 THEN ROUND((wins / play_count * 100), 2)
              ELSE 0
          END AS win_rate
      FROM 
          PlayerStats;
      ";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['gameID' => $gameID]);
      $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $stats;
   }
   public function getNameFromID($gameID) {
      $query = "
      SELECT
         g.Name
      FROM
         Game g
      WHERE
         g.ID = :gameID
      ";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['gameID' => $gameID]);
      return $stmt->fetch()[0];
   }
}
