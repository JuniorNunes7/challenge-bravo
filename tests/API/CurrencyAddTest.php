<?php

namespace Tests\API;

use Tests\TestCase;
use App\DB;

class CurrencyAddTest extends TestCase
{

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
        $request = $this->createRequest('POST', '/currencies', [], $data);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 200);
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $body = json_decode($body);
        $this->assertObjectHasAttribute('message', $body);
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
        $request = $this->createRequest('POST', '/currencies', [], $data);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $body = json_decode($body);
        $this->assertObjectHasAttribute('errors', $body);
        $this->assertArrayHasKey(1, $body->errors);
    }
}