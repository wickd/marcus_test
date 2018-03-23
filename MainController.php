<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {

        //Add Data to Donnor
        $donor = new Donor();
        $donor->setName('Foo Do');
        $donor->setBirthDay('27-08-93');
        $donor->setGender('m');
        $donor->setInterest('Musical');
        $donor->setInterest('Movies');


        //Add data to Owner

        $owner = new Owner();
        $owner->setName('Owner Name');
        $owner->setBirthDay('26-08-93');
        $owner->setGender('f');

        //Events add
        $event1 = new Event("Cool Night Out", "2016-03-11 17:00:00", "30m");
        $event2 = new Event("Lunch With Baz", "2016-04-22 12:30:00", "2h");

        //Org data
        $org = new Org();
        $org->setName('Baz Org');
        $org->setAddress('123 E Main St');
        $org->setOrgOwner($owner->name);
        $org->setOrgId('94fb868US');
        $org->addEvent($event1);
        $org->addEvent($event2);

//        $donor->attendEvent($event1);

        return  $this->printJson($donor);

    }

    public function printJson($object)
    {
        return json_encode($object);

    }
}





class Donor
{

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

    public function attendEvent($event)
    {
        $event->ends_at = '2016-04-22 12:30:00';
        $event->attendees[] = $this;
    }

    public function printJson()
    {
        return json_encode($this);

    }
}

class Owner extends Donor
{

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

}

class Event
{
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


class Org
{
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

    public function addEvent($events)
    {
        $this->upcoming_events[] = $events;
    }

    public function getNextEvent()
    {
        $foo = new Donor();

        //@todo Must get last event with ateendes
        $foo->attendEvent();
    }

    public function validateId($string)
    {
        $pattern = preg_match('/^(49|94)[a-zA-Z0-9]{5,6}[A-Z]{2}$/', $string);

        if ($pattern) {

            $this->orgId = $string;
        }

    }



}
