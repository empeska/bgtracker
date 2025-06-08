<?php
class GameMatch {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT m.*, g.name AS gameName, GROUP_CONCAT(p.nickname) AS players
            FROM `GameMatch` m
            JOIN `Game` g ON m.gameID = g.ID
            JOIN `Match_Players` mp ON m.ID = mp.matchID
            JOIN `Player` p ON mp.playerID = p.ID
            GROUP BY m.ID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($gameID, $gameMode, $date, $duration, $notes, $players) {
        $this->db->beginTransaction();
        try {
            $playerIDs = array_column($players, 'playerID');
            if (count($playerIDs) !== count(array_unique($playerIDs))) {
                throw new Exception("Duplicate players selected");
            }

            $stmt = $this->db->prepare("INSERT INTO `GameMatch` (gameID, gameMode, date, duration, notes) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$gameID, $gameMode, $date, $duration, $notes]);
            $matchID = $this->db->lastInsertId();

            foreach ($players as $player) {
                $stmt = $this->db->prepare("INSERT INTO `Match_Players` (matchID, playerID, points) VALUES (?, ?, ?)");
                $stmt->execute([$matchID, $player['playerID'], $player['points']]);
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Match creation failed: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM `GameMatch` WHERE ID = ?");
        return $stmt->execute([$id]);
    }
}
