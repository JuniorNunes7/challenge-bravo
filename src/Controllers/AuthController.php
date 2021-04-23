<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\UserRepository;
use App\Services\{JWTService, ResponseService};

class AuthController extends BaseController
{
    /**
     * Login ENDPOINT
     *
     * @url /login
     * @method POST
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response) : Response
    {
        $data = $request->getParsedBody();

        // Verificando se os parâmetros foram passados corretamente.
        if (!isset($data['username']) || !isset($data['password'])) {
            return ResponseService::makeResponse($response, 400, ['message' => 'Parâmetros inválidos!']);
        }

        // Verifica conexão com o banco
        if (!isset($this->app->db)) {
            return ResponseService::makeResponse($response, 500, ['message' => 'Erro ao se conectar no banco de dados!']);
        }

        $userRepository = new UserRepository($this->app->db);

        // Obtendo usuário pelo username, ou retornando vazio, caso não encontre.
        $user = $userRepository->findUserByUsername($data['username']);

        // Se o usuário não for encontrado, ou se a senha estiver incorreta, retorna erro 401.
        if (empty($user) || !$user->checkPassword($data['password'])) {
            return ResponseService::makeResponse($response, 401, ['message' => 'Não autorizado!']);
        }

        $payload = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
        ];

        // Gerando token JWT usando o payload com informações do usuário.
        $token = JWTService::generateToken($payload);
        return ResponseService::makeResponse($response, 200, ['type' => 'Bearer', 'token' => $token]);
    }
}