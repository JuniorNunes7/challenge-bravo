<?php

namespace Tests\API;

use Tests\TestCase;
use App\DB;

class CurrencyRemoveTest extends TestCase
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
     * Test - Currency remove endpoint with right params
     *
     * @return void
     */
    public function testCurrencyRemoveEndpointRightParams()
    {
        $request = $this->createRequest('DELETE', '/currencies/BRL');
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 200);
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
    }

    /**
     * Test - Currency remove endpoint with wrong params
     *
     * @return void
     */
    public function testCurrencyRemoveEndpointWrongParams()
    {
        $request = $this->createRequest('DELETE', '/currencies/USD');
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
        $request = $this->createRequest('DELETE', '/currencies/NOT_EXISTS');
        $response = $this->app->handle($request);
        $this->assertEquals($response->getStatusCode(), 400);
    }
}