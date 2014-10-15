<?php
/**
 * Created by PhpStorm.
 * User: Milos
 * Date: 15.10.2014
 * Time: 13:03
 */

class Database{

    public static function create_database()
    {
        $connection = mysqli_connect("localhost", "root", "");

        if(mysqli_connect_errno())
            echo "Failed to connect to MySQL " . mysqli_connect_error();

        $sql = "CREATE DATABASE calendar";

        if(mysqli_query($connection, $sql))
            echo "Database created successfully";
        else
            echo "Error creating database: " . mysqli_error($connection);

        mysqli_close($connection);
    }

    public static function create_table($database, $tableName)
    {
        $connection = mysqli_connect("localhost", "root", "", $database);

        if(mysqli_connect_errno())
            echo "Failed to connecto to MySQL " . mysqli_connect_error();

        $sql = "CREATE TABLE " . $tableName . "("
            .  "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, "
            .  "DESCRIPTION VARCHAR(300), "
            .  "START_DATE DATE NOT NULL, "
            .  "END_DATE DATE, "
            .  "REPETITION_TYPE ENUM('N-TIMES', 'UP_UNTIL', 'UNLIMITED'), "
            .  "RECCURING_TYPE ENUM('DAILY', 'WEEKLY', 'MWF', 'YEARLY'))";

        if(mysqli_query($connection, $sql))
            echo "Table created successfully";
        else
            echo "Error creating table: " . mysqli_error($connection);

        mysqli_close($connection);
    }
}