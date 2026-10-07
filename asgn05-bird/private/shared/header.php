<?php
if (!isset($page_title)) {
    $page_title = 'WNC Birds';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($page_title) ?></title>
</head>
<body>
<header>
    <h1>Western North Carolina Birds</h1>
    <nav aria-label="Primary navigation">
        <a href="index.php">Home</a> |
        <a href="birds.php">Birds</a> |
        <a href="about.php">About</a>
    </nav>
    <hr>
</header>
<main>
