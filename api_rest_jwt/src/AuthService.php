<?php

namespace App;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Exception;

class AuthService
{
    private string $secretKey;
    private string $issuer;
    private string $audience;
    private int $expiration;

    public function __construct()
    {
        $config = require __DIR__ . "/../config/config.php";

        $this->secretKey = $config["jwt_secret"];
        $this->issuer = $config["jwt_issuer"];
        $this->audience = $config["jwt_audience"];
        $this->expiration = $config["jwt_expiration"];
    }

    public function generarToken(array $usuario): string
    {
        $tiempoActual = time();

        $payload = [
            "iss" => $this->issuer,
            "aud" => $this->audience,
            "iat" => $tiempoActual,
            "nbf" => $tiempoActual,
            "exp" => $tiempoActual + $this->expiration,
            "data" => [
                "id" => $usuario["id"],
                "usuario" => $usuario["usuario"]
            ]
        ];

        return JWT::encode($payload, $this->secretKey, "HS256");
    }

    public function validarToken(string $token)
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, "HS256"));

        } catch (ExpiredException $e) {
            $this->respuestaNoAutorizada("Token expirado.");

        } catch (SignatureInvalidException $e) {
            $this->respuestaNoAutorizada("Firma del token inválida.");

        } catch (Exception $e) {
            $this->respuestaNoAutorizada("Token inválido.");
        }
    }

    public function obtenerTokenDesdeHeader(): ?string
    {
        $headers = getallheaders();

        if (isset($headers["Authorization"])) {
            $authorization = $headers["Authorization"];
        } elseif (isset($headers["authorization"])) {
            $authorization = $headers["authorization"];
        } else {
            return null;
        }

        if (preg_match('/Bearer\s(\S+)/', $authorization, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function protegerRuta()
    {
        $token = $this->obtenerTokenDesdeHeader();

        if ($token === null) {
            $this->respuestaNoAutorizada("Acceso denegado. Token no enviado.");
        }

        return $this->validarToken($token);
    }

    private function respuestaNoAutorizada(string $mensaje): void
    {
        http_response_code(401);

        echo json_encode([
            "success" => false,
            "message" => $mensaje
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }
}

?>