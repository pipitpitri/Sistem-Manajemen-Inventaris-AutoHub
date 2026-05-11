<?php

define('APP_NAME', 'Sistem Manajemen Inventaris TEFA Autohub');
define('APP_URL', '/');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'tefa_autohub_inventory');
define('DB_USER', 'root');
define('DB_PASS', '');
define('STOCK_MINIMUM_ALERT', 5);

spl_autoload_register(function ($class) {
    $directories = [
        __DIR__ . '/../app/core/',
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
