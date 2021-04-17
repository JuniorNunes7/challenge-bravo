<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;
use App\DB;
use Slim\Factory\AppFactory;

abstract class TestCase extends BaseTestCase
{

    /**
     * Cria uma instância de Slim\App.
     *
     * @return void
     */
    protected function createApplication()
    {
        // Carregando arquivo .env
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $_ENV['DB_CONNECTION'] = $_SERVER['DB_CONNECTION'];
        $_ENV['DB_DATABASE'] = $_SERVER['DB_DATABASE'];
        $_ENV['APP_ENV'] = $_SERVER['APP_ENV'];

        // Instânciando o app
        $app = AppFactory::create();

        // Registrando rotas
        $routes = require __DIR__ . '/../src/routes/api.php';
        $routes($app);

        $this->app = $app;
        $GLOBALS['app'] = $this->app;
    }

    /**
     * Monta o banco de dados para realizar os testes
     *
     * @param DB $db
     * @return void
     */
    protected function createDb(DB $db)
    {
        // Removendo tabelas caso, exista
        $db->getConnection()->query('DROP TABLE IF EXISTS currencies');

        // Criando tabela currencies, caso não exista
        $db->getConnection()->query('CREATE TABLE IF NOT EXISTS currencies (
            currency VARCHAR(5) UNIQUE PRIMARY KEY,
            usd_value FLOAT
        )');

        // Cadastrando moedas
        $db->getConnection()->query('INSERT INTO currencies (currency, usd_value) VALUES
        ("USD", 1), ("BRL", 5.59), ("EUR", 0.83), ("BTC", 0.000016), ("ETH", 0.00041)');
    }

    /**
     * Criam um objeto SlimRequest pra simular requisições http.
     *
     * @param string $method
     * @param string $path
     * @param array $headers
     * @param array $formData
     * @param array $cookies
     * @param array $serverParams
     * @return SlimRequest
     */
    protected function createRequest(string $method, string $path, array $headers = [], 
        array $formData = [], array $cookies = [], array $serverParams = []) : SlimRequest 
    {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        $request = new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
        if (isset($formData)) {
            $request = $request->withParsedBody($formData);
        }

        return $request;
    }
}