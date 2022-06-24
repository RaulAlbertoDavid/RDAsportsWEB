<?php

require_once("conexion/conexion.php");

class session_model {
    public $session_id;
    public $employee_id;
    public $activity_id;
    public $area_id;
    public $date_time;
    public $duration;
    public $capacity;
    public $level;

    /**
     * @param $session_id
     * @param $employee_id
     * @param $activity_id
     * @param $area_id
     * @param $date_time
     * @param $capacity
     * @param $level
     */
    public function __construct($session_id, $employee_id, $activity_id, $area_id, $date_time, $duration, $capacity, $level)
    {
        $this->session_id = $session_id;
        $this->employee_id = $employee_id;
        $this->activity_id = $activity_id;
        $this->area_id = $area_id;
        $this->date_time = $date_time;
        $this->duration = $duration;
        $this->capacity = $capacity;
        $this->level = $level;
    }

    public static function insert($session){
        try{
            $conexion = Conectar::Conexion();
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "INSERT INTO SESSIONS (EMPLOYEE_ID, ACTIVITY_ID, AREA_ID, DATE_TIME, DURATION, CAPACITY, LEVEL) VALUES (:EMP, :ACT, :ARE, :DAT, :DUR, :CAP, :LVL)";
            $respuesta = $conexion->prepare($sql);
            return $respuesta->execute(array(":EMP"=>$session->employee_id, ":ACT"=>$session->activity_id, ":ARE"=>$session->area_id, ":DAT"=>$session->date_time, ":DUR"=>$session->duration, ":CAP"=>$session->capacity, ":LVL"=>$session->level));

            $respuesta->closeCursor();
            $conexion = null;

        }catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }

    public static function delete($session_id){
        try{
            $conexion = Conectar::Conexion();
            if(gettype($conexion) == "string"){
                return $conexion;
            }

            $sql = "DELETE FROM SESSIONS WHERE SESSION_ID = :ID";
            $respuesta = $conexion->prepare($sql);
            return $respuesta->execute(array(":ID"=>$session_id));

            $respuesta->closeCursor();
            $conexion = null;

        }catch(PDOException $e){
            return Conectar::mensajes($e->getCode());
        }
    }
}
