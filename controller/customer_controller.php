<?php

require_once("../model/customer_model.php");

class customer_controller {

    public function __construct() {}

    /**
     * function
     * iniciar_sesion($email, $password)
     * Devuelve objeto customer_model o String en caso de error
     *
     * customer_controller.php
     *
     * @param String $email
     * @param String $password
     * @return customer_model
     */
    public function iniciar_sesion($email, $password) {
        return customer_model::get_customer($email, $password);
    }

    /**
     * function
     * registrar($customer, $password)
     * Devuelve Boolean o String en caso de error
     *
     * customer_controller.php
     *
     * @param Object $customer
     * @param String $password
     * @return Boolean
     */
    public function registrar($customer, $password) {
        return customer_model::registrar($customer, $password);
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
$controlador = new customer_controller();

//Cerrar sesión
if(isset($_GET["cerrar"])){
    $controlador->cerrar();
}

if(isset($_GET["logout"])){
    $controlador->logout();
}

/* Cada require contiene las validaciones de formularios y acciones a realizar en la DDBB a través de modelo/Usuarios_modelo */
require_once("customer_forms/customer_login.php");
require_once("customer_forms/customer_registro.php");
require_once("customer_forms/customer_login_en.php");
require_once("customer_forms/customer_registro_en.php");
