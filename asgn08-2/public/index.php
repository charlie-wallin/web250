<?php
$database_name = '';
$summary = [];
$error_message = null;

try {
    require_once __DIR__ . '/../private/initialize.php';

    $database_name = (string) $pdo->query('SELECT DATABASE()')->fetchColumn();
    // Only the birds count moved into the Bird model for asgn08.
    $bird_count = Bird::count_all();
    // The two image-related counts stay as they were in asgn07.
    $image_count = (int) $pdo->query('SELECT COUNT(*) FROM bird_images')->fetchColumn();
    $link_count = (int) $pdo->query('SELECT COUNT(*) FROM bird_image_links')->fetchColumn();

    $summary = [
        ['table_name' => 'birds', 'row_count' => $bird_count, 'purpose' => 'Species records'],
        ['table_name' => 'bird_images', 'row_count' => $image_count, 'purpose' => 'Image file metadata'],
        ['table_name' => 'bird_image_links', 'row_count' => $link_count, 'purpose' => 'Bird-to-image relationships'],
    ];
} catch (PDOException $exception) {
    http_response_code(500);
    error_log('asgn08 database error: ' . $exception->getMessage());
    $error_message = 'Database check failed. Check the server, credentials, and imported tables. See the local PHP error log for details.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>asgn08 - WNC Birds Database Check</title>
</head>
<body>
    <h1>WNC Birds Database Check</h1>

    <?php if ($error_message !== null): ?>
        <p><?= h($error_message) ?></p>
    <?php else: ?>
        <p>PDO connection and database queries: successful.</p>
        <p>Database: <?= h($database_name) ?></p>

        <table>
            <caption>Database record counts</caption>
            <thead>
                <tr>
                    <th scope="col">Table</th>
                    <th scope="col">Rows</th>
                    <th scope="col">Purpose</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary as $item): ?>
                    <tr>
                        <th scope="row"><?= h($item['table_name']) ?></th>
                        <td><?= h((string) $item['row_count']) ?></td>
                        <td><?= h($item['purpose']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>The image files are saved for a future assignment. The directory below displays species information.</p>
    <?php endif; ?>
    <h2>Explore</h2>
    <ul>
        <li><a href="birds.php">Bird directory</a></li>
        <li><a href="sandbox_active_record.php">Active Record sandbox</a></li>
    </ul>
</body>
</html>
