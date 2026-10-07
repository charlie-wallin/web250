<?php
require_once '../private/initialize.php';
$page_title = 'WNC Bird Challenge';
include PRIVATE_PATH . '/shared/header.php';
?>

<h2>Bird Challenge</h2>
<p>
    This project reads a pipe-delimited CSV file, creates Bird objects, and
    displays the data using object methods.
</p>
<ul>
    <li><a href="birds.php">View the bird inventory</a></li>
    <li><a href="about.php">About this instructor solution</a></li>
</ul>

<?php include PRIVATE_PATH . '/shared/footer.php'; ?>
