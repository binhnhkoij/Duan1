<?php
session_start();

require_once __DIR__ . '/configs/env.php';
require_once __DIR__ . '/configs/helper.php';

spl_autoload_register(function (string $class): void {
    foreach ([PATH_MODEL, PATH_CONTROLLER] as $folder) {
        $file = $folder . $class . '.php';
        if (is_readable($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/routes/index.php';
