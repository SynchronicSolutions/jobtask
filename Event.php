<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 15.10.2014
 * Time: 15:20
 */

class Event {

    private $db;
    private $id;
    private $description;
    private $startDate;
    private $endDate;
    private $repetitionType;
    private $recurringType;

    public function __construct()
    {
       $this->db = mysqli_connect("localhost", "root", "");

        if(mysqli_connect_errno())
            echo "Failed to connect to MySQL " . mysqli_connect_error();

        mysqli_select_db($this->db, "calendar");
    }

    public function getEvent($id)
    {

        $sql = "SELECT * FROM event WHERE ID = " . $id;
        $query = mysqli_query($this->db, $sql);

        $row = mysqli_fetch_array($query);
        echo  $row["DESCRIPTION"] . ", "
            . $row["START_DATE"] . ", "
            . $row["END_DATE"] . ", "
            . $row["REPETITION_TYPE"] . ", "
            . $row["RECCURING_TYPE"];

    }

    public function addEvent($description, $startDate, $endDate, $repetitionType, $recurringType)
    {
        $sql = "INSERT INTO event (DESCRIPTION, START_DATE, END_DATE, REPETITION_TYPE, RECCURING_TYPE) VALUES("
              . "'" . $description . "',"
              . "'" .$startDate. "',"
              . "'" .$endDate. "',"
              . "'" .$repetitionType. "',"
              . "'" .$recurringType. "');";


     if(mysqli_query($this->db, $sql))
            echo "Event added successfully";
        else
            echo "Error adding event " . mysqli_error($this->db);
    }

    public function __destruct()
    {
        mysqli_close($this->db);
    }
} 