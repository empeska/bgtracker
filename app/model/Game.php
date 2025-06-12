<?php
/**
 * @file
 * @ingroup Model
 * Klasa Game reprezentuje grę w bibliotece.
 */
class Game {
   private $id;
   private $name;
   private $description;
   private $defaultMode;

   public function __construct($id = null, $name = '', $description = '', $defaultMode = '') {
      $this->id = $id;
      $this->name = $name;
      $this->description = $description;
      $this->defaultMode = $defaultMode;
   }

   // Getters and setters
   public function getId() { return $this->id; }
   public function getName() { return $this->name; }
   public function getDescription() { return $this->description; }
   public function getDefaultMode() { return $this->defaultMode; }

   public function setDescription($description) { $this->description = $description; }
   public function setName($name) { $this->name = $name; }
   public function setDefaultMode($defaultMode) { $this->defaultMode = $defaultMode; }
}
