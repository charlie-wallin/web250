<?php
require_once __DIR__ . '/../private/initialize.php';

// The same page handles two requests:
// GET  -> show the empty form.
// POST -> build a Bird object from the submitted values and insert it.
$bird = new Bird();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bird->common_name = trim($_POST['common_name'] ?? '');
    $bird->scientific_name = trim($_POST['scientific_name'] ?? '');
    $bird->family_name = trim($_POST['family_name'] ?? '');
    $bird->primary_habitat = trim($_POST['primary_habitat'] ?? '');
    $bird->seasonal_status = trim($_POST['seasonal_status'] ?? '');
    $bird->description = trim($_POST['description'] ?? '');

    if ($bird->create()) {
        // create() stores MySQL's new auto-increment ID in $bird->id.
        // Redirect after a successful POST so refreshing the detail page does
        // not submit the form again and create a duplicate record.
        header('Location: bird.php?id=' . $bird->id);
        exit;
    }

    $error = 'The bird record could not be created.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Bird</title>
</head>
<body>
    <h1>Create Bird</h1>

    <?php if ($error !== '') { ?>
        <p><?= h($error) ?></p>
    <?php } ?>

    <form action="bird_new.php" method="post">
        <p>
            <label for="common_name">Common name</label><br>
            <input type="text" id="common_name" name="common_name"
                   value="<?= h($bird->common_name) ?>" required>
        </p>

        <p>
            <label for="scientific_name">Scientific name</label><br>
            <input type="text" id="scientific_name" name="scientific_name"
                   value="<?= h($bird->scientific_name) ?>" required>
        </p>

        <p>
            <label for="family_name">Family name</label><br>
            <input type="text" id="family_name" name="family_name"
                   value="<?= h($bird->family_name) ?>" required>
        </p>

        <p>
            <label for="primary_habitat">Primary habitat</label><br>
            <input type="text" id="primary_habitat" name="primary_habitat"
                   value="<?= h($bird->primary_habitat) ?>" required>
        </p>

        <p>
            <label for="seasonal_status">Seasonal status</label><br>
            <input type="text" id="seasonal_status" name="seasonal_status"
                   value="<?= h($bird->seasonal_status) ?>" required>
        </p>

        <p>
            <label for="description">Description</label><br>
            <textarea id="description" name="description" rows="6" cols="60" required><?= h($bird->description) ?></textarea>
        </p>

        <p><button type="submit">Create Bird</button></p>
    </form>

    <p><a href="birds.php">Cancel and return to bird directory</a></p>
</body>
</html>
