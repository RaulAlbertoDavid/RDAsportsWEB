<?php

require_once("conexion/conexion.php");
class customer_model {
    public $customer_id;
    public $name;
    public $email;
    public $phone;
    public $birth_date;

    /**
     * @param $customer_id
     * @param $name
     * @param $email
     * @param $phone
     * @param $birth_date
     */
    public function __construct($customer_id, $name, $email, $phone, $birth_date)
    {
        $this->customer_id = $customer_id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->birth_date = $birth_date;
    }

    /**
     * function
     * get_usuario($alias, $password)
     * Devuelve Boolean o String en caso de error
     *
     * usuarios_modelo.php
     *
     * @param String $email
     * @param String $password
     * @return Customer_model
     */
    public static function get_customer($email, $password){
        try{
            $password = self::cryptconmd5($password);
            $conexion = Conectar::Conexion();

            //Si $conexion es de tipo String, es porque se produjo una excepción. Para la ejecución de la función devolviendo el mensaje de la excepción.
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "SELECT CUSTOMER_ID, NAME, EMAIL, PHONE, BIRTH_DATE FROM CUSTOMERS WHERE EMAIL=:email AND PASSWORD=:password";
            $respuesta = $conexion->prepare($sql);
            $respuesta->execute(array(':email'=>$email, ':password'=>$password));
            $respuesta = $respuesta->fetch(PDO::FETCH_ASSOC);

            // Si el array no está vacío, crea y devuelve un objeto Usuario.
            if($respuesta){
                $customer = new Customer_model($respuesta["CUSTOMER_ID"], $respuesta["NAME"], $respuesta["EMAIL"], $respuesta["PHONE"], $respuesta["BIRTH_DATE"]);
                return $customer;
            }else{
                return $customer = null;
            }
            $respuesta->closeCursor();
            $conexion = null;

        }catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }

    /**
     * function
     * registrar($email, $password)
     * Devuelve Boolean o String en caso de error
     *
     * customer_model.php
     *
     * @param Object $customer
     * @param String $password
     * @return Boolean
     */
    public static function registrar($customer, $password){
        try{
            $password = self::cryptconmd5($password);
            $conexion = Conectar::Conexion();
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "INSERT INTO CUSTOMERS (NAME, EMAIL, PHONE, BIRTH_DATE, PASSWORD) VALUES (:NAM, :EMA, :PHO, :BIR, :PASS)";
            $respuesta = $conexion->prepare($sql);
            $respuesta = $respuesta->execute(array(":NAM"=>$customer->name, ":EMA"=>$customer->nombre, ":PHO"=>$customer->apellido, ":BIR"=>$customer->email, ":PASS"=>$password));
            return $respuesta;

            $respuesta->closeCursor();
            $conexion = null;

        }catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }
}