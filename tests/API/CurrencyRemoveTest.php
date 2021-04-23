<?php

namespace Tests\API;

use Tests\TestCase;
use App\DB;
use App\Services\JWTService;

class CurrencyRemoveTest extends TestCase
{

    /**
     * Token de autenticação
     *
     * @var string
     */
    private $authToken;

    /**
     * SetUp Tests
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->createApplication();

        $db = new DB();
        $this->createDb($db);
        $this->app->db = $db;

        // Gerando token válido
        $payload = ['uid' => 1, 'username' => 'admin'];
        $this->authToken = JWTService::generateToken($payload);
    }

    /**
     * Test - Currency remove endpoint with right params
     *
     * @return void
     */
    public function testCurrencyRemoveEndpointRightParams()
    {
        $request = $this->createRequest('DELETE', '/currencies/BRL', ['Authorization' => "Bearer {$this->authToken}"]);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
    }

    /**
     * Test - Currency remove endpoint with wrong token
     *
     * @return void
     */
    public function testCurrencyRemoveEndpointWrongToken()
    {
        $data = [
            'currency' => 'CAD',
            'usd_value' => 0.8
        ];
        $request = $this->createRequest('POST', '/currencies', ['Authorization' => "Bearer wrong_token"], $data);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 401);
    }

    /**
     * Test - Currency remove endpoint with wrong params
     *
     * @return void
     */
    public function testCurrencyRemoveEndpointWrongParams()
    {
        $request = $this->createRequest('DELETE', '/currencies/USD', ['Authorization' => "Bearer {$this->authToken}"]);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
        $request = $this->createRequest('DELETE', '/currencies/NOT_EXISTS', ['Authorization' => "Bearer {$this->authToken}"]);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
    }
}