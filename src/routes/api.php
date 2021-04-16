<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {

    /**
     * / Endpoint
     * 
     * 
     */
    $app->get('/', function(Request $request, Response $response) {
        $response->getBody()->write('Oi, Mundo! :)');
        return $response->withStatus(200);
    });

};