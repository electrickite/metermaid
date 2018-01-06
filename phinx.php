<?php

$settings = require __DIR__ . '/src/settings.php';
$db = $settings['settings']['db'];

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds'      => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'database',
        'database' => [
            'adapter' => $db['driver'],
            'name'    => $db['database'],
            'host'    => $db['host'],
            'user'    => $db['username'],
            'pass'    => $db['password'],
            'port'    => $db['port'],
            'charset' => $db['charset'],
        ]
    ],
    'version_order' => 'creation',
];
