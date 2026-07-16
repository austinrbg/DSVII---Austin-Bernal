<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\AuthService;
use App\ProductController;

header("Content-Type: application/json; charset=utf-8");

$auth = new AuthService();
$auth->protegerRuta();

$controller = new ProductController();

$metodo = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? (int)$_GET["id"] : null;

switch ($metodo) {
    case "GET":
        $controller->listar($id);
        break;

    case "POST":
        $controller->crear();
        break;

    case "PUT":
        if ($id === null) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "Debe enviar el ID del producto en la URL."
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            exit;
        }

        $controller->actualizar($id);
        break;

    case "DELETE":
        if ($id === null) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "Debe enviar el ID del producto en la URL."
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            exit;
        }

        $controller->eliminar($id);
        break;

    default:
        http_response_code(405);

        echo json_encode([
            "success" => false,
            "message" => "Método no permitido."
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        exit;
}

?>