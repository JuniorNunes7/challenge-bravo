<?php

namespace App\Services;

use Psr\Http\Message\ResponseInterface as Response;

class ResponseService
{
    /**
     * Gera uma Resposta HTTP
     *
     * @param Response $response
     * @param int $status
     * @param array $data
     * @return Response
     */
    public static function makeResponse(Response $response, int $status, array $data) : Response
    {
        $data = array_merge(['status' => $status], $data);

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}