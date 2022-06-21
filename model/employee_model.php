<?php

require_once("conexion/conexion.php");
class employee_model {
    public $employee_id;
    public $name;
    public $email;
    public $phone;
    public $active;

    /**
     * @param $employee_id
     * @param $name
     * @param $email
     * @param $phone
     * @param $active
     */
    public function __construct($employee_id, $name, $email, $phone, $active)
    {
        $this->employee_id = $employee_id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->active = $active;
    }

    /**
     * function
     * get_employee($email, $password)
     * Devuelve Boolean o String en caso de error
     *
     * usuarios_modelo.php
     *
     * @param String $email
     * @param String $password
     * @return Employee_model
     */
    public static function get_employee($email, $password){
        try{
            $conexion = Conectar::Conexion();

            //Si $conexion es de tipo String, es porque se produjo una excepción. Para la ejecución de la función devolviendo el mensaje de la excepción.
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "SELECT EMPLOYEE_ID, NAME, EMAIL, PHONE, ACTIVE FROM EMPLOYEES WHERE EMAIL=:email AND PASSWORD=:password";
            $respuesta = $conexion->prepare($sql);
            $respuesta->execute(array(':email'=>$email, ':password'=>$password));
//            $respuesta->execute(array(':email'=>"email@example.com", ':password'=>"1234"));
            $respuesta = $respuesta->fetch(PDO::FETCH_ASSOC);
            // Si el array no está vacío, crea y devuelve un objeto Usuario.
            if($respuesta){
                $employee = new Employee_model($respuesta["EMPLOYEE_ID"], $respuesta["NAME"], $respuesta["EMAIL"], $respuesta["PHONE"], $respuesta["ACTIVE"]);
                return $employee;
            }else{
                return null;
            }
            $respuesta->closeCursor();
            $conexion = null;

        }catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }
}