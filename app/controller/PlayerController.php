<?php
require_once '../app/model/Player.php';

class PlayerController {
    public function index($db) {
        $model = new Player($db);
        $players = $model->all();
        require '../app/view/player_list.php';
    }
}
