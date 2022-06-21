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
    public function cerrar()
    {
        $_SESSION = array();
        session_destroy();
        header("Location: ../vista/index.php");
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

/* Cada require contiene las validaciones de formularios y acciones a realizar en la DDBB a través de modelo/Usuarios_modelo */
//require_once("usuario_forms/usuario_login.php");
//require_once("usuario_forms/usuario_registrar.php");
//require_once("usuario_forms/usuario_modificar.php");
//require_once("usuario_forms/usuario_eliminar.php");
//require_once("usuario_forms/usuario_cambiapass.php");
