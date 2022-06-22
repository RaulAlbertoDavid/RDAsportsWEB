<?php

if(isset($_POST["delete_booking"])) {
    $controlador = new booking_controller();
    $respuesta = $controlador->delete($_POST["customer"], $_POST["session"]);
}