<?php

namespace App\Services;

use Firebase\JWT\JWT;
use DateTime;

class JWTService
{
    /**
     * Gera um JWT
     *
     * @param array|object $payload
     * @param string $alg ['ES256', 'HS256', 'HS384', 'HS512', 'RS256', 'RS384', and 'RS512']
     * @return string $token
     */
    public static function generateToken($payload, $alg = 'HS512') : string
    {
        $defaultPayload = [
            'jti' => base64_encode(uniqid()),
            'iat' => (new DateTime())->getTimeStamp()
        ];
        $payload = array_merge($defaultPayload, $payload);
        $key = base64_encode($_ENV['JWT_SECRET']); // Obtendo o secret do arquivo .env

        $token = JWT::encode($payload, $key, $alg);
        return $token;
    }

    /**
     * Decodifica o JWT e retorna as informações como objeto
     *
     * @param string $token
     * @return object
     */
    public static function decode(string $token) : object
    {
        $key = base64_encode($_ENV['JWT_SECRET']); // Obtendo o secret do arquivo .env
        $algs = array_keys(JWT::$supported_algs);

        $decodedData = JWT::decode($token, $key, $algs);
        return $decodedData;
    }
}