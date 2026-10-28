<?php

class Database
{
    // The class holds one connection for this PHP request.
    // ?PDO allows either a PDO object or null (not connected yet).
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        // Reuse the connection if this request has already created one.
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        // The DSN identifies the database driver, server, port, and database.
        $dsn = 'mysql:host=' . DB_HOST
            . ';port=' . DB_PORT
            . ';dbname=' . DB_NAME
            . ';charset=utf8mb4';

        self::$connection = new PDO(
            $dsn,
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
