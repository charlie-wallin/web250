<?php
require_once __DIR__ . '/../private/initialize.php';

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
);

if ($id === null || $id === false) {
    http_response_code(400);
    exit('A valid bird ID is required.');
}

$bird = Bird::find_by_id($id);

if ($bird === null) {
    http_response_code(404);
    exit('Bird not found.');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= h($bird->common_name) ?></title>
</head>
<body>
    <h1><?= h($bird->common_name) ?></h1>

    <dl>
        <dt>ID</dt>
        <dd><?= h((string) $bird->id) ?></dd>

        <dt>Scientific name</dt>
        <dd><?= h($bird->scientific_name) ?></dd>

        <dt>Family name</dt>
        <dd><?= h($bird->family_name) ?></dd>

        <dt>Primary habitat</dt>
        <dd><?= h($bird->primary_habitat) ?></dd>

        <dt>Seasonal status</dt>
        <dd><?= h($bird->seasonal_status) ?></dd>

        <dt>Description</dt>
        <dd><?= h($bird->description) ?></dd>
    </dl>

    <p><a href="birds.php">Back to bird directory</a></p>
</body>
</html>
