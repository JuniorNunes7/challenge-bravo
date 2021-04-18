<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {

    /**
     * Documentação da API
     */
    $app->get('/', function (Request $request, Response $response) {
        return $response->withStatus(301)->withHeader('Location', '/docs/index.html');
    });

    /**
     * Converter Moeda - Endpoint
     * 
     * @url /currencies
     * @method GET
     * @queryParam string from
     * @queryParam string to
     * @queryParam float amount
     */
    $app->get('/currencies', 'App\Controllers\CurrencyController:convertCurrency');

    /**
     * Adicionar Moeda - Endpoint
     * 
     * @url /currencies
     * @method POST
     * @bodyParam string currency
     * @bodyParam float usd_value
     */
    $app->post('/currencies', 'App\Controllers\CurrencyController:addCurrency');

    /**
     * Remover Moeda - Endpoint
     * 
     * @url /currencies/{currency}
     * @method DELETE
     */
    $app->delete('/currencies/{currency}', 'App\Controllers\CurrencyController:removeCurrency');

};