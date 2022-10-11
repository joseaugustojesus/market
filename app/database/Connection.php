<?php

namespace app\database;

use PDO;
use PDOException;

class Connection
{

    private static $instance;


    public static function instance()
    {
        $host = LOCAL_DATABASE_HOST;
        $databaseName = LOCAL_DATABASE_DBNAME;
        $username = LOCAL_DATABASE_USERNAME;
        $passwd = LOCAL_DATABASE_PASSWORD;

        if (!self::$instance) {
            self::$instance = new PDO("mysql:host={$host};dbname={$databaseName}", $username, $passwd, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }
        return self::$instance;
    }
}
