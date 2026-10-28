# asgn08: Suggested live code walkthrough

This solution is AI-written for the instructor's class demonstration. It
follows the original assignment, not every refactoring in the LinkedIn Learning
videos. Start at the page and trace into the model. Students should predict
what happens before each breakpoint.

## 1. Start with the familiar index page

Open `public/index.php`. The birds count now calls `Bird::count_all()`; the
`bird_images` and `bird_image_links` counts stay as direct PDO queries. Ask:
"Why don't we have to fetch all Bird objects just to count them?"

## 2. Trace the initialization

Open `private/initialize.php`.

- `Database::connect()` returns the existing PDO connection.
- `Bird::set_database($pdo)` stores that object in the class's static property.
- A static model method can now access `self::$database` without creating a
  new PDO connection for every bird.

Breakpoints: `$pdo = Database::connect();` and `Bird::set_database($pdo);`.

## 3. Follow a directory request

Open `public/birds.php` and find `$birds = Bird::find_all();`. Step into the
model's `find_all()`.

- `query()` executes fixed SQL without user input.
- `fetchAll(PDO::FETCH_ASSOC)` returns an array of associative arrays.
- The loop calls `from_row()` once for each database row.
- `new self()` creates ONE object; assignments populate all seven properties.
- The final return gives `birds.php` an ARRAY of Bird objects.

Breakpoints: the `fetchAll` line; `$birds[] = self::from_row($row);` inside the
loop; `$bird = new self();` in `from_row()`; and `return $birds;`.

Have students inspect `$rows[0]`, `$row`, `$bird`, and `$birds` separately.
Then step into the page's `foreach` loop and observe escaped HTML output.

## 4. Follow one bird's detail link

Click a directory link. **This is a NEW HTTP request**, not a continuation of
the previous `birds.php` function call. In `public/bird.php`, a positive integer
ID is required. `Bird::find_by_id()` prepares the SQL and binds the user-supplied
ID as `PDO::PARAM_INT`. Its `fetch()` returns one row or `false`; a matching
row goes through the SAME `from_row()` helper.

Breakpoints: `filter_input(...)`, `Bird::find_by_id($id)`, `bindValue(...)`,
`$row = $statement->fetch(...)`, `return self::from_row($row);`.

Compare invalid `?id=abc` (HTTP 400) with valid-form but nonexistent
`?id=2147483647` (HTTP 404). Note that neither case is an exception.

## 5. Close with the boundaries of asgn08

- Model handles SQL and row-to-object conversion.
- Page handles HTML, navigation, ID validation and friendly error responses.
- `h()` handles OUTPUT escaping. A prepared statement handles SQL input;
  the two protections solve different problems.
- The SandboxBird teaching code stays separate and ungraded.
- No create/update/delete, frameworks, generic parent class, or image gallery.

## Before pressing F5

Verify there is only ONE `Listen for Xdebug` process on port 9003. If VS Code
says `listen EADDRINUSE: address already in use :::9003`, stop the competing
listener (possibly in another VS Code window); do not change the SQL or Bird
class to fix a port conflict.
