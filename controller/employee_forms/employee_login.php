<?php
/****************************************************
FORMULARIO LOGIN
recuperación de datos enviados y muestra de mensajes.
 ****************************************************/
// Si session["formdatalogin] NO está vacio...
if(!empty($_SESSION["formdatalogin"])){
    //elimina espacios en blanco del principio y final
    $email = trim($_SESSION["formdatalogin"]["email"]);
    // si get["login] es no...
    if(($_GET["employee_login"]=="no")){
        echo $_SESSION["mensajelogin"];
        //si get["campo"] está instanciada...
        if(!empty($_GET["campo"])){
            $campo = $_GET["campo"]; // asigna el nombre de campo a la variable $campo para asignar el foco al campo.
        }
    }
    unset($_SESSION["formdatalogin"]); // elimina la formdatalogin
    unset($_SESSION["mensajelogin"]); // elimina la formdatalogin
}

/***********************************************
FORMULARIO LOGIN
Validación de formulario y ejecución de consulta
 ***********************************************/
if(!empty($_POST["login_employee"])){
    /*******************
    VALIDACION DE CAMPOS
    recorre los datos enviados por formulario.
     *******************/
    foreach($_POST as $key=>$value){
        //elimina espacios en blanco del principio y final
        $value = trim($value);
        //si algun campo está vacío...
        if($value == ""){
            $validacion=false;
            $mensaje = '<p class="error-form">El campo <b>'.$key.'</b> no puede estár vacío</p>'; //asigna mensaje de error.
            header("Location:". $_SERVER['PHP_SELF']."?employee_login=no&campo=$key"); //redirecciona detallando el campo que falló.
            break;
        }
    }

    // si $validacion es true...
    if($validacion){
        // Llama función iniciar_sesion() que devuelve un objeto usuario
        $controlador = new employee_controller();
        $employee = $controlador->iniciar_sesion($_POST["email"], $_POST["password"]);
        // Si $employee es un string, es porque se produjo un error
        if(gettype($employee) == "string"){
            $_SESSION["formdatalogin"] = $_POST; // almacena los datos enviados por formulario
            $_SESSION["mensajelogin"] = $employee; // almacena el mensaje de error
            header("Location:". $_SERVER['PHP_SELF']."?employee_login=no");
            // si $employee es null significa que el email o la contraseña son incorrectos.
        }elseif($employee == null){
            $_SESSION["formdatalogin"] = $_POST; // almacena datos enviados por formulario.
            $_SESSION["mensajelogin"] = '<p class="error-form">Email y/o Contraseña incorrecta</p>'; // almacena el mensaje de error.
            header("Location:". $_SERVER['PHP_SELF']."?employee_login=no");
            // Si $usuario es un objeto...
        }else{
            //Asigna las variables de sesión.
            $_SESSION["NAME"] = $employee->name;
            $_SESSION["EMAIL"] = $employee->email;
            $_SESSION["PHONE"] = $employee->phone;
            $_SESSION["ACTIVE"] = $employee->active;
            $_SESSION["ID"] = $employee->employee_id;
            header("Location:index.php");
        }
        // si $validacion es falso...
    }else{
        $_SESSION["formdatalogin"] = $_POST; //almacena los datos enviados por formulario
        $_SESSION["mensajelogin"] = $mensaje; // almacena el mensaje de error
    }
}