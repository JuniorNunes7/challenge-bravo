<?php

use Slim\Factory\AppFactory;
use App\DB;

require __DIR__ . '/../vendor/autoload.php';

// Carregando arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Iniciando aplicação
$app = AppFactory::create();

try {
    // Configurando banco e atribuindo conexão ao $app
    $app->db = new DB();
} catch(Throwable $e) {
    $app->db = null;
}

// Registrando rotas
$routes = require __DIR__ . '/../src/routes/api.php';
$routes($app);

// Adicionando Middleware para tratar erro
$app->addErrorMiddleware(true, true, true);

// Rodando aplicação
$app->run();