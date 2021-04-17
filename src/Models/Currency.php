<?php

declare(strict_types=1);

namespace App\Models;

class Currency
{
    /**
     * @var string|null
     */
    private $currency;

    /**
     * @var float|null
     */
    private $usdValue;

    /**
     * Constructor
     *
     * @param string $currency
     * @param float $usdValue
     * @param int $id
     */
    function __construct(string $currency, float $usdValue)
    {
        $this->currency = $currency;
        $this->usdValue = $usdValue;
    }

    /**
     * Obtém o código da moeda
     *
     * @return string
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /**
     * Define o código da moeda
     *
     * @param string $currency
     * @return void
     */
    public function setCurrency(string $currency) : void
    {
        $this->currency = $currency;
    }

    /**
     * Obtém o valor em reais da moeda
     *
     * @return float
     */
    public function getUsdValue() : float
    {
        return $this->usdValue;
    }

    /**
     * Define o valor em reais da moeda
     *
     * @param float $usdValue
     * @return void
     */
    public function setUsdValue(float $usdValue) : void
    {
        $this->usdValue = $usdValue;
    }
}