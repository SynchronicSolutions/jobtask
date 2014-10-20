<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 15.10.2014
 * Time: 13:03
 */

class Database{

    /* Creates a database if it doesn't exist */
    public static function create_database()
    {
        $connection = mysqli_connect("localhost", "root", "");

        if(mysqli_connect_errno())
            echo "Failed to connect to MySQL " . mysqli_connect_error();

        $sql = "CREATE DATABASE IF NOT EXISTS calendar";

        if(!mysqli_query($connection, $sql))
            echo "Error creating database: " . mysqli_error($connection);

        mysqli_close($connection);
    }
    /* Creates a table if it doesn't exist */
    public static function create_table($database, $tableName)
    {
        $connection = mysqli_connect("localhost", "root", "", $database);

        if(mysqli_connect_errno())
            echo "Failed to connecto to MySQL " . mysqli_connect_error();

        $sql = "CREATE TABLE IF NOT EXISTS " . $tableName . "("
            .  "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, "
            .  "TITLE VARCHAR(50), "
            .  "DESCRIPTION VARCHAR(300), "
            .  "START_DATE DATE NOT NULL, "
            .  "RECURRING_TYPE ENUM('DAILY', 'WEEKLY', 'MWF', 'YEARLY'), "
            .  "REPETITION_CYCLE INT, "
            .  "REPEAT_ON_DAYS INT, "
            .  "REPETITION_TYPE ENUM('N-TIMES', 'UP_UNTIL', 'UNLIMITED'), "
            .  "No_OF_OCCURRENCES INT, "
            .  "END_DATE DATE);";

        if(!mysqli_query($connection, $sql))
            echo "Error creating table: " . mysqli_error($connection);

        mysqli_close($connection);
    }

    public static function drop_table($database, $tableName)
    {
        $connection = mysqli_connect("localhost", "root", "", $database);

        if(mysqli_connect_errno())
            echo "Failed to connect to to MySQL " . mysqli_connect_error();
        $sql = "DROP TABLE " . $tableName. ";";

         if(mysqli_query($connection, $sql))
             echo "Table dropped successfully";
         else
             echo "Error dropping table: " . mysqli_error($connection);

        mysqli_close($connection);
    }
}