<?php

use App\DB;

require __DIR__ . '/../../vendor/autoload.php';

// Carregando arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$db = new DB();

// Removendo tabela, caso exista
$db->getConnection()->query('DROP TABLE IF EXISTS currencies');

// Criando tabela users, caso não exista
$db->getConnection()->query('CREATE TABLE IF NOT EXISTS currencies (
    currency VARCHAR(5) UNIQUE PRIMARY KEY,
    usd_value FLOAT
)');