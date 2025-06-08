<?php
class Player {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function all() {
        $stmt = $this->db->query("SELECT * FROM Player");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
