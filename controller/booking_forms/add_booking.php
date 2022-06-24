<?php

if(isset($_POST["add_booking"])) {
    $booking = new booking_model($_POST["customer"], $_POST["session"]);
    $controlador = new booking_controller();
    $respuesta = $controlador->insert($booking);
}