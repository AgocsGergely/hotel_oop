<?php

namespace App\Database;

use App\Views\Display;
use Error;
use Exception;
use PDO;

class Install extends Database
{

    private $pdo;
    private $dbName = 'hotel'; 

    

    public function createDatabase()
    {
        try {
            $this->execSql("CREATE DATABASE IF NOT EXISTS `{$this->dbName}`");

            /*$this->pdo->exec("
                CREATE TABLE IF NOT EXISTS classes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL
                )
            ")*/
            $this->createTableGuests();
            $this->createTableRooms();
            $this->createTableReservations();
            
            
            
            echo "<div style='color: green; text-align: center; font-size: 40px;'>Az adatbázis sikeresen létre lett hozva!</div>";
            return true;
        } catch (Exception $e) {
            error_log("Database creation failed: " . $e->getMessage());
            echo "Sikertelen létrehozás: ". $e->getMessage();
            return false;
        }
    }
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

    public function createTable(string $tableBody, string $tableName,  string $dbName = ""): bool
    {
        if(empty($dbName)) $dbName = $this->dbName;
        try {
            $sql = "
                CREATE TABLE IF NOT EXISTS `$dbName`.`$tableName`
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
            id INT PRIMARY KEY AUTO_INCREMENT,
            floor INT,
            room_number INT,
            capacity INT,
            price INT,
            notes TEXT
        ";

        return $this->createTable($tableBody, 'rooms',  $dbName);
    }
    function createTableGuests($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            name TEXT,
            age INT
        ";
        return $this->createTable($tableBody, "guests", $dbName);
    }

    function createTableReservations($dbName = self::DEFAULT_CONFIG['database']): bool
    {
        $tableBody = "
            id INT PRIMARY KEY AUTO_INCREMENT,
            room_id INT,
            guest_id INT,
            days INT,
            start_date DATE,
            FOREIGN KEY (room_id) REFERENCES rooms(id),
            FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE";

        return $this->createTable($tableBody, "reservations", $dbName);
    }









}