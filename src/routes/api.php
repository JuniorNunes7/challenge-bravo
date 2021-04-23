<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Services\ResponseService;

return function (App $app) {

    // Adicionando rotas que vão exigir o token de acesso
    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "rules" => [
            new Tuupola\Middleware\JwtAuthentication\RequestPathRule([
                "path" => "/currencies"
            ]),
            new Tuupola\Middleware\JwtAuthentication\RequestMethodRule([
                "ignore" => ["GET"]
            ])
        ],
        "secret" => base64_encode($_ENV['JWT_SECRET']),
        'secure' => ($_ENV['APP_ENV'] !== 'testing'),
        'error' => function($response, $args) {
            return ResponseService::makeResponse($response, 401, ['message' => 'Não autorizado!']);
        }
    ]));

    /**
     * Documentação da API
     */
    $app->get('/', function (Request $request, Response $response) {
        return $response->withStatus(301)->withHeader('Location', '/docs/index.html');
    });

    /**
     * Login ENDPOINT
     * 
     * @url /login
     * @method POST
     * @param string username
     * @param string password
     */
    $app->post('/login', 'App\Controllers\AuthController:login');

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