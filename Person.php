<?php

use CanPrintJson;

class Person extends CanPrintJson {
    public $name;
    public $birthDate;
    public $gender;
    public $interests = [];

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setBirthDay($birth_day)
    {
        $this->birthDate = $birth_day;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setInterest($interest)
    {
        $this->interests[] = $interest;
    }
}