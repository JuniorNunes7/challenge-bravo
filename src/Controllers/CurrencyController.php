<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Currency;
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

        // Obtendo as moedas cadastradas no banco
        $currencies = (new CurrencyRepository($this->app->db))->getCurrencies();
        $currencies = array_reduce($currencies, function ($result, $currency) {
            $result[$currency->getCurrency()] = $currency->getUsdValue();
            return $result;
        });

        // Validando dados
        $errors = CurrencyService::validateConvertFields($data, array_keys($currencies));

        if (!empty($errors)) {
            return ResponseService::makeResponse($response, 400, ['message' => $errors]);
        }

        $usdFromValue = $currencies[$data['from']];
        $usdToValue = $currencies[$data['to']];

        // Obtendo total da conversão
        $total = ($usdToValue/$usdFromValue)*$data['amount'];

        return ResponseService::makeResponse($response, 200, ['total' => $total]);
    }

    /**
     * Adiciona uma moeda no banco
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function addCurrency(Request $request, Response $response) : Response
    {
        $data = $request->getParsedBody();

        // Validando dados
        $errors = CurrencyService::validateAddFields($data);

        if (!empty($errors)) {
            return ResponseService::makeResponse($response, 400, ['message' => $errors]);
        }
        
        // Verificando se a moeda já está registrada no banco
        $currencyRepo = new CurrencyRepository($this->app->db);
        if ($currencyRepo->checkCurrencyExists($data['currency'])) {
            return ResponseService::makeResponse($response, 400, ['message' => 'O código da moeda já está registrado!']);
        }

        // Registrando nova moeda no banco
        $currency = new Currency($data['currency'], (float)$data['usd_value']);
        $currencyRepo->saveCurrency($currency);

        return ResponseService::makeResponse($response, 201, ['message' => 'A moeda foi adicionada com sucesso!']);
    }

    /**
     * Remove uma moeda do banco
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function removeCurrency(Request $request, Response $response, array $args) : Response
    {
        $currency = $args['currency'];
        
        // Não permitir remover a moeda USD
        if ($currency === 'USD') {
            return ResponseService::makeResponse($response, 400, ['message' => 'Não é possível remover a moeda USD!']);    
        }
        
        // Verificando se a moeda está registrada no banco
        $currencyRepo = new CurrencyRepository($this->app->db);
        if (!$currencyRepo->checkCurrencyExists($currency)) {
            return ResponseService::makeResponse($response, 400, ['message' => 'A moeda "' . $currency . '" não foi encontrada!']);
        }

        // Removendo moeda
        $removeStatus = $currencyRepo->removeCurrency($currency);

        // Retornando erro, caso não consiga remover o registro
        if (!$removeStatus) {
            return ResponseService::makeResponse($response, 500, ['message' => 'Erro ao remover a moeda!']);    
        }

        return ResponseService::makeResponse($response, 200, ['message' => 'A moeda foi removida com sucesso!']);
    }
}