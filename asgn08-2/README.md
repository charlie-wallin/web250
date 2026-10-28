# WEB-250 asgn08 - Active Record Directory (instructor solution)

**Code prepared by ChatGPT (GPT-6) for instructor demonstration.**
This is a solution to the original `asgn08_active_record_directory.md`.
It intentionally does not add CRUD, a framework, a base ActiveRecord class,
image galleries, or `.env` configuration. The ungraded SandboxBird example is
unchanged from the asgn08 starter.

## Before running

- The `wnc_birds` database and its `birds`, `bird_images`, and
  `bird_image_links` tables already exist from asgn07. Do not replace or drop
  existing student data. This ZIP does not include a database import.
- **Do not overwrite your working `private/db_credentials.php`.** For a fresh
  installation, copy `private/db_credentials.php.example` to
  `private/db_credentials.php` and edit it with YOUR working asgn07 MySQL
  settings. The actual credentials file is intentionally not included.
- `Database.php` uses the same `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and
  `DB_PASS` constants from the earlier asgn07 solution. MAMP's Apache port,
  MySQL port, and Xdebug's 9003 port are three separate settings.
- Keep your asgn07 project untouched. Place the new asgn08 folder alongside it.
  If you already have an asgn08 folder, extract the solution somewhere else and
  compare/copy the edited PHP files rather than replacing your project wholesale.

## Open in the browser

With MAMP running, open the URL corresponding to your actual Apache port,
for example:

- `http://localhost:55000/web250/asgn08/public/index.php`
- `http://localhost:55000/web250/asgn08/public/sandbox_active_record.php`
- `http://localhost:55000/web250/asgn08/public/birds.php`
- Follow any `View details` link to `bird.php?id=...`.

## Where to look during the demonstration

1. `public/index.php`: the database summary is still present. Only the birds
   count uses `Bird::count_all()`; image and image-link counts remain direct SQL.
2. `private/initialize.php`: load configuration, create/reuse ONE PDO
   connection, call `Bird::set_database($pdo)`.
3. `private/classes/Bird.php`: the seven properties and exactly five assigned
   methods: `set_database`, `find_all`, `find_by_id`, `from_row`, `count_all`.
4. `public/birds.php`: one `Bird::find_all()` call; objects are displayed in a
   table; the details link uses the object's real integer ID.
5. `public/bird.php`: validate a positive integer, get one object, show seven
   fields, and return friendly 400/404 cases.

**The refactoring (two sentences):** `find_all()` and `find_by_id()` both use
`from_row()` instead of repeating seven property assignments. The index uses
`Bird::count_all()` for the birds total, keeping bird-specific SQL in the model
without changing the image-related queries.

## Verification

- Original seed: sandbox and bird directory show 8 birds (if unchanged).
- Directory is sorted alphabetically by common name.
- `bird.php?id=<id from directory>` shows all seven fields.
- `bird.php` / `bird.php?id=abc` / `?id=0` return an HTTP 400 page.
- `bird.php?id=2147483647` returns HTTP 404 if that ID doesn't exist.
- When the table is empty, the directory says no bird records were found.
- All database-sourced strings are escaped using `h()`.
- DB failures log technical details and display a neutral message (HTTP 500).

## Source control, webhost and Moodle

This archive is NOT a Git repository and has NOT been pushed or deployed.
The original assignment requires work on `dev-active-record`, meaningful
commits, both branches pushed, and a merge into `main`. Keep credentials out
of GitHub; `.gitignore` prevents NEW credentials files from being staged, but
cannot untrack a file that Git already tracks. Deploy under `web250/asgn08`,
protect `private/` from direct requests, and update the course-level web250
index with a link to the asgn08 index. Test the hosted pages and share both
GitHub and live webhost URLs in Moodle Comments.

The debugger setup is a separate assignment with a separate grade. The
included `.vscode/launch.json` is just a reusable listener. If you see
`EADDRINUSE :::9003`, stop the earlier listener in another VS Code window
before starting a new one.
