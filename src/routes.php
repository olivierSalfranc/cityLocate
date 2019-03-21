<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$token;

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
    $token=sha1();
});

$app->get('/getToken',function (Request $request, Response $response, array $args){

});
