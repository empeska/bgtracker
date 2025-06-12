<?php
/**
 * @file
 * @ingroup Model
 * Klasa PlayerRepo jest wykorzystywana do zarządzania danymi związanymi z listą graczy w bazie danych.
 */
require_once __DIR__ . '/Player.php';

class PlayerRepo {
   private $db;

   public function __construct() {
      $this->db = require __DIR__ . '/../../config/database.php';
   }

   public function getAll() {
      $stmt = $this->db->query("SELECT * FROM Player");
      $players = [];
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
         $players[] = new Player($row['ID'], $row['firstName'], $row['lastName'], $row['nickname']);
      }
      return $players;
   }

   public function create($firstName, $lastName, $nickname) {
      $stmt = $this->db->prepare("INSERT INTO Player (firstName, lastName, nickname) VALUES (?, ?, ?)");
      return $stmt->execute([$firstName, $lastName, $nickname]);
   }

   public function delete($id) {
      $stmt = $this->db->prepare("DELETE FROM Player WHERE ID = ?");
      return $stmt->execute([$id]);
   }

   public function getPlayerRankingForMatch($matchID) {
      $query = "
            SELECT p.nickname, mp.points
            FROM Match_Players mp
            JOIN Player p ON mp.playerID = p.ID
            WHERE mp.matchID = :matchID
            ORDER BY mp.points DESC
        ";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['matchID' => $matchID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getMostPlayedGames($playerID) {
      $query = "
            SELECT g.name, COUNT(DISTINCT gm.ID) as games_played
            FROM GameMatch gm
            JOIN Game g ON gm.gameID = g.ID
            JOIN Match_Players mp ON mp.matchID = gm.ID
            WHERE mp.playerID = :playerID
            GROUP BY g.ID, g.name
            ORDER BY games_played DESC
        ";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['playerID' => $playerID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getMostWonGames($playerID) {
      $query = "
            WITH PlayerMatches AS (
                SELECT gm.gameID, g.name, COUNT(DISTINCT gm.ID) as total_games,
                       SUM(CASE WHEN mp.points = (
                           SELECT MAX(points) FROM Match_Players mp2 WHERE mp2.matchID = mp.matchID
                       ) THEN 1 ELSE 0 END) as wins
                FROM GameMatch gm
                JOIN Game g ON gm.gameID = g.ID
                JOIN Match_Players mp ON mp.matchID = gm.ID
                WHERE mp.playerID = :playerID
                GROUP BY gm.gameID, g.name
            )
            SELECT name, total_games, wins, (wins / total_games * 100) as win_percentage
            FROM PlayerMatches
            WHERE total_games > 0
            ORDER BY win_percentage DESC, total_games DESC
        ";
      $stmt = $this->db->prepare($query);
      $stmt->execute(['playerID' => $playerID]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public function getById($id) {
       $stmt = $this->db->prepare("SELECT * FROM Player WHERE ID = ?");
       $stmt->execute([$id]);
       return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   public function getGlobalWinrate($playerID) {
       $query = "
           WITH Matches AS (
               SELECT mp.matchID,
                      CASE WHEN mp.points = (
                        SELECT MAX(points)
                        FROM Match_Players mp2
                        WHERE mp2.matchID = mp.matchID
                      ) THEN 1 ELSE 0 END AS win
               FROM Match_Players mp
               JOIN GameMatch gm ON gm.ID = mp.matchID
               WHERE mp.playerID = :playerID AND gm.gameMode = 'PVP'
           )
           SELECT COUNT(*) AS total, SUM(win) AS wins,
                  ROUND(SUM(win) * 100.0 / NULLIF(COUNT(*), 0), 2) AS winrate
           FROM Matches;
       ";
       $stmt = $this->db->prepare($query);
       $stmt->execute(['playerID' => $playerID]);
       return $stmt->fetch(PDO::FETCH_ASSOC);
   }
}
