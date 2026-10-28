<?php

declare(strict_types=1);

/**
 * WEB-250 asgn08: Read-only Active Record model.
 *
 * One Bird object represents one row from the birds table.
 * The static methods retrieve bird records; the public properties hold
 * values belonging to a particular bird.
 */
final class Bird
{
    // Shared by the Bird class during this PHP request (not across requests).
    // The connection is supplied by initialize.php, not created here.
    private static ?PDO $database = null;

    // The seven columns required by the assignment.
    public int $id = 0;
    public string $common_name = '';
    public string $scientific_name = '';
    public string $family_name = '';
    public string $primary_habitat = '';
    public string $seasonal_status = '';
    public string $description = '';

    public static function set_database(PDO $pdo): void
    {
        // self::$database is a static CLASS property.
        // We do not need a separate database connection for each Bird object.
        self::$database = $pdo;
    }

    /** @return Bird[] An array of Bird objects; [] if there are no records. */
    public static function find_all(): array
    {
        // Fixed SQL has no input from the visitor, so query() is appropriate.
        $sql = 'SELECT id, common_name, scientific_name, family_name,
                       primary_habitat, seasonal_status, description
                FROM birds
                ORDER BY common_name';
        $statement = self::$database->query($sql);

        // FETCH_ASSOC gives us arrays like ['id' => 1, 'common_name' => ...].
        // They are not Bird objects yet.
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $birds = [];
        foreach ($rows as $row) {
            // Hydration: turn each associative array into a Bird object.
            // Reuse from_row() instead of assigning seven properties here.
            $birds[] = self::from_row($row);
        }

        return $birds;
    }

    public static function find_by_id(int $id): ?Bird
    {
        $sql = 'SELECT id, common_name, scientific_name, family_name,
                       primary_habitat, seasonal_status, description
                FROM birds
                WHERE id = :id';

        // The ID comes from a URL. Prepare and bind it rather than placing
        // the value directly into the SQL string.
        $statement = self::$database->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // fetch() returns ONE associative row, or false if no row matched.
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null; // The ID was valid, but that bird does not exist.
        }

        return self::from_row($row);
    }

    private static function from_row(array $row): Bird
    {
        // Both finders call this helper. This is the assignment's one
        // refactoring step: keep all row-to-object assignments in one place.
        $bird = new self();
        $bird->id = (int) $row['id']; // Database drivers may return IDs as strings.
        $bird->common_name = (string) $row['common_name'];
        $bird->scientific_name = (string) $row['scientific_name'];
        $bird->family_name = (string) $row['family_name'];
        $bird->primary_habitat = (string) $row['primary_habitat'];
        $bird->seasonal_status = (string) $row['seasonal_status'];
        $bird->description = (string) $row['description'];

        return $bird;
    }

    public static function count_all(): int
    {
        // COUNT(*) asks MySQL for the number of rows. Creating Bird objects
        // just to count them would perform unnecessary work.
        $statement = self::$database->query('SELECT COUNT(*) FROM birds');
        return (int) $statement->fetchColumn();
    }
}
