<?php 

namespace test;

use Person;

class Donor extends Person {
    public function attendEvent($event)
    {
        $event->ends_at = '2016-04-22 12:30:00';
        $event->attendees[] = $this;
    }
}