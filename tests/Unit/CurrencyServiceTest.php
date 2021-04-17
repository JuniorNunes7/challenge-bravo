<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\CurrencyService;

use Tests\TestCase;

class CurrencyServiceTest extends TestCase
{

    /**
     * Test - Validate Convert Fields
     *
     * @return void
     */
    public function testValidateConvertFields()
    {
        $data = [
            'from' => 'USD',
            'to' => 'BRL',
            'amount' => 1
        ];

        $errors = CurrencyService::validateConvertFields($data, ['USD', 'BRL']);
        $this->assertEmpty($errors);
        
        $errors = CurrencyService::validateConvertFields($data, ['USD']);
        $this->assertIsArray($errors);
        $this->assertArrayHasKey(0, $errors);
        $this->assertStringContainsString('BRL', $errors[0]);

        $data['amount'] = 'NOT_NUMERIC';
        $errors = CurrencyService::validateConvertFields($data, ['USD', 'BRL']);
        $this->assertIsArray($errors);
        $this->assertArrayHasKey(0, $errors);
        $this->assertStringContainsString('amount', $errors[0]);
    }

    /**
     * Test - Validate Add Fields
     *
     * @return void
     */
    public function testValidateAddFields()
    {
        $data = [
            'currency' => 'CAD',
            'usd_value' => 0.8,
        ];

        $errors = CurrencyService::validateAddFields($data);
        $this->assertEmpty($errors);
        
        $data['currency'] = 'NOT_EXISTS';
        $data['usd_value'] = 'NOT_NUMERIC';
        $errors = CurrencyService::validateAddFields($data);
        $this->assertIsArray($errors);
        $this->assertArrayHasKey(1, $errors);
        $this->assertStringContainsString('NOT_EXISTS', $errors[0]);
        $this->assertStringContainsString('usd_value', $errors[1]);
    }
}