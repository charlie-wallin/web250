# WEB-250 asgn07 - WNC Birds Database Check

## Part 9 - Explain the design

### 1. Why use three tables?

One bird can have many images, and the same image can be associated with more than one bird. The `bird_image_links` junction table supports both directions; a single `bird_id` in `bird_images` would allow only one bird per image.

### 2. What happens when a bird is deleted?

Deleting a species removes its rows from `bird_image_links` because of `ON DELETE CASCADE`. It does not remove records from `bird_images` or delete any physical JPEG files from `public/images/birds/`.

### 3. What is in the DSN, and why is the connection static?

The PDO DSN includes the MySQL driver, host, database port, database name, and character set. The static `Database::$connection` property lets `connect()` reuse one PDO connection within the same PHP request.

### 4. How do `query()` and `fetchColumn()` differ?

`query()` executes the fixed SQL statement and returns a `PDOStatement`. `fetchColumn()` reads one value from the statement's result, such as the value returned by `COUNT(*)`.

## Database counts

The supplied seed-only database should report:

| Table | Count |
|---|---:|
| `birds` | 8 |
| `bird_images` | 17 |
| `bird_image_links` | 18 |

If existing records are present, counts will be higher.

## Testing notes

- Import the supplied `sql/wnc_birds.sql` twice. The three seed-only totals should remain 8, 17, and 18.
- Temporarily set `DB_NAME` to a nonexistent database: the page should show its generic connection-error message, while the details appear in the PHP error log.
- Restore `DB_NAME` to `wnc_birds`; the working table should reappear.

These are the expected results. Actual MySQL connection and re-import testing should be completed locally.
