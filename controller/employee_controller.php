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
        header("Location: ../view/login.php");
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        header("Location: ../view/login_en.php");
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

if(isset($_GET["logout"])){
    $controlador->logout();
}

/* Cada require contiene las validaciones de formularios y acciones a realizar en la DDBB a través de modelo/Usuarios_modelo */
require_once("employee_forms/employee_login.php");
require_once("employee_forms/employee_login_en.php");
