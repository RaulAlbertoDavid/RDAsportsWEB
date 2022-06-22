<?php

require_once("../model/session_model.php");

class session_controller {

    public function __construct() {}

    public function insert($session) {
        return session_model::insert($session);
    }

    public function delete($session_id){
        return session_model::delete($session_id);
    }
}

$controlador = new session_controller();
require_once("session_forms/add_session.php");