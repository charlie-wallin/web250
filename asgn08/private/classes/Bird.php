<?php

declare(strict_types=1);

/**
 * GRADED ASSIGNMENT STARTER. Implement the TODOs yourself.
 * This is a read-only slice of Active Record; saving records comes later.
 */
final class Bird
{
    private static ?PDO $database = null;

    public int $id = 0;
    public string $common_name = '';
    public string $scientific_name = '';
    public string $family_name = '';
    public string $primary_habitat = '';
    public string $seasonal_status = '';
    public string $description = '';

    public static function set_database(PDO $pdo): void
    {
        // TODO: Save the PDO connection in the static property.
        throw new LogicException('Implement Bird::set_database().');
    }

    /** @return Bird[] */
    public static function find_all(): array
    {
        // TODO: SELECT all birds, sorted by common_name. Return Bird objects.
        throw new LogicException('Implement Bird::find_all().');
    }

    public static function find_by_id(int $id): ?self
    {
        // TODO: Use a prepared statement; return a Bird or null.
        throw new LogicException('Implement Bird::find_by_id().');
    }

    // Refactoring task: both query methods should reuse this single mapper.
    private static function from_row(array $row): self
    {
        // TODO: Populate all seven properties and return the Bird object.
        throw new LogicException('Implement Bird::from_row().');
    }

    public static function count_all(): int
    {
        // TODO: Return the number of rows in birds (no hydration needed).
        throw new LogicException('Implement Bird::count_all().');
    }
}
