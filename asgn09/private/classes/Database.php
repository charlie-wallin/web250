<?php

class Database
{
    private static ?PDO $database = null;

    public static function connect(): PDO
    {
        if (self::$database instanceof PDO) {
            return self::$database;
        }

        $dsn = 'mysql:host=' . DB_HOST
            . ';port=' . DB_PORT
            . ';dbname=' . DB_NAME
            . ';charset=utf8mb4';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        self::$database = new PDO($dsn, DB_USER, DB_PASS, $options);
        return self::$database;
    }
}
