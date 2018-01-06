<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Meter;
use App\Model\Reading;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->write('Hello, world!');
});

$app->get('/meters', function (Request $request, Response $response, array $args) {
    $meters = Meter::all();
    return $response->withJson($meters);
});

$app->get('/meters/{id}', function (Request $request, Response $response, array $args) {
    $meter = Meter::find($args['id']);
    return $response->withJson($meter);
});

$app->get('/meters/{id}/readings', function (Request $request, Response $response, array $args) {
    $meter = Meter::find($args['id']);
    return $response->withJson($meter->readings);
});

$app->get('/readings', function (Request $request, Response $response, array $args) {
    $readings = Reading::all();
    return $response->withJson($readings);
});

$app->get('/readings/{id}', function (Request $request, Response $response, array $args) {
    $reading = Reading::find($args['id']);
    return $response->withJson($reading);
});
