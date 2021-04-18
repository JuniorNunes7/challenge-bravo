<?php

namespace Tests\API;

use Tests\TestCase;
use App\DB;

class CurrencyConvertTest extends TestCase
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
     * Test - Currency convert endpoint with right params
     *
     * @return void
     */
    public function testCurrencyConvertEndpointRightParams()
    {
        $request = $this->createRequest('GET', '/currencies');
        $request = $request->withQueryParams([
            'from' => 'USD',
            'to' => 'BRL',
            'amount' => 1
        ]);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 200);
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $body = json_decode($body);
        $this->assertObjectHasAttribute('total', $body);
        $this->assertEquals($body->total, 5.59);
    }

    /**
     * Test - Currency convert endpoint with wrong params
     *
     * @return void
     */
    public function testCurrencyConvertEndpointWrongParams()
    {
        $request = $this->createRequest('GET', '/currencies');
        $request = $request->withQueryParams([
            'from' => 'NOT_EXISTS',
            'amount' => 'NOT-NUMERIC'
        ]);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $body = json_decode($body);
        $this->assertObjectHasAttribute('message', $body);
        $this->assertArrayHasKey(2, $body->message);
    }
}