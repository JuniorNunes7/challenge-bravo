<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrencyAPIService
{
    /**
     * GuzzleHttp\Client Instance
     *
     * @var Client
     */
    private $client;

    /**
     * Chave da API
     *
     * @var string
     */
    private $appKey;

    /**
     * Constructor
     */
    function __construct()
    {
        $baseUrl = $_ENV['CURRENCY_API_URL'];
        $this->appKey = $_ENV['CURRENCY_API_APP'];

        // Configurando cliente
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'timeout'  => 3.0
        ]);
    }

    /**
     * Dispara a requisição e padroniza a resposta
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @return array
     */
    private function send(string $method, string $url, array $params = []) : array
    {
        try {
            $response = $this->client->request($method, $url, $params);
        } catch (\Exception $e) {}

        return [
            'status' => !isset($e),
            'code' => isset($e) ? $e->getCode() : $response->getStatusCode(),
            'content' => isset($e) ? $e->getMessage() : (string)$response->getBody()
        ];
    }

    /**
     * Obtém as taxas de câmbio mais recentes (usando como base o USD)
     *
     * @return array
     */
    public function getExchangeRates() : array
    {
        $response = $this->send('GET', 'latest', ['query' => [
            'apikey' => $this->appKey
        ]]);
        return $response;
    }
}