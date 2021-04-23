<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use \PDO;

class UserRepository extends BaseRepository
{
    /**
     * Procura um usuário pelo username dele
     *
     * @param string $username
     * @return User|null
     */
    public function findUserByUsername(string $username) : ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        // Se nenhum registro for encontrado, retorna null
        if (!isset($data->id)) {
            return null;
        }

        $user = new User($data->username, $data->password, (int)$data->id);
        return $user;
    }
}