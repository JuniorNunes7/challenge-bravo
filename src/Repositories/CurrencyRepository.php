<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;
use PDO;

class CurrencyRepository extends BaseRepository
{
    /**
     * Salva a moeda no banco de dados
     *
     * @param Currency $currency
     * @return bool
     */
    public function saveCurrency(Currency $currency) : bool
    {
        $stmt = $this->db->prepare('INSERT INTO currencies (currency, usd_value) VALUES (?,?)');
        return $stmt->execute([$currency->getCurrency(), $currency->getUsdValue()]);
    }

    /**
     * Atualiza a moeda no banco de dados
     *
     * @param Currency $currency
     * @return bool
     */
    public function updateCurrency(Currency $currency) : bool
    {
        $stmt = $this->db->prepare('UPDATE currencies SET usd_value=? WHERE currency=?');
        return $stmt->execute([$currency->getUsdValue(), $currency->getCurrency()]);
    }

    /**
     * Obtém as moedas cadastradas no banco de dados
     *
     * @return array
     */
    public function getCurrencies() : array
    {
        $stmt = $this->db->query('SELECT * FROM currencies');
        $currencies = $stmt->fetchAll(PDO::FETCH_FUNC, function($currency, $usdValue) {
            return new Currency($currency, (float)$usdValue);
        });

        return $currencies;
    }
}