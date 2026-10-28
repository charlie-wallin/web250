<?php
require_once __DIR__ . '/../private/initialize.php';

$birds = Bird::find_all();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bird Directory</title>
</head>
<body>
    <h1>Bird Directory</h1>

    <!-- asgn09: place the create link above the table at the top-left. -->
    <p><a href="bird_new.php">Create Bird</a></p>

    <?php if (count($birds) === 0) { ?>
        <p>No bird records were found.</p>
    <?php } else { ?>
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>Common Name</th>
                    <th>Scientific Name</th>
                    <th>Primary Habitat</th>
                    <th>Seasonal Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($birds as $bird) { ?>
                    <tr>
                        <td><?= h($bird->common_name) ?></td>
                        <td><?= h($bird->scientific_name) ?></td>
                        <td><?= h($bird->primary_habitat) ?></td>
                        <td><?= h($bird->seasonal_status) ?></td>
                        <td><a href="bird.php?id=<?= h((string) $bird->id) ?>">View details</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <p><a href="index.php">Back to asgn09 home</a></p>
</body>
</html>
