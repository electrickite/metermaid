<?php
// Load environment from .env
$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
try {
  $dotenv->load();
} catch (InvalidArgumentException $e) {}

$debug = (strtolower(getenv('DEBUG')) == 'true');

// Configure application
return [
    'settings' => [
        'displayErrorDetails' => $debug,
        'addContentLengthHeader' => false,

        'db' => [
            'driver'    => getenv('DB_DRIVER') ?: 'sqlite',
            'database'  => getenv('DB_NAME') ?: dirname(__DIR__) . '/db/data.sqlite',
            'host'      => getenv('DB_HOST') ?: 'localhost',
            'username'  => getenv('DB_USER'),
            'password'  => getenv('DB_PASS'),
            'port'      => getenv('DB_PORT'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],
];
