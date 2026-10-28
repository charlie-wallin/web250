<?php
require_once __DIR__ . '/../private/initialize.php';

$bird_count = Bird::count_all();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WEB-250 asgn09</title>
</head>
<body>
    <h1>WEB-250 asgn09 - Create a Record</h1>

    <p>Bird records in the database: <?= h((string) $bird_count) ?></p>

    <ul>
        <li><a href="birds.php">Bird directory</a></li>
        <li><a href="bird_new.php">Create Bird</a></li>
    </ul>
</body>
</html>
