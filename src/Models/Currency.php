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
     * Todos os códigos de moedas disponíveis
     *
     * @var array
     */
    public static $availableCurrencies = [
        'AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BCH','BDT','BGN','BHD',
        'BIF','BMD','BND','BOB','BRL','BSD','BTC','BTN','BWP','BYN','BYR','BZD','CAD','CDF','CHF','CLP',
        'CNY','COP','CRC','CUC','CUP','CVE','CZK','DASH','DJF','DKK','DOP','DZD','EGP','EOS','ERN','ETB',
        'ETC','ETH','EUR','FJD','FKP','GBP','GEL','GGP','GHS','GIP','GMD','GNF','GTQ','GYD','HKD','HNL',
        'HRK','HTG','HUF','IDR','ILS','IMP','INR','IQD','IRR','ISK','JEP','JMD','JOD','JPY','KES','KGS',
        'KHR','KMF','KPW','KRW','KWD','KYD','KZT','LAK','LBP','LKR','LRD','LSL','LTC','LYD','MAD','MDL',
        'MGA','MKD','MMK','MNT','MOP','MRO','MRU','MUR','MVR','MWK','MXN','MYR','MZN','NAD','NGN','NIO',
        'NOK','NPR','NZD','OMR','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB','RWF',
        'SAR','SBD','SCR','SDG','SEK','SGD','SHP','SLL','SOS','SRD','STD','SVC','SYP','SZL','THB','TJS',
        'TMT','TND','TOP','TRY','TTD','TWD','TZS','UAH','UGX','USD','USDC','UYU','UZS','VEF','VES','VND',
        'VUV','WST','XAF','XAG','XAU','XCD','XDR','XLM','XOF','XPD','XPF','XPT','YER','ZAR','ZEC','ZMW',
        'STN','WBTC','DAI','PAX','DOGE','XRP','GUSD','ZWL','BUSD','CLF','ZMK','LVL','LTL','MATIC','ZRX',
        'BSV','OMG','BAND','CVC','ANKR','SUSHI','ALGO','MANA','NMR','MKR','REN','REP','ADA','STORJ','UMA',
        'CGLD','GRT','UNI','AAVE','GBX','YFI','XTZ','SKL','DNT','COMP','CNH','KNC','ATOM','SNX','LRC','MTL',
        'BNT','OXT','CRV','NU','LINK','FIL','BAL','SSP','BAT','ETH2'
    ];

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