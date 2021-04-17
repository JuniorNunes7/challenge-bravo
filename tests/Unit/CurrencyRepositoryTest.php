<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Repositories\CurrencyRepository;
use App\DB;
use App\Models\Currency;

use Tests\TestCase;

class CurrencyRepositoryTest extends TestCase
{
    /**
     * CurrencyRepository instance
     *
     * @var CurrencyRepository
     */
    private $currencyRepo;

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
        $this->currencyRepo = new CurrencyRepository($db);
    }

    /**
     * Test - Save Currency
     *
     * @return void
     */
    public function testSaveCurrency()
    {
        $currency = new Currency('CAD', 0.8);
        $response = $this->currencyRepo->saveCurrency($currency);
        $this->assertTrue($response);
        $this->expectException(\PDOException::class);
        $response = $this->currencyRepo->saveCurrency($currency);
    }

    /**
     * Test - Update Currency
     *
     * @return void
     */
    public function testUpdateCurrency()
    {
        $currency = new Currency('BRL', 10);
        $response = $this->currencyRepo->updateCurrency($currency);
        $this->assertTrue($response);
    }

    /**
     * Test - Check Currency Exists
     *
     * @return void
     */
    public function testCheckCurrencyExists()
    {
        $response = $this->currencyRepo->checkCurrencyExists('USD');
        $this->assertTrue($response);
        $response = $this->currencyRepo->checkCurrencyExists('NOT_EXISTS');
        $this->assertFalse($response);
    }

    /**
     * Test - Get Currencies
     *
     * @return void
     */
    public function testGetCurrencies()
    {
        $currencies = $this->currencyRepo->getCurrencies();
        $this->assertIsArray($currencies);
        $this->assertTrue($currencies[0] instanceof Currency);
    }
}