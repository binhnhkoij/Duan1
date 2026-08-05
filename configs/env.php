<?php

define('BASE_URL', 'http://localhost/duan/');
define('PATH_ROOT', __DIR__ . '/../');
define('PATH_VIEW', PATH_ROOT . 'views/');
define('PATH_VIEW_MAIN', PATH_ROOT . 'views/layouts/main.php');
define('PATH_CONTROLLER', PATH_ROOT . 'controllers/');
define('PATH_MODEL', PATH_ROOT . 'models/');
define('BASE_ASSETS', BASE_URL . 'assets/');
define('BASE_ASSETS_UPLOADS', BASE_ASSETS . 'uploads/');
define('PATH_ASSETS_UPLOADS', PATH_ROOT . 'assets/uploads/');

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'duan1');
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
