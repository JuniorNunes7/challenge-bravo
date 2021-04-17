<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Currency;

use Tests\TestCase;

class CurrencyTest extends TestCase
{

    /**
     * Test - Currency constructor, getters and setters
     *
     * @return void
     */
    public function testCurrencyConstructorAndGettersAndSetters()
    {
        $currency = new Currency('BRL', 5.56);

        $this->assertEquals($currency->getCurrency(), 'BRL');
        $this->assertEquals($currency->getUsdValue(), 5.56);

        $this->expectException(\TypeError::class);
        $currency->setCurrency(1);
        $currency->setUsdValue('BRL');
    }

}