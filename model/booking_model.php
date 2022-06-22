<?php

class booking_model {
    public $customer_id;
    public $session_id;

    /**
     * @param $customer_id
     * @param $session_id
     */
    public function __construct($customer_id, $session_id)
    {
        $this->customer_id = $customer_id;
        $this->session_id = $session_id;
    }

    public static function insert($booking){
        try {
            $conexion = Conectar::Conexion();
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "INSERT INTO SESSIONS_CUSTOMERS (CUSTOMERS_CUSTOMER_ID, SESSIONS_SESSION_ID) VALUES (:CUS, :SES)";
            $respuesta = $conexion->prepare($sql);
            return $respuesta->execute(array(":CUS"=>$booking->customer_id, ":SES"=>$booking->session_id));

            $respuesta->closeCursor();
            $conexion = null;

        } catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }

    public static function delete($customer_id, $session_id) {
        try {
            $conexion = Conectar::Conexion();
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "DELETE FROM SESSIONS_CUSTOMERS WHERE SESSIONS_SESSION_ID = :SES AND CUSTOMERS_CUSTOMER_ID = :CUS";
            $respuesta = $conexion->prepare($sql);
            return $respuesta->execute(array(":SES"=>$session_id, ":CUS"=>$customer_id));

            $respuesta->closeCursor();
            $conexion = null;

        } catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }
}