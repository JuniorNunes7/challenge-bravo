<?php

use App\DB;

require __DIR__ . '/../../vendor/autoload.php';

// Carregando arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$db = new DB();

// Cadastrando moedas
$db->getConnection()->query('INSERT INTO currencies (currency, usd_value) VALUES
("USD", 1), ("BRL", 5.59), ("EUR", 0.83), ("BTC", 0.000016), ("ETH", 0.00041)');