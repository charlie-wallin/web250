<?php

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        // Part 5: build the DSN, create a PDO object, and return it.
        // Replace the exception below with your completed code.
        throw new LogicException('Complete Database::connect() in Part 5.');
    }
}
