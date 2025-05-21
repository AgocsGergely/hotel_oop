<?php

namespace App\Database;

use App\Views\Display;
use Exception;

class Install extends Database
{

    function dbExists(): bool
    {
        try {
            $mysqli = self::getInstance();
            if (!$mysqli) {
                return false;
            }

            $query = sprintf("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '%s';", self::DEFAULT_CONFIG['database']);
            $result = $mysqli->execSql($query);

            
            count($result) > 0;

            return $result;

        }
        catch (Exception $e) {
            Display::message($e->getMessage(), 'error');
            error_log($e->getMessage());

            return false;
        }

    }

    public function createTable(string $tableBody, string $tableName,  string $dbName): bool
    {
        try {
            $sql = "
                CREATE TABLE `$dbName`.`$tableName`
                ($tableBody)
                ENGINE = InnoDB
                DEFAULT CHARACTER SET = utf8
                COLLATE = utf8_hungarian_ci;
            ";
            return (bool) $this->execSql($sql);

        } catch (Exception $e) {
            Display::message($e->getMessage(), 'error');
            error_log($e->getMessage());
            return false;
        }
    }

    function createTableRooms($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            CREATE TABLE rooms (
            id INT PRIMARY KEY AUTO_INCREMENT,
            floor INT,
            room_number INT,
            capacity INT,
            price INT,
            notes TEXT
        );
        ";

        return $this->createTable($tableBody, 'subjects',  $dbName);
    }
    function createTableGuests($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            CREATE TABLE guests (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name TEXT,
            age INT
        );";
        return $this->createTable($tableBody, "classes", $dbName);
    }

    function createTableReservations($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            CREATE TABLE reservations (
            id INT PRIMARY KEY AUTO_INCREMENT,
            room_id INT,
            guest_id INT,
            days INT,
            start_date DATE,
            FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
            FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE
        );";

        return $this->createTable($tableBody, "students", $dbName);
    }









}