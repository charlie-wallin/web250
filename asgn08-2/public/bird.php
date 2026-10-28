<?php

$bird = null;
$error_message = null;

try {
    require_once __DIR__ . '/../private/initialize.php';

    // filter_input validates the URL parameter, such as bird.php?id=5.
    // min_range rejects zero and negative IDs; 'abc' is also invalid.
    $id = $_GET['id'] ?? null;

    if ($id === null) {
        $error_message = 'Please use a valid positive integer bird ID.';
    } else {
        // The ID is valid syntax. Ask the model whether it exists.
        $bird = Bird::find_by_id($id);
        if ($bird === null) {
            // 404 = valid ID format, but there is no matching database row.
            http_response_code(404);
            $error_message = 'No bird was found with that ID.';
        }
    }
} catch (PDOException $exception) {
    http_response_code(500);
    error_log($exception->getMessage());
    $error_message = 'Could not load the bird details. Please try again later.';
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>asgn08 - Bird Details</title>
</head>

<body>
    <h1>Bird Details</h1>

    <?php if ($error_message !== null): ?>
        <p><?= h($error_message) ?></p>
    <?php else: ?>
        <!-- All seven properties of the one Bird object. -->
        <dl>
            <dt>Record ID</dt>
            <dd><?= (int) $bird->id ?></dd>
            <dt>Common name</dt>
            <dd><?= h($bird->common_name) ?></dd>
            <dt>Scientific name</dt>
            <dd><?= h($bird->scientific_name) ?></dd>
            <dt>Family</dt>
            <dd><?= h($bird->family_name) ?></dd>
            <dt>Primary habitat</dt>
            <dd><?= h($bird->primary_habitat) ?></dd>
            <dt>Seasonal status</dt>
            <dd><?= h($bird->seasonal_status) ?></dd>
            <dt>Description</dt>
            <dd><?= h($bird->description) ?></dd>
        </dl>
    <?php endif; ?>

    <p><a href="birds.php">Back to bird directory</a></p>
</body>

</html>