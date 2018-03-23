<?php

function dd($val) {
    echo var_dump($val);
    die;
}

class CanPrintJson {
    public function printJson() {
        $temp = [];
        $toarray = (array) $this;
        $hidden = $this->hidden;

        if($hidden && count($hidden)) {
            $temp = (object) array_filter($toarray, function($field) {
                return !in_array($field, $this->hidden) && $field != 'hidden';
            });
        } else {
            $temp = $this;
        }
        
        echo json_encode($temp) . "\n";
    }
}

class Person extends CanPrintJson {
    public $name;
    public $birthDate;
    public $gender;
    public $interests = [];

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setBirthDate($birth_day)
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

class Donor extends Person {
    public function attendEvent($event) {
        $event->ends_at = '2016-04-22 12:30:00';
        $event->attendees[] = $this;
    }
}

class Owner extends Person {}

class Org extends CanPrintJson {
    public $hidden = ['current_events_flag'];
    public $name;
    public $address;
    public $owner;
    public $org_id;
    public $current_events_flag = 0;
    public $upcoming_events = [];

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setOrgOwner($owner)
    {
        $this->owner = $owner->name;
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
        $event = $this->upcoming_events[$this->current_events_flag];
    
        $this->current_events_flag += 1;

        return $event;
    }

    public function validateId($id)
    {
        $match = preg_match('/^(49|94)[a-zA-Z0-9]{5,6}[A-Z]{2}$/', $id);

        if ($match) {
            $this->org_id = $id;
        }

        return $match;
    }
}

class Event extends CanPrintJson {
    public $hidden = [ 'ends_at', 'attendees', 'hidden' ];
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

$foo = new Donor();
$foo->setName('Foo Doe');
$foo->setBirthDate('1990-02-02');
$foo->setGender('m');
$foo->setInterest("Music");
$foo->setInterest("Movies");
$baz = new Owner();
$baz->setName('Baz Doe');
$baz->setBirthDate('1990-02-02');
$baz->setGender('m');
$event1 = new Event("Cool Night Out", "2016-03-11 17:00:00", "30m");
$event2 = new Event("Lunch With Baz", "2016-04-22 12:30:00", "2h");
$bar = new Org();
$bar->setName('Baz Org');
$bar->setAddress('123 E Main St');
$bar->setOrgOwner($baz);
$bar->setOrgId('9494949OR');
$bar->addEvent($event1);
$bar->addEvent($event2);
$foo->attendEvent($event1);
echo "This is Donor \n";
$foo->printJson();
echo "This is Owner \n";
$baz->printJson();
echo "This is Org \n";
$bar->printJson();
echo "This is Event \n";
$bar->getNextEvent()->printJson();
