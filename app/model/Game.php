<?php
class Game {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Game");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $description, $defaultMode) {
        $stmt = $this->db->prepare("INSERT INTO Game (name, description, defaultMode) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $description, $defaultMode]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Game WHERE ID = ?");
        return $stmt->execute([$id]);
    }
}
