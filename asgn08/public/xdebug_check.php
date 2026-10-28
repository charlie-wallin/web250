<?php

echo "<pre>";

echo "PHP version: " . PHP_VERSION . "\n";
echo "PHP configuration: " . php_ini_loaded_file() . "\n";

echo "Xdebug loaded: ";
echo extension_loaded('xdebug') ? "YES\n" : "NO\n";

echo "Xdebug mode: " . ini_get('xdebug.mode') . "\n";
echo "Start with request: " . ini_get('xdebug.start_with_request') . "\n";
echo "Client host: " . ini_get('xdebug.client_host') . "\n";
echo "Client port: " . ini_get('xdebug.client_port') . "\n";

echo "</pre>";
echo "<p>Debugger connected: ";
echo xdebug_is_debugger_active() ? "YES" : "NO";
echo "</p>";

xdebug_info();
