<?php

// Initialize autoloader
require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/dependencies.php';

// Register routes
require __DIR__ . '/routes.php';
