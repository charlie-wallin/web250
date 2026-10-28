<?php

declare(strict_types=1);

/**
 * UNGRADED GUIDED SANDBOX.
 * A tiny read-only Active Record example using the asgn07 birds table.
 * This class is intentionally smaller than the Bird class in the assignment.
 */
final class SandboxBird
{
    private static ?PDO $database = null;

    public int $id = 0;
    public string $common_name = '';

    // Static: one database connection reference shared by this class per request.
    public static function set_database(PDO $pdo): void
    {
        self::$database = $pdo;
    }

    /** @return SandboxBird[] */
    public static function find_all(): array
    {
        if (self::$database === null) {
            throw new RuntimeException('Call set_database() before find_all().');
        }

        // No user input is used in this fixed SQL statement.
        $sql = 'SELECT id, common_name FROM birds ORDER BY common_name';
        $statement = self::$database->query($sql);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $birds = [];
        foreach ($rows as $row) {
            // Hydration: turn one associative row into one PHP object.
            $bird = new self();
            $bird->id = (int) $row['id'];
            $bird->common_name = (string) $row['common_name'];
            $birds[] = $bird;
        }

        return $birds;
    }
}
