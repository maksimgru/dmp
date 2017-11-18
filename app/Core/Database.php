<?php

namespace Core;

/**
 * This is Description of Database class
 *
 */
class Database {

    public $database;

    public $errors;

    private static $dbInstance = null;

    /**
     * Description: Set DB config params and make new connect to DB
     *
     */
    private function __construct(){

        $dsn = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=UTF8';

        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

        try {
            $this->database = new \PDO($dsn, DB_USERNAME, DB_PASSWORD);
        } catch(\PDOException $ex) {
            $this->errors = $ex;
        }
    }

    /**
     * Description: Singleton instance of DB object connect.
     *
     */
    public static function connect(){
        if (!isset(self::$dbInstance)) {
            self::$dbInstance = new self();
        }

        return self::$dbInstance;
    }

    /**
     * Description:
     *
     */
    private function __clone() {} // prevent cloning

    /**
     * Description:
     *
     */
    private function __wakeup() {} // prevent unserialization
}