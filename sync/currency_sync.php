<?php

use App\Repositories\CurrencyRepository;
use App\Services\CurrencyAPIService;
use App\DB;

require __DIR__ . '/../vendor/autoload.php';

// Carregando arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Obtendo as taxas de câmbio mais recentes na API externa
$currencyService = new CurrencyAPIService();
$response = $currencyService->getExchangeRates();

// Verificando se a requisição foi concluída com sucesso
if ($response['status']) {
    // Obtendo as taxas de câmbio da resposta
    $rates = (json_decode($response['content'], true))['rates'];

    // Obtendo as moedas cadastradas no sistema
    $db = new DB();
    $currencyRepo = new CurrencyRepository($db);
    $currencies = $currencyRepo->getCurrencies();

    // Percorrendo o array de moedas e atualizando com o valor em dólar mais recente.
    foreach($currencies as $currency) {
        $currencySymbol = $currency->getCurrency();
        $currency->setUsdValue($rates[$currencySymbol]);
        $currencyRepo->updateCurrency($currency);
    }
} else {
    throw new Exception("Erro ao obter as taxas de câmbio!");
}