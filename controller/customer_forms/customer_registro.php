<?php

/***************************************************************
FORMULARIO REGISTRAR
Recuperación de datos enviados y muestra de mensajes.
 ***************************************************************/
// si session[formdata] NO está vacío...
if(!empty($_SESSION["formdata"])){
    // almacena variables con los datos para mostrarlos al usuario en caso de error.
    $email = trim($_SESSION["formdata"]["email"]);
    $name = trim($_SESSION["formdata"]["name"]);
    $phone = trim($_SESSION["formdata"]["phone"]);
    $birt_date = trim($_SESSION["formdata"]["birth_date"]);

    if($_GET["registro"]== ("si" || "no")){
        echo $_SESSION["mensajeregistrar"]; //muestra mensaje
        if(!empty($_GET["campo"])){
            $campo = $_GET["campo"]; //almacena el campo incorrecto en el formulario.
        }
    }
    unset($_SESSION["formdata"]); // elimina los datos almacenados en session
    unset($_SESSION["mensajeregistrar"]); // elimina los datos almacenados en session
}

/************************************************
FORMULARIO REGISTRAR
Validación de formulario y ejecución de consulta
 ************************************************/
//si post[registrar] está inicializada...
if(isset($_POST["registro"])){
    $password2 = $_POST["password2"]; //almacena variable para comprobación de contraseña

    /*****************************************
    VALIDACION DE CAMPOS
    recorre los datos enviados por formulario.
     *****************************************/
    foreach($_POST as $key=>$value){
        //elimina los espacios del principio y final.
        $value = trim($value);
        // si el campo está vacío
        if($value == ""){
            $mensaje = '<p class="error-form">El campo <b>'.$key.'</b> no puede estár vacío</p>'; // asigna mensaje de error
            $validacion=false;
            header("Location:". $_SERVER['PHP_SELF']."?registro=no&campo=$key"); //redirecciona detallando el campo que falló
            break;
            // comprueba el campo nombre y apellido. Permite letras con acentos, espacios, minimo 2 maximo 20 caracteres.
        }elseif(($key == "name") && !preg_match("/^[ A-Za-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙñÑ]{2,30}+$/", $value)){
            $mensaje = '<p class="error-form">El campo <b>'.$key.'</b> sólo puede contener letras <br>(mínimo 2 y máximo 30 caracteres).</p>';
            $validacion=false;
            header("Location:". $_SERVER['PHP_SELF']."?registro=no&campo=$key");
            break;
            // comprueba que el campo email sea válido y que no supere los 50 caracteres
        }elseif($key == "email"){
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                $mensaje = '<p class="error-form">El email <b>'.$value.'</b> está incorrecto.</p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro=no&campo=$key");
                break;
            }elseif(strlen($value) > ($num=50)){
                $mensaje = '<p class="error-form">El campo <b>'.$key.'</b> no debe ser mayor que '.$num.' caracteres</p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro=no&campo=$key");
                break;
            }
            // comprueba que el campo password no tenga menos de 4 caracteres y que el campo confirmar password coincida.
        }elseif($key == "password"){
            if(strlen($value) < $num=4){
                $mensaje = '<p class="error-form">El campo <b>'.$key.'</b> debe ser mayor que '.$num.'</p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro=no&campo=$key");
                break;
            }elseif($value != $password2){
                $mensaje = '<p class="error-form">El campo <b>'.$key.'</b> y confirmar password deben coincidir</p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro=no&campo=$key");
                break;
            }
        }
    }

    // si $validación es true...
    if($validacion){
        // crea un objeto usuario
        $customer = new customer_model(0, $_POST["name"], $_POST["email"], $_POST["phone"], $_POST["birth_date"]);
        //llama a la función registrar()
        $controlador = new customer_controller();
        $respuesta = $controlador->registrar($customer, $_POST["password"]);

        //Si ya existe el alias o si ocurre un error al ejecutar la consulta vuelve a seccion registrar y muestra el mensaje.
        if(gettype($respuesta) == "string"){
            $_SESSION["formdata"] = $_POST;
            $_SESSION["mensajeregistrar"] = $respuesta;
            header("Location:". $_SERVER['PHP_SELF']."?registro=no");

            // Si no ocurre ningun error...
        }else{
            $_SESSION["formdata"] = $_POST; // almacena los datos enviados por post.
            $customer = $controlador->iniciar_sesion($_POST["email"], $_POST["password"]);
            $_SESSION["NAME"] = $customer->name;
            $_SESSION["EMAIL"] = $customer->email;
            $_SESSION["PHONE"] = $customer->phone;
            $_SESSION["BIRTH_DATE"] = $customer->birth_date;
            $_SESSION["CUSTOMER_ID"] = $customer->customer_id;
            header("Location:index.php");
        }
        // si validación es false...
    }else{
        $_SESSION["formdata"] = $_POST; // almacena datos enviados por formulario
        $_SESSION["mensajeregistrar"] = $mensaje; //almacena mensaje de error.
    }
}