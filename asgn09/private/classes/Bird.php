<?php

class Bird
{
    private static PDO $database;

    public int $id = 0;
    public string $common_name = '';
    public string $scientific_name = '';
    public string $family_name = '';
    public string $primary_habitat = '';
    public string $seasonal_status = '';
    public string $description = '';

    public static function set_database(PDO $pdo): void
    {
        self::$database = $pdo;
    }

    public static function find_all(): array
    {
        $sql = "SELECT id, common_name, scientific_name, family_name,
                       primary_habitat, seasonal_status, description
                FROM birds
                ORDER BY common_name";

        $statement = self::$database->query($sql);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $birds = [];
        foreach ($rows as $row) {
            $birds[] = self::from_row($row);
        }

        return $birds;
    }

    public static function find_by_id(int $id): ?Bird
    {
        $sql = "SELECT id, common_name, scientific_name, family_name,
                       primary_habitat, seasonal_status, description
                FROM birds
                WHERE id = :id";

        $statement = self::$database->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return self::from_row($row);
    }

    public static function count_all(): int
    {
        $sql = "SELECT COUNT(*) FROM birds";
        $statement = self::$database->query($sql);
        return (int) $statement->fetchColumn();
    }

    /**
     * Insert this Bird object as a new row in the birds table.
     *
     * This is intentionally explicit for asgn09. Each object property maps
     * to one named placeholder in the INSERT statement. We are not building
     * a generic save() method yet because update/delete come in asgn10.
     */
    public function create(): bool
    {
        $sql = "INSERT INTO birds
                    (common_name, scientific_name, family_name,
                     primary_habitat, seasonal_status, description)
                VALUES
                    (:common_name, :scientific_name, :family_name,
                     :primary_habitat, :seasonal_status, :description)";

        // prepare() sends the SQL structure separately from the values.
        $statement = self::$database->prepare($sql);

        // bindValue() connects each placeholder to one property of this object.
        $statement->bindValue(':common_name', $this->common_name, PDO::PARAM_STR);
        $statement->bindValue(':scientific_name', $this->scientific_name, PDO::PARAM_STR);
        $statement->bindValue(':family_name', $this->family_name, PDO::PARAM_STR);
        $statement->bindValue(':primary_habitat', $this->primary_habitat, PDO::PARAM_STR);
        $statement->bindValue(':seasonal_status', $this->seasonal_status, PDO::PARAM_STR);
        $statement->bindValue(':description', $this->description, PDO::PARAM_STR);

        $result = $statement->execute();

        if ($result) {
            // MySQL creates the auto-increment ID. Save it back into this object
            // so bird_new.php can redirect to the new bird's detail page.
            $this->id = (int) self::$database->lastInsertId();
        }

        return $result;
    }

    private static function from_row(array $row): Bird
    {
        $bird = new self();
        $bird->id = (int) $row['id'];
        $bird->common_name = $row['common_name'];
        $bird->scientific_name = $row['scientific_name'];
        $bird->family_name = $row['family_name'];
        $bird->primary_habitat = $row['primary_habitat'];
        $bird->seasonal_status = $row['seasonal_status'];
        $bird->description = $row['description'];

        return $bird;
    }
}
