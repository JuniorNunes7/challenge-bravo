<?php

use App\DB;
use App\Models\User;

require __DIR__ . '/../../vendor/autoload.php';

// Carregando arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$db = new DB();

// Usuário
// Removendo tabela, caso exista
$db->getConnection()->query('DROP TABLE IF EXISTS users');

// Criando tabela users, caso não exista
$db->getConnection()->query('CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(20) UNIQUE,
    password VARCHAR(255)
)');

// Criando usuário admin
$username = $_ENV['DEFAULT_USER_LOGIN'] ?? 'admin';
$password = $_ENV['DEFAULT_USER_PASSWORD'] ?? 'HuRbCh4113ng3#bR4v0';
$user = new User($username, $password);
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $db->getConnection()->prepare($sql);
$stmt->execute([ $user->getUsername(), $user->getHashPassword() ]);

// Moedas
// Removendo tabela, caso exista
$db->getConnection()->query('DROP TABLE IF EXISTS currencies');

// Criando tabela users, caso não exista
$db->getConnection()->query('CREATE TABLE IF NOT EXISTS currencies (
    currency VARCHAR(5) UNIQUE PRIMARY KEY,
    usd_value FLOAT
)');