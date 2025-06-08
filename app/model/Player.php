<?php
class Player {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Player");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($firstName, $lastName, $nickname) {
        $stmt = $this->db->prepare("INSERT INTO Player (firstName, lastName, nickname) VALUES (?, ?, ?)");
        return $stmt->execute([$firstName, $lastName, $nickname]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Player WHERE ID = ?");
        return $stmt->execute([$id]);
    }
}
