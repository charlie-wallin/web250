<?php
require_once __DIR__ . '/../private/initialize.php';

$birds = [];
$error_message = null;

try {

    // The page asks the model for objects. No SQL belongs in this file.
    $birds = Bird::find_all();
} catch (PDOException $exception) {
    http_response_code(500);
    error_log($exception->getMessage());
    $error_message = 'Could not load the bird directory. Please try again later.';
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>asgn08 - WNC Bird Directory</title>
</head>

<body>
    <h1>WNC Bird Directory</h1>

    <?php if ($error_message !== null): ?>
        <p><?= h($error_message) ?></p>
    <?php elseif ($birds === []): ?>
        <p>No bird records were found.</p>
    <?php else: ?>
        <table>
            <caption>Bird species of western North Carolina</caption>
            <thead>
                <tr>
                    <th scope="col">Common name</th>
                    <th scope="col">Scientific name</th>
                    <th scope="col">Primary habitat</th>
                    <th scope="col">Seasonal status</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($birds as $bird): ?>
                    <tr>
                        <!-- h() escapes text before it is placed into HTML. -->
                        <td><?= h($bird->common_name) ?></td>
                        <td><?= h($bird->scientific_name) ?></td>
                        <td><?= h($bird->primary_habitat) ?></td>
                        <td><?= h($bird->seasonal_status) ?></td>
                        <!-- Use the actual database ID, not the loop position. -->
                        <td><a href="bird.php?id=<?= (int) $bird->id ?>">View details</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="index.php">Back to asgn08 home</a></p>
</body>

</html>