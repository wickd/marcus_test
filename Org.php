<?php

use CanPrintJson;

class Org {
    public $name;
    public $adress;
    public $owner;
    public $orgId;
    public $upcoming_events = [];

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAddress($adress)
    {
        $this->adress = $adress;
    }

    public function setOrgOwner($owner)
    {
        $this->owner = $owner;
    }

    public function setOrgId($orgId)
    {
        $this->validateId($orgId);
    }

    public function addEvent($event)
    {
        $this->upcoming_events[] = $event;
    }

    public function getNextEvent()
    {
        $foo = new Donor();

        //@todo Must get last event with ateendes
        $foo->attendEvent();
    }

    public function validateId($id)
    {
        $match = preg_match('/^(49|94)[a-zA-Z0-9]{5,6}[A-Z]{2}$/', $id);

        if ($match) {
            $this->orgId = $id;
        }

        return $match;
    }
}
