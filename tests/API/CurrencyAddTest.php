<?php

namespace Tests\API;

use Tests\TestCase;
use App\DB;
use App\Services\JWTService;

class CurrencyAddTest extends TestCase
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
     * Test - Currency add endpoint with right params
     *
     * @return void
     */
    public function testCurrencyAddEndpointRightParams()
    {
        $data = [
            'currency' => 'CAD',
            'usd_value' => 0.8
        ];
        $request = $this->createRequest('POST', '/currencies', ['Authorization' => "Bearer {$this->authToken}"], $data);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 201);
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $body = json_decode($body);
        $this->assertObjectHasAttribute('message', $body);
    }

    /**
     * Test - Currency add endpoint with wrong token
     *
     * @return void
     */
    public function testCurrencyAddEndpointWrongToken()
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
     * Test - Currency add endpoint with wrong params
     *
     * @return void
     */
    public function testCurrencyAddEndpointWrongParams()
    {
        $data = [
            'currency' => 'NOT_EXISTS',
            'usd_value' => 'NOT_NUMERIC'
        ];
        $request = $this->createRequest('POST', '/currencies', ['Authorization' => "Bearer {$this->authToken}"], $data);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $body = json_decode($body);
        $this->assertObjectHasAttribute('message', $body);
        $this->assertArrayHasKey(1, $body->message);
    }
}