<?php
class GameMatch {
   private $id;
   private $gameID;
   private $gameMode;
   private $date;
   private $duration;
   private $notes;

   public function __construct($id = null, $gameID = null, $gameName = null, $gameMode = '', $date = null, $duration = null, $notes = '', $players = []) {
      $this->id = $id;
      $this->gameID = $gameID;
      $this->gameMode = $gameName;
      $this->gameMode = $gameMode;
      $this->date = $date;
      $this->duration = $duration;
      $this->notes = $notes;
      $this->players = $players
   }

   public function getId() { return $this->id; }
   public function getGameID() { return $this->gameID; }
   public function getGameName() { return $this->gameMode; }
   public function getGameMode() { return $this->gameMode; }
   public function getDate() { return $this->date; }
   public function getDuration() { return $this->duration; }
   public function getNotes() { return $this->notes; }
   // TODO : Add getters for players

   public function setGameID($gameID) { $this->gameID = $gameID; }
   public function setGameMode($gameMode) { $this->gameMode = $gameMode; }
   public function setGameName($gameName) { $this->gameMode = $gameName; }
   public function setDate($date) { $this->date = $date; }
   public function setDuration($duration) { $this->duration = $duration; }
   public function setNotes($notes) { $this->notes = $notes; }
}
