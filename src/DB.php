<?php

declare(strict_types=1);

namespace App;

use Exception;
use \PDO;
use Throwable;

class DB
{
    /**
     * Conexão com o banco de dados
     *
     * @var PDO
     */
    protected $conn;

    /**
     * Constructor
     */
    function __construct()
    {
        $database = $_ENV['DB_DATABASE'] ?? null;

        try {
            $conn = new PDO('sqlite:' . __DIR__ . '/../' . $database);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(Throwable $e) {
            throw new Exception("Erro ao tentar acessar o banco de dados!");
        }

        $this->conn = $conn;
    }

    /**
     * Obtém a conexão com o banco de dados
     *
     * @return PDO $conn
     */
    public function getConnection() : PDO
    {
        return $this->conn;
    }
}