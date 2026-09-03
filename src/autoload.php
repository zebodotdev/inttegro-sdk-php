<?php

spl_autoload_register(function ($class) {
    $prefix = 'Inttegro\\';
    $baseDir = __DIR__ . '/Inttegro/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require_once __DIR__ . '/Inttegro/Errors.php';
require_once __DIR__ . '/Inttegro/Enums.php';
require_once __DIR__ . '/Inttegro/Domain.php';
