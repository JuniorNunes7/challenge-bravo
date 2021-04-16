<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Carregando arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Iniciando aplicação
$app = AppFactory::create();

// Registrando rotas
$routes = require __DIR__ . '/../src/routes/api.php';
$routes($app);

// Adicionando Middleware para tratar erro
$app->addErrorMiddleware(true, true, true);

// Rodando aplicação
$app->run();