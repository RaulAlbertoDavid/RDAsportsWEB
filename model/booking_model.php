<?php

class booking_model {
    public $costumer_id;
    public $session_id;

    /**
     * @param $costumer_id
     * @param $session_id
     */
    public function __construct($costumer_id, $session_id)
    {
        $this->costumer_id = $costumer_id;
        $this->session_id = $session_id;
    }

    public static function insert($booking){
        try {
            $conexion = Conectar::Conexion();
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "INSERT INTO SESSIONS (CUSTOMER_ID, SESSION_ID) VALUES (:CUS, :SES)";
            $respuesta = $conexion->prepare($sql);
            return $respuesta->execute(array(":CUS"=>$booking->employee_id, ":SES"=>$booking->activity_id));

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

            $sql = "DELETE FROM SESSIONS_CUSTOMERS WHERE SESSION_ID = :SES AND CUSTOMER_ID = :CUS";
            $respuesta = $conexion->prepare($sql);
            return $respuesta->execute(array(":SES"=>$session_id, ":CUS"=>$customer_id));

            $respuesta->closeCursor();
            $conexion = null;

        } catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }
}