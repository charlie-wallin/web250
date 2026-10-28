<?php
class Database
{
    private static ?PDO $connection = null;
    public static function connect(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        } else {
            self::$connection = new PDO(
                $dsn = "mysql:host=" . DB_HOST . ";
                port=" . DB_PORT . ";
                dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
            return self::$connection;
        }
    }
}
