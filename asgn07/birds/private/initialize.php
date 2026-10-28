<?php

// __DIR__ is this file's directory, independent of the working directory.
// Load files explicitly. Autoloading and callbacks are not used in asgn07.
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db_credentials.php';
require_once __DIR__ . '/classes/Database.php';

// Do not connect here. index.php connects inside its try/catch block.
