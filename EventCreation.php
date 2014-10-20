<?php
        include("Event.php");

        $description = $_POST['description'];
        $dateFrom = $_POST['dateFrom'];
        $title = $_POST['title'];

        /* Parsing posted form  */
        if(!isset($_POST['repeat']))
        {
            $newEvent = new Event();
            $sqldate = date('Y-m-d', strtotime($dateFrom));
            $newEvent->addARecurringEvent($title, $description, $sqldate, "NULL" , "NULL", "NULL","NULL" ,"NULL", "NULL");
        }
        else
        {
            $newEvent = new Event();
            $dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
            $dateEnd = date('Y-m-d', strtotime($_POST['dateEnd']));
            $repeats = $_POST['repeatType'];
            $repeatCycle = $_POST['repeatCount'];
            $repetitionType = $_POST['occurrenceType'];
            $numberOfOccurrences = $_POST['numberOfOccurrences'];

            $repetitionOnDays = $_POST['day'];
            $repetitionOnDays = array_map('intval', $repetitionOnDays);
            $repetitionOnDays = array_sum($repetitionOnDays);

            $newEvent->generateEvents($title,$description,$dateFrom, $repeats, $repeatCycle,$repetitionOnDays,
                $repetitionType,$numberOfOccurrences, $dateEnd );
        }

        /* After creating an event return to index */
        header('Location: /jobtask/index.php');


