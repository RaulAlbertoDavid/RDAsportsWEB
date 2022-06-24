<?php
/****************************************************
FORMULARIO LOGIN
recuperación de datos enviados y muestra de mensajes.
 ****************************************************/
// Si session["formdatalogin] NO está vacio...
if(!empty($_SESSION["formdatalogin_en"])){
    //elimina espacios en blanco del principio y final
    $email = trim($_SESSION["formdatalogin_en"]["email"]);
    // si get["login] es no...
    if(($_GET["login_en"]=="no")){
        echo $_SESSION["mensajelogin_en"];
        //si get["campo"] está instanciada...
        if(!empty($_GET["campo"])){
            $campo = $_GET["campo"]; // asigna el nombre de campo a la variable $campo para asignar el foco al campo.
        }
    }
    unset($_SESSION["formdatalogin_en"]); // elimina la formdatalogin
    unset($_SESSION["mensajelogin_en"]); // elimina la formdatalogin
}

/***********************************************
FORMULARIO LOGIN
Validación de formulario y ejecución de consulta
 ***********************************************/
if(!empty($_POST["login_customer_en"])){
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
            $mensaje = '<p class="error-form"><b>'.$key.'</b> field can not be empty</p>'; //asigna mensaje de error.
            header("Location:". $_SERVER['PHP_SELF']."?login_en=no&campo=$key"); //redirecciona detallando el campo que falló.
            break;
        }
    }

    // si $validacion es true...
    if($validacion){
        // Llama función iniciar_sesion() que devuelve un objeto usuario
        $controlador = new customer_controller();
        $customer = $controlador->iniciar_sesion($_POST["email"], $_POST["password"]);
        // Si $customer es un string, es porque se produjo un error
        if(gettype($customer) == "string"){
            $_SESSION["formdatalogin_en"] = $_POST; // almacena los datos enviados por formulario
            $_SESSION["mensajelogin_en"] = $customer; // almacena el mensaje de error
            header("Location:". $_SERVER['PHP_SELF']."?login_en=no");
            // si $customer es null significa que el email o la contraseña son incorrectos.
        }elseif($customer == null){
            $_SESSION["formdatalogin_en"] = $_POST; // almacena datos enviados por formulario.
            $_SESSION["mensajelogin_en"] = '<p class="error-form">Wrong email or password</p>'; // almacena el mensaje de error.
            header("Location:". $_SERVER['PHP_SELF']."?login_en=no");
            // Si $usuario es un objeto...
        }else{
            //Asigna las variables de sesión.
            $_SESSION["NAME"] = $customer->name;
            $_SESSION["EMAIL"] = $customer->email;
            $_SESSION["PHONE"] = $customer->phone;
            $_SESSION["BIRTH_DATE"] = $customer->birth_date;
            $_SESSION["CUSTOMER_ID"] = $customer->customer_id;
            header("Location:index_en.php");
        }
        // si $validacion es falso...
    }else{
        $_SESSION["formdatalogin_en"] = $_POST; //almacena los datos enviados por formulario
        $_SESSION["mensajelogin_en"] = $mensaje; // almacena el mensaje de error
    }
}