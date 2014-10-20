<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 15.10.2014
 * Time: 15:20
 */


/* Responsible for creating an event or multuple events depending on the user's choice */
class Event {

    private $db;

    public function __construct()
    {
       $this->db = mysqli_connect("localhost", "root", "");

        if(mysqli_connect_errno())
            echo "Failed to connect to MySQL " . mysqli_connect_error();

        mysqli_select_db($this->db, "calendar");
    }

    /* function generates reccuring events or in case of unlimited event makes a single instance */
    public function generateEvents($title, $description, $startDate, $recurringType, $repetitionCycle,
                                   $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate)
    {
        if ($repetitionCycle == 0)
            $repetitionCycle = 1;

        $newDate = strtotime($startDate);

        /* RECURRING TYPE WEEKLY */
        if($recurringType == "WEEKLY")
        {
            /* Check if specific days are selected */
            if(!$repeatOnDays)
            {
                if($repetitionType == "N_TIMES")
                {
                    for($i = 0; $i < $noOfOccurrences; $i++)
                    {
                        $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                            $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                        $cycleDays = $repetitionCycle * 7;
                        $newDate = strtotime("+" . $cycleDays . "day", $newDate);
                    }
                }
                else if($repetitionType == "UP_UNTIL")
                {
                    while($newDate < strtotime($endDate))
                    {
                        $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                            $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                        $cycleDays = $repetitionCycle * 7;
                        $newDate = strtotime("+" . $cycleDays . "day", $newDate);
                    }
                }
                else if($repetitionType == "UNLIMITED")
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
            }
            else
            {
                $firstWeekday = array();

                $weekdays = $this->getDaysFromForm($repeatOnDays);
                $currentDate = strtotime($startDate);

                for($i = 0; $i < 7; $i++)
                {
                    for($j = 0; $j < count($weekdays); $j++)
                        if(date('l', $currentDate) == $weekdays[$j])
                            $firstWeekday[] = $currentDate;

                    $currentDate = strtotime("+1 day", $currentDate);
                }

                if($repetitionType == "N_TIMES")
                {
                    for($i = 0; $i < $noOfOccurrences; $i++)
                    {
                       for($j = 0; $j < count($firstWeekday); $j++)
                       {
                           $this->addARecurringEvent($title, $description, date('Y-m-d', $firstWeekday[$j]), $recurringType, $repetitionCycle,
                               $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                           $cycleDays = $repetitionCycle * 7;
                           $firstWeekday[$j] = strtotime("+" . $cycleDays . "day", $firstWeekday[$j]);
                       }
                    }
                }
                else if($repetitionType == "UP_UNTIL")
                {
                    while($firstWeekday[0] < strtotime($endDate))
                    {
                        for($j = 0; $j < count($firstWeekday); $j++)
                        {
                            $this->addARecurringEvent($title, $description, date('Y-m-d', $firstWeekday[$j]), $recurringType, $repetitionCycle,
                                $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                            $cycleDays = $repetitionCycle * 7;
                            $firstWeekday[$j] = strtotime("+" . $cycleDays . "day", $firstWeekday[$j]);
                        }
                    }
                }
                else if($repetitionType == "UNLIMITED")
                {
                    for($j = 0; $j < count($firstWeekday); $j++)
                    {
                        $this->addARecurringEvent($title, $description, date('Y-m-d', $firstWeekday[$j]), $recurringType, $repetitionCycle,
                            $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                        $cycleDays = $repetitionCycle * 7;
                        $firstWeekday[$j] = strtotime("+" . $cycleDays . "day", $firstWeekday[$j]);
                    }
                }
            }
        }

        /* RECURRING TYPE YEARLY */
        else if($recurringType == "YEARLY")
        {
            if($repetitionType == "N_TIMES")
            {
                for($i = 0; $i < $noOfOccurrences; $i++)
                {
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $newDate = strtotime("+" . $repetitionCycle . "year", $newDate);
                }
            }
            else if($repetitionType == "UP_UNTIL")
            {
                while($newDate < strtotime($endDate))
                {
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $newDate = strtotime("+" . $repetitionCycle . "year", $newDate);
                }
            }
            else if($repetitionType == "UNLIMITED")
                $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                    $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
        }

        /* RECURRING TYPE DAILY */
        else if($recurringType == "DAILY")
        {
            if($repetitionType == "N_TIMES")
            {
                for($i = 0; $i < $noOfOccurrences; $i++)
                {
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $newDate = strtotime("+" . $repetitionCycle . "day", $newDate);
                }
            }
            else if($repetitionType == "UP_UNTIL")
            {
                while($newDate < strtotime($endDate))
                {
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $newDate = strtotime("+" . $repetitionCycle . "day", $newDate);
                }
            }
            else if($repetitionType == "UNLIMITED")
                $this->addARecurringEvent($title, $description, date('Y-m-d', $newDate), $recurringType, $repetitionCycle,
                    $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );

        }

        /* RECURRING TYPE MONDAY - WEDNESDAY - FRIDAY */
        else if($recurringType == "MWF")
        {
            $currentDate = strtotime($startDate);
            for($i = 0; $i < 7; $i++)
            {
                if(date('D', $currentDate) == 'Mon')
                    $firstMonday = $currentDate;
                if(date('D', $currentDate) == 'Wed')
                    $firstWednesday = $currentDate;
                if(date('D', $currentDate) == 'Fri')
                    $firstFriday = $currentDate;

                $currentDate = strtotime("+1 day", $currentDate);
            }
            $nextMonday = $firstMonday;
            $nextWednesday = $firstWednesday;
            $nextFriday = $firstFriday;

            if($repetitionType == "N_TIMES")
            {

                for($i = 0; $i < $noOfOccurrences; $i++)
                {
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $nextMonday), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $nextWednesday), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $nextFriday), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );

                    $nextMonday = strtotime("+7 day", $nextMonday);
                    $nextWednesday = strtotime("+7 day", $nextWednesday);
                    $nextFriday = strtotime("+7 day", $nextFriday);
                }
            }
            else if($repetitionType == "UP_UNTIL")
            {
                while($nextMonday < strtotime($endDate) || $nextWednesday < strtotime($endDate) || $nextFriday < strtotime($endDate))
                {
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $nextMonday), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $nextWednesday), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                    $this->addARecurringEvent($title, $description, date('Y-m-d', $nextFriday), $recurringType, $repetitionCycle,
                        $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );

                    $nextMonday = strtotime("+7 day", $nextMonday);
                    $nextWednesday = strtotime("+7 day", $nextWednesday);
                    $nextFriday = strtotime("+7 day", $nextFriday);
                }
            }
            else if($repetitionType == "UNLIMITED")
            {
                $this->addARecurringEvent($title, $description, date('Y-m-d', $nextMonday), $recurringType, $repetitionCycle,
                    $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                $this->addARecurringEvent($title, $description, date('Y-m-d', $nextWednesday), $recurringType, $repetitionCycle,
                    $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
                $this->addARecurringEvent($title, $description, date('Y-m-d', $nextFriday), $recurringType, $repetitionCycle,
                    $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate );
            }
        }
    }


    /* Add a single recurring event */
    public function addARecurringEvent($title, $description, $startDate, $recurringType, $repetitionCycle,
                                       $repeatOnDays, $repetitionType, $noOfOccurrences, $endDate)
    {

        $sql = "INSERT INTO event (TITLE, DESCRIPTION, START_DATE, RECURRING_TYPE, REPETITION_CYCLE,
                    REPEAT_ON_DAYS, REPETITION_TYPE, No_OF_OCCURRENCES, END_DATE) VALUES("
            . "'" .$title . "',"
            . "'" .$description . "',"
            . "'" .$startDate. "',"
            . "'" .$recurringType. "',"
            . "'" .$repetitionCycle. "',"
            . "'" .$repeatOnDays. "',"
            . "'" .$repetitionType. "',"
            . "'" .$noOfOccurrences. "',"
            . "'" .$endDate . "');";

        if(mysqli_query($this->db, $sql))
            echo "Event added successfully";
        else
            echo "Error adding event " . mysqli_error($this->db);

    }

    /* Formatting and printing an event */
    public function printEvent($id)
    {

        $sql = "SELECT * FROM event WHERE ID = ".$id;
        $query = mysqli_query($this->db, $sql);
        $row = mysqli_fetch_array($query);

        printf("Title: %s<br /> Event description: %s<br /> Start date: %s<br />",
            $row["TITLE"], $row["DESCRIPTION"],date('M j, Y', strtotime($row['START_DATE'])));

        if($row["RECURRING_TYPE"] != null)
        {
            printf("Repeats: ");

            switch($row["RECURRING_TYPE"])
            {
                case "WEEKLY":
                    printf("weekly ");

                    if($row['REPEAT_ON_DAYS'] > 0)
                    {
                        $weekdays = $this->checkDays($id);
                        printf("on ");

                        if(!empty($weekdays))
                        {    for($i = 0; $i < count($weekdays); $i++)
                                if($i != count($weekdays) - 1)
                                    printf("%s, ", $weekdays[$i]);
                                else
                                    printf("%s.", $weekdays[$i]);
                        }
                    }
                    break;
                case "DAILY":
                    printf("daily ");
                    break;
                case "MWF":
                    printf("Monday - Wednesday - Friday ");
                    break;
                case "YEARLY":
                    printf("yearly ");
                    break;
            }

            if($row["REPETITION_CYCLE"] != null &&(int)$row["REPETITION_CYCLE"] > 1 )
            {
                printf("every %s ", $row["REPETITION_CYCLE"]);
                switch($row["RECURRING_TYPE"])
                {
                    case "WEEKLY":
                        printf("weeks ");
                        break;
                    case "DAILY":
                        printf("days ");
                        break;
                    case "YEARLY":
                        printf("years ");
                        break;
                }
            }

            if($row["REPETITION_TYPE"] == "N_TIMES")
                printf("%s times.",$row["No_OF_OCCURRENCES"]);

            else if($row["REPETITION_TYPE"] == "UP_UNTIL")
                printf("until %s", date('M j, Y', strtotime($row['END_DATE'])));

            printf("<br />");
        }
        printf("<br />");
    }

    /* Gets selected days from DB and then specifies which days are chosen */
    public function checkDays($id)
    {
        $sql = "SELECT * FROM event WHERE ID = ".$id;
        $query = mysqli_query($this->db, $sql);
        $row = mysqli_fetch_array($query);

        $repeatOnDays = $row['REPEAT_ON_DAYS'];
        $counter = 1;
        $weekdays = array();

        while($repeatOnDays)
        {

            if($repeatOnDays & 1)
            {
               switch($counter)
               {
                   case 7: $weekdays[] = "Monday"; break;
                   case 6: $weekdays[] = "Tuesday"; break;
                   case 5: $weekdays[] = "Wednesday"; break;
                   case 4: $weekdays[] = "Thursday"; break;
                   case 3: $weekdays[] = "Friday"; break;
                   case 2: $weekdays[] = "Saturday"; break;
                   case 1: $weekdays[] = "Sunday"; break;
               }
            }

            $repeatOnDays = $repeatOnDays >> 1;
            $counter++;
        }

        return array_reverse($weekdays);
    }

    /* Gets selected days from form and then specifies which */
    public function getDaysFromForm($daysInInt)
    {
        $counter = 1;
        $weekdays = array();

        while($daysInInt)
        {

            if($daysInInt & 1)
            {
                switch($counter)
                {
                    case 7: $weekdays[] = "Monday"; break;
                    case 6: $weekdays[] = "Tuesday"; break;
                    case 5: $weekdays[] = "Wednesday"; break;
                    case 4: $weekdays[] = "Thursday"; break;
                    case 3: $weekdays[] = "Friday"; break;
                    case 2: $weekdays[] = "Saturday"; break;
                    case 1: $weekdays[] = "Sunday"; break;
                }
            }

            $daysInInt = $daysInInt >> 1;
            $counter++;
        }

        return array_reverse($weekdays);
    }


    /* When a time period is selected return dates in that time period */
    public function getEventsForPeriod($dateFrom, $dateTo)
    {

        $sql = "SELECT * FROM event ORDER BY START_DATE ASC ";
        $query = mysqli_query($this->db, $sql);

        while($row = mysqli_fetch_array($query))
        {
            if($row['REPETITION_TYPE'] == "UNLIMITED")
            {
                $this->checkUnlimitedEvents($dateFrom, $dateTo);
                if(strtotime($dateFrom) <= strtotime($row['START_DATE']) && strtotime($dateTo) >= strtotime($row['START_DATE']))
                {

                    $this->printEventsByTitle($row['TITLE'],$row['START_DATE']);
                }
            }
            else if(strtotime($dateFrom) <= strtotime($row['START_DATE']) && strtotime($dateTo) >= strtotime($row['START_DATE']))
                $this->printEvent($row['ID']);
        }
    }

    /* Checks unlimited events in db and generates the future occurrences in that time frame */
    public function checkUnlimitedEvents($dateFrom, $dateTo)
    {
        $sql = "SELECT * FROM event WHERE REPETITION_TYPE = 'UNLIMITED'";
        $query = mysqli_query($this->db, $sql);
        while($row = mysqli_fetch_array($query))
        {
            $newDate = $row['START_DATE'];
            $newDate = strtotime($newDate);
            $repetitionCycle = "";

            switch($row['RECURRING_TYPE'])
            {
                case "WEEKLY" :
                    $repetitionCycle = "+" . (7 * $row['REPETITION_CYCLE']) . " day";
                    break;
                case "MWF" :
                    $repetitionCycle = "+" . (7 * $row['REPETITION_CYCLE']) . " day";
                    break;
                case "YEARLY" :
                    $repetitionCycle = "+" . $row['REPETITION_CYCLE'] . " year";
                    break;
                case "DAILY" :
                    $repetitionCycle = "+" . $row['REPETITION_CYCLE'] . " day";
                    break;
            }

            while(1)
            {
                if(strtotime($dateFrom) > $newDate)
                   $newDate = strtotime($repetitionCycle, $newDate);

                elseif(strtotime($dateTo) < $newDate)
                   break;

                else if(strtotime($dateFrom) <= $newDate && strtotime($dateTo) >= $newDate)
                {
                    if($newDate == strtotime($row['START_DATE']))
                        $newDate = strtotime($repetitionCycle, $newDate);

                    else
                    {
                        if($this->checkDuplicates($row['TITLE'], date('Y-m-d', $newDate)))
                            break;

                        else{
                                $this->addOneTimeEvent($row['TITLE'], $row['DESCRIPTION'], date('Y-m-d', $newDate),
                                $row['RECURRING_TYPE'], $row['REPETITION_CYCLE'], $row['REPEAT_ON_DAYS'], $row['REPETITION_TYPE'],
                                $row['No_OF_OCCURRENCES'], $row['END_DATE']);
                                $this->printEventsByTitle($row['TITLE'], date('Y-m-d', $newDate));
                                $newDate = strtotime($repetitionCycle, $newDate);
                        }
                    }
                }

            }

        }

    }


    /* Prints events with a certain title and date to avoid duplicates */
    public function printEventsByTitle($title, $startDate)
    {
        $sql = "SELECT ID FROM event WHERE TITLE = '".$title . "' AND " . "START_DATE = '" . $startDate . "'";
        $query = mysqli_query($this->db, $sql);
        $row = mysqli_fetch_array($query);

        $this->printEvent($row['ID']);
    }

    /* Checking for duplicate entries in DB */
    public function checkDuplicates($title, $startDate)
    {
        $sql = "SELECT * FROM event WHERE TITLE = '" . $title . "' AND START_DATE = '" . $startDate . "'";
        $query = mysqli_query($this->db, $sql);

        if(mysqli_num_rows($query) == 0)
            return false;
        else
            return true;
    }


    public function __destruct()
    {
        mysqli_close($this->db);
    }
} 