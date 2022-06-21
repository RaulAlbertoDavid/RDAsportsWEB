<?php

require_once("../model/employee_model.php");

class employee_controller {

    public function __construct() {}

    /**
     * function
     * iniciar_sesion($email, $password)
     * Devuelve objeto employee_model o String en caso de error
     *
     * customer_controller.php
     *
     * @param String $email
     * @param String $password
     * @return employee_model
     */
    public function iniciar_sesion($email, $password) {
        return employee_model::get_employee($email, $password);
    }

    /**
     * function
     * cerrar()
     * Elimina sesión y redirecciona al index.
     */
    public function cerrar() {
        $_SESSION = array();
        session_destroy();
        header("Location: ../view/index.php");
    }
}

//Valiables y objeto controlador utilizad@s en los require_once
$campo=null;
$validacion=true;
$controlador = new employee_controller();

//Cerrar sesión
if(isset($_GET["cerrar"])){
    $controlador->cerrar();
}

/* Cada require contiene las validaciones de formularios y acciones a realizar en la DDBB a través de modelo/Usuarios_modelo */
require_once("employee_forms/employee_login.php");
//require_once("usuario_forms/usuario_registrar.php");
//require_once("usuario_forms/usuario_modificar.php");
//require_once("usuario_forms/usuario_eliminar.php");
//require_once("usuario_forms/usuario_cambiapass.php");
