<?php
require_once("../model/booking_model.php");
require_once("../controller/booking_controller.php");
$data['customer'] = $_POST['customer'];
$data['session'] = $_POST['session'];

echo json_encode($data);

$controlador = new booking_controller();
$respuesta = $controlador->delete($_POST["customer"], $_POST["session"]);

exit;