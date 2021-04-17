<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use App\DB;

abstract class BaseRepository
{
    /**
     * Conexão com o banco de dados
     *
     * @var PDO
     */
    protected $db;

    /**
     * Constructor
     *
     * @param DB $db
     */
    function __construct(DB $db)
    {
        $this->db = $db->getConnection();        
    }
}