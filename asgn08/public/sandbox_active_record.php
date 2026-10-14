<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/private/initialize.php';
require_once dirname(__DIR__) . '/private/classes/SandboxBird.php';

try {
    // Use the existing asgn07 Database connection class and credentials.
    $pdo = (isset($pdo) && $pdo instanceof PDO) ? $pdo : Database::connect();
    SandboxBird::set_database($pdo);
    $birds = SandboxBird::find_all();
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Could not load the bird sandbox. Check the database connection.');
}

// Escape data before inserting it into HTML.
function sandbox_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Active Record Sandbox</title>
</head>
<body>
    <h1>Active Record Sandbox</h1>
    <p>SandboxBird objects returned: <?= count($birds) ?></p>

    <?php if (count($birds) === 0): ?>
        <p>No bird records were found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($birds as $bird): ?>
                <li>
                    <?= sandbox_h($bird->common_name) ?>
                    (ID <?= $bird->id ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
