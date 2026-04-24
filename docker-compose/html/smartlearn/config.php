<?php


// Charge les variables du fichier .env
$envPath = '.env';

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with($line, '#')) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}


return [
    'database' => [
        'dbname' => $_ENV['DB_NAME'] ?? '',
        'username' => $_ENV['DB_USER'] ?? '',
        'password' => $_ENV['DB_PASS'] ?? '',
        'connection' => 'mysql:host=aw_db',
        'port' => '3306',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    ],
    'APP_ENV' => $_ENV['APP_ENV'] ?? 'prod',
    'CSS_PATH' => 'public/css/',
    'IMG_PATH' => 'public/img/',
    'JS_PATH' => 'public/js/',
    'FAVICON_PATH' => 'public/img/favicon/',
    'install_prefix' => 'smartlearn',
];
