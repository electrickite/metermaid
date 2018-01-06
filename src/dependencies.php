<?php
// DIC configuration

$container = $app->getContainer();

// Service factory for the ORM
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    return $capsule;
};

$container['db']->setAsGlobal();
$container['db']->bootEloquent();
