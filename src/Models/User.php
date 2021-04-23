<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    /**
     * Constructor
     *
     * @param string $username
     * @param string $password
     * @param int $id
     */
    function __construct(string $username, string $password, ?int $id = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->id = $id;
    }

    /**
     * Obtém o ID do usuário
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Obtém o nome de usuário
     *
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * Define o nome de usuário
     *
     * @param string $username
     * @return void
     */
    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    /**
     * Obtém a senha do usuário
     *
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * Obtém a senha (hasheada) do usuário
     *
     * @return string
     */
    public function getHashPassword() : string
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    /**
     * Define a senha do usuário
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    /**
     * Compara a senha plain com a hasheada
     *
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password) : bool
    {
        return password_verify($password, $this->password);
    }
}