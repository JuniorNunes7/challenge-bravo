<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\CurrencyAPIService;

use Tests\TestCase;

class TheCatAPIServiceTest extends TestCase
{
    /**
     * CurrencyAPIService instance
     *
     * @var CurrencyAPIService
     */
    private $currencyAPIService;

    /**
     * SetUp Tests
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->createApplication();

        $this->currencyAPIService = new CurrencyAPIService();
    }

    /**
     * Test - Get Exchange Rates
     *
     * @return void
     */
    public function testGetExchangeRates()
    {
        $result = $this->currencyAPIService->getExchangeRates();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('content', $result);
        $this->assertTrue($result['status']);
        $this->assertJson($result['content']);
        $content = json_decode($result['content'], true);
        $this->assertArrayHasKey('rates', $content);
    }
}