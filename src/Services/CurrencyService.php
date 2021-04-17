<?php

namespace App\Services;

class CurrencyService
{

    /**
     * Faz a validação dos campos passados para converter uma moeda
     *
     * @param array $data
     * @param array $availableCurrencies
     * @return array
     */
    public static function validateConvertFields(?array $data, array $availableCurrencies)
    {
        $errors = [];

        // Validação do campo from
        if (!isset($data['from'])) {
            $errors[] = 'O campo "from" é obrigatório.';
        } else if (!in_array($data['from'], $availableCurrencies)) {
            $errors[] = 'A moeda ' . $data['from'] . ' não é suportada.';
        }

        // Validação do campo to
        if (!isset($data['to'])) {
            $errors[] = 'O campo "to" é obrigatório.';
        } else if (!in_array($data['to'], $availableCurrencies)) {
            $errors[] = 'A moeda ' . $data['to'] . ' não é suportada.';
        }

        // Validação do campo amount
        if (!isset($data['amount'])) {
            $errors[] = 'O campo "amount" é obrigatório.';
        } else if(!is_numeric($data['amount'])) {
            $errors[] = 'O campo "amount" deve ser um número válido (use . como separador de decimais).';
        }

        return $errors;
    }
}