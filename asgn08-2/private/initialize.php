<?php

// One shared initialization file is used by the pages under public/.
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db_credentials.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Bird.php';

// Reuse the asgn07 PDO connection. Give the SAME PDO object to Bird.
// Bird's finder methods can now run queries without making new connections.
$pdo = Database::connect();
Bird::set_database($pdo);
