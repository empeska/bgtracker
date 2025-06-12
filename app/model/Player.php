<?php
class Player {
   private $id;
   private $firstName;
   private $lastName;
   private $nickname;

   public function __construct($id = null, $firstName = '', $lastName = '', $nickname = '') {
      $this->id = $id;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->nickname = $nickname;
   }

   public function getId() { return $this->id; }
   public function getFirstName() { return $this->firstName; }
   public function getLastName() { return $this->lastName; }
   public function getNickname() { return $this->nickname; }

   public function setFirstName($firstName) { $this->firstName = $firstName; }
   public function setLastName($lastName) { $this->lastName = $lastName; }
   public function setNickname($nickname) { $this->nickname = $nickname; }
}
