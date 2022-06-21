<?php

class area_model {
    public $id_area;
    public $number;
    public $name;
    public $description;
    public $outdoor;

    /**
     * @param $id_area
     * @param $number
     * @param $name
     * @param $description
     * @param $outdoor
     */
    public function __construct($id_area, $number, $name, $description, $outdoor)
    {
        $this->id_area = $id_area;
        $this->number = $number;
        $this->name = $name;
        $this->description = $description;
        $this->outdoor = $outdoor;
    }
}