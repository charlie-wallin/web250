<?php

// Build paths from this file's location so the project behaves the same
// whether it is opened locally or uploaded to a Linux web host.
define('PRIVATE_PATH', __DIR__);
define('PROJECT_PATH', dirname(PRIVATE_PATH));
define('PUBLIC_PATH', PROJECT_PATH . '/public');

require_once PRIVATE_PATH . '/functions.php';

// Manual loading version used while testing class filenames:
// require_once PRIVATE_PATH . '/classes/parsecsv.class.php';
// require_once PRIVATE_PATH . '/classes/bird.class.php';

// Active version: autoloading. It removes the need to require each class by
// hand. On Linux hosts, the filename still has to match the expected case.
spl_autoload_register(function ($class_name) {
    $filename = strtolower($class_name) . '.class.php';
    $path = PRIVATE_PATH . '/classes/' . $filename;

    if (is_file($path)) {
        require_once $path;
    }
});
