<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CurrencyController extends BaseController
{
    /**
     * Converte a moeda de acordo com os parâmetros passados
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function convertCurrency(Request $request, Response $response) : Response
    {
        $response->getBody()->write('Oi, Mundo! :)');
        return $response->withStatus(200);
    }
}