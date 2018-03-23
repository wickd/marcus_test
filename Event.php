<?php

use CanPrintJson;

class Event extends CanPrintJson {
    public $name;
    public $start_at;
    public $duration;

    public function __construct($name, $start_at, $duration)
    {
        $this->name = $name;
        $this->start_at = $start_at;
        $this->duration = $duration;
    }
}
