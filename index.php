<?php
    include("Database.php");
    include("Event.php");

    $newEvent = new Event();

   // $newEvent->addEvent("New Event", "2014-12-03", "NULL", "UNLIMITED", "DAILY");

    $newEvent->getEvent(1);
