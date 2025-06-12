<?php
class GameMatch {
   private $id;
   private $gameID;
   private $gameMode;
   private $gameName;
   private $date;
   private $duration;
   private $notes;
   private $players;

   public function __construct($id = null, $gameID = null, $gameName = null, $gameMode = '', $date = null, $duration = null, $notes = '', $players = '') {
      $this->id = $id;
      $this->gameID = $gameID;
      $this->gameName = $gameName;
      $this->gameMode = $gameMode;
      $this->date = $date;
      $this->duration = $duration;
      $this->notes = $notes;
      $this->players = $players;
   }

   public function getId() { return $this->id; }
   public function getGameID() { return $this->gameID; }
   public function getGameName() { return $this->gameName; }
   public function getGameMode() { return $this->gameMode; }
   public function getDate() { return $this->date; }
   public function getDuration() { return $this->duration; }
   public function getNotes() { return $this->notes; }
   public function getPlayers() { return $this->players; }

   public function setGameID($gameID) { $this->gameID = $gameID; }
   public function setGameMode($gameMode) { $this->gameMode = $gameMode; }
   public function setGameName($gameName) { $this->gameMode = $gameName; }
   public function setDate($date) { $this->date = $date; }
   public function setDuration($duration) { $this->duration = $duration; }
   public function setNotes($notes) { $this->notes = $notes; }
}
