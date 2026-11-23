<?php
ob_start();
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

$routes = [
    'dashboard'   => __DIR__ . '/views/dashboard.php',
    'home'        => __DIR__ . '/views/home.php',
    'profile'     => __DIR__ . '/views/profile.php',
    'contact'     => __DIR__ . '/views/contact.php',
    'user/list'   => __DIR__ . '/modules/user/list.php',
    'user/add'    => __DIR__ . '/modules/user/add.php',
    'user/edit'   => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',
    'auth/login'  => __DIR__ . '/modules/auth/login.php',
    'auth/logout' => __DIR__ . '/modules/auth/logout.php',
];

$page = $_GET['page'] ?? 'dashboard';

if (!is_string($page) || !isset($routes[$page])) {
    http_response_code(404);
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $contentFile = $routes[$page];
}

require __DIR__ . '/views/header.php';
require $contentFile;
require __DIR__ . '/views/footer.php';
