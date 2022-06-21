<?php

class activity_model {
    public $activity_id;
    public $name;
    public $description;
    public $material;
    public $is_airobic;

    /**
     * @param $activity_id
     * @param $name
     * @param $description
     * @param $material
     * @param $is_airobic
     */
    public function __construct($activity_id, $name, $description, $material, $is_airobic)
    {
        $this->activity_id = $activity_id;
        $this->name = $name;
        $this->description = $description;
        $this->material = $material;
        $this->is_airobic = $is_airobic;
    }
}