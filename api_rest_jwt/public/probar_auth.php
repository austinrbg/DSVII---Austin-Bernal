<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\AuthService;

header("Content-Type: application/json; charset=utf-8");

$auth = new AuthService();

$usuarioPrueba = [
    "id" => 1,
    "usuario" => "admin"
];

$token = $auth->generarToken($usuarioPrueba);

echo json_encode([
    "success" => true,
    "message" => "Token generado correctamente.",
    "token" => $token
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

?>