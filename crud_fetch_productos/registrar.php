<?php

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/Modelo/Productos.php";

$response = [
    "success" => false,
    "message" => "Acción no válida.",
    "accion" => "",
    "errors" => []
];

try {
    $productoModelo = new Producto();

    $accion = $_POST["Accion"] ?? "";

    switch ($accion) {
        case "Guardar":
            $codigo = $_POST["Codigo"] ?? "";
            $producto = $_POST["Producto"] ?? "";
            $precio = $_POST["Precio"] ?? "";
            $cantidad = $_POST["Cantidad"] ?? "";

            $response = $productoModelo->guardar($codigo, $producto, $precio, $cantidad);
            break;

        case "Modificar":
            $id = $_POST["Id"] ?? "";
            $codigo = $_POST["Codigo"] ?? "";
            $producto = $_POST["Producto"] ?? "";
            $precio = $_POST["Precio"] ?? "";
            $cantidad = $_POST["Cantidad"] ?? "";

            $response = $productoModelo->editar($id, $codigo, $producto, $precio, $cantidad);
            break;

        case "Buscar":
            $texto = $_POST["Texto"] ?? "";

            $response = $productoModelo->buscar($texto);
            break;

        case "Listar":
            $response = $productoModelo->listar();
            break;

        default:
            $response = [
                "success" => false,
                "message" => "No se recibió una acción válida.",
                "accion" => $accion,
                "errors" => ["La acción enviada no existe."]
            ];
            break;
    }

} catch (Exception $e) {
    $response = [
        "success" => false,
        "message" => "Ocurrió un error en el servidor.",
        "accion" => "Error",
        "errors" => [$e->getMessage()]
    ];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>