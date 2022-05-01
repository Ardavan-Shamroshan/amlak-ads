<?php

namespace System\Database\DBConnection;

use PDO;
use PDOException;
use System\Config\Config;

class DBConnection {

    private static $dbConnectionInstance = null;

    /**
     * DBConnection constructor using singleton design pattern.
     */
    private function __construct() { }

    /**
     * Database Connection Instance using singleton design pattern.
     * @throws \Exception
     */
    public static function getDBConnectionInstance() {
        if (self::$dbConnectionInstance == null) {
            $DBConnectionInstance = new DBConnection();
            self::$dbConnectionInstance = $DBConnectionInstance->dbConnection();
        }
        return self::$dbConnectionInstance;
    }

    /**
     * Database Connection
     *
     * @return bool|PDO
     * @throws \Exception
     */
    private function dbConnection() {
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
        try {
            return new PDO("mysql:host=" . Config::get('database.DBHOST') . ";dbname=" . Config::get('database.DBNAME'), Config::get('database.DBUSERNAME'), Config::get('database.DBPASSWORD'), $options);
        } catch (PDOException $e) {
            echo "error in database connection: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Newly inserted record
     *
     * @return string
     * @throws \Exception
     */
    public static function newInsertId() {
        return self::getDBConnectionInstance()->lastInsertId();
    }
}