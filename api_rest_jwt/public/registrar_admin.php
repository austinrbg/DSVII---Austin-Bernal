<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\UsuarioController;

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Método no permitido. Use POST."
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    exit;
}

$controller = new UsuarioController();
$controller->registrarAdmin();

?>