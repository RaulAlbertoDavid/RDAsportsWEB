<?php

require_once("../model/booking_model.php");

class booking_controller {

    public function __construct() {}

    public function insert($booking) {
        return booking_model::insert($booking);
    }

    public function delete($customer_id, $session_id){
        return booking_model::delete($customer_id, $session_id);
    }
}