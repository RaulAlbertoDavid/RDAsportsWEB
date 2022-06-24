<?php

/***************************************************************
FORMULARIO REGISTRAR
Recuperación de datos enviados y muestra de mensajes.
 ***************************************************************/
// si session[formdata] NO está vacío...
if(!empty($_SESSION["formdata_en"])){
    // almacena variables con los datos para mostrarlos al usuario en caso de error.
    $email = trim($_SESSION["formdata_en"]["email"]);
    $name = trim($_SESSION["formdata_en"]["name"]);
    $phone = trim($_SESSION["formdata_en"]["phone"]);
    $birt_date = trim($_SESSION["formdata_en"]["birth_date"]);

    if($_GET["registro_en"]== ("si" || "no")){
        echo $_SESSION["mensajeregistrar_en"]; //muestra mensaje
        if(!empty($_GET["campo"])){
            $campo = $_GET["campo"]; //almacena el campo incorrecto en el formulario.
        }
    }
    unset($_SESSION["formdata_en"]); // elimina los datos almacenados en session
    unset($_SESSION["mensajeregistrar_en"]); // elimina los datos almacenados en session
}

/************************************************
FORMULARIO REGISTRAR
Validación de formulario y ejecución de consulta
 ************************************************/
//si post[registrar] está inicializada...
if(isset($_POST["registro_en"])){
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
            $mensaje = '<p class="error-form"><b>'.$key.'</b> field can not be empty</p>'; // asigna mensaje de error
            $validacion=false;
            header("Location:". $_SERVER['PHP_SELF']."?registro_en=no&campo=$key"); //redirecciona detallando el campo que falló
            break;
            // comprueba el campo nombre y apellido. Permite letras con acentos, espacios, minimo 2 maximo 20 caracteres.
        }elseif(($key == "name") && !preg_match("/^[ A-Za-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙñÑ]{2,30}+$/", $value)){
            $mensaje = '<p class="error-form"><b>'.$key.'</b> field can only contain words <br>(minimum 2 and maximum 30 characters).</p>';
            $validacion=false;
            header("Location:". $_SERVER['PHP_SELF']."?registro_en=no&campo=$key");
            break;
            // comprueba que el campo email sea válido y que no supere los 50 caracteres
        }elseif($key == "email"){
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                $mensaje = '<p class="error-form">Wrong email: <b>'.$value.'</b></p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro_en=no&campo=$key");
                break;
            }elseif(strlen($value) > ($num=50)){
                $mensaje = '<p class="error-form"><b>'.$key.'</b> field can not have more than '.$num.' characters</p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro_en=no&campo=$key");
                break;
            }
            // comprueba que el campo password no tenga menos de 4 caracteres y que el campo confirmar password coincida.
        }elseif($key == "password"){
            if(strlen($value) < $num=4){
                $mensaje = '<p class="error-form"><b>'.$key.'</b> field must have more than '.$num.' characters</p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro_en=no&campo=$key");
                break;
            }elseif($value != $password2){
                $mensaje = '<p class="error-form"><b>'.$key.'</b> field and confirm password must identical</p>';
                $validacion=false;
                header("Location:". $_SERVER['PHP_SELF']."?registro_en=no&campo=$key");
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
            $_SESSION["formdata_en"] = $_POST;
            $_SESSION["mensajeregistrar_en"] = $respuesta;
            header("Location:". $_SERVER['PHP_SELF']."?registro_en=no");

            // Si no ocurre ningun error...
        }else{
            $_SESSION["formdata_en"] = $_POST; // almacena los datos enviados por post.
            $customer = $controlador->iniciar_sesion($_POST["email"], $_POST["password"]);
            $_SESSION["NAME"] = $customer->name;
            $_SESSION["EMAIL"] = $customer->email;
            $_SESSION["PHONE"] = $customer->phone;
            $_SESSION["BIRTH_DATE"] = $customer->birth_date;
            $_SESSION["CUSTOMER_ID"] = $customer->customer_id;
            header("Location:index_en.php");
        }
        // si validación es false...
    }else{
        $_SESSION["formdata_en"] = $_POST; // almacena datos enviados por formulario
        $_SESSION["mensajeregistrar_en"] = $mensaje; //almacena mensaje de error.
    }
}