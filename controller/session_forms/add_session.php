<?php

if(isset($_POST["add_session"])) {
    $session = new session_model(0, $_POST["employee"], $_POST["activity"], $_POST["area"], $_POST["date"], $_POST["duration"], $_POST["capacity"], $_POST["level"]);
    $controlador = new session_controller();
    $respuesta = $controlador->insert($session);
}