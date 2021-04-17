<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\CurrencyRepository;
use App\Services\{CurrencyService, ResponseService};
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
        $data = $request->getQueryParams();

        $currencies = (new CurrencyRepository($this->app->db))->getCurrencies();
        $currencies = array_reduce($currencies, function ($result, $currency) {
            $result[$currency->getCurrency()] = $currency->getUsdValue();
            return $result;
        });

        $errors = CurrencyService::validateConvertFields($data, array_keys($currencies));

        if (!empty($errors)) {
            return ResponseService::makeResponse($response, 400, ['errors' => $errors]);
        }

        $usdFromValue = $currencies[$data['from']];
        $usdToValue = $currencies[$data['to']];

        $total = ($usdToValue/$usdFromValue)*$data['amount'];

        return ResponseService::makeResponse($response, 200, ['total' => $total]);
    }
}