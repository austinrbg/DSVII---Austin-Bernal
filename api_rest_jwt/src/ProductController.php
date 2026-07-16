<?php

namespace App;

class ProductController
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    private function obtenerJson(): array
    {
        $json = file_get_contents("php://input");
        $datos = json_decode($json, true);

        if (!is_array($datos)) {
            return [];
        }

        return $datos;
    }

    private function responder(int $codigo, array $datos): void
    {
        http_response_code($codigo);

        echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        exit;
    }

    private function validarProducto(array $datos): array
    {
        $errores = [];

        $codigo = trim($datos["codigo"] ?? "");
        $producto = trim($datos["producto"] ?? "");
        $precio = $datos["precio"] ?? "";
        $cantidad = $datos["cantidad"] ?? "";

        if ($codigo == "") {
            $errores[] = "El código es obligatorio.";
        }

        if ($producto == "") {
            $errores[] = "El nombre del producto es obligatorio.";
        }

        if ($precio === "" || !is_numeric($precio) || $precio <= 0) {
            $errores[] = "El precio debe ser un número mayor que 0.";
        }

        if ($cantidad === "" || filter_var($cantidad, FILTER_VALIDATE_INT) === false || $cantidad < 0) {
            $errores[] = "La cantidad debe ser un número entero mayor o igual a 0.";
        }

        return $errores;
    }

    public function listar(?int $id = null): void
    {
        if ($id !== null) {
            $producto = $this->db->selectOne(
                "SELECT id, codigo, producto, precio, cantidad, creado_en 
                 FROM productos 
                 WHERE id = ?",
                [$id]
            );

            if (!$producto) {
                $this->responder(404, [
                    "success" => false,
                    "message" => "Producto no encontrado."
                ]);
            }

            $this->responder(200, [
                "success" => true,
                "data" => $producto
            ]);
        }

        $productos = $this->db->select(
            "SELECT id, codigo, producto, precio, cantidad, creado_en 
             FROM productos 
             ORDER BY id DESC"
        );

        $this->responder(200, [
            "success" => true,
            "data" => $productos
        ]);
    }

    public function crear(): void
    {
        $datos = $this->obtenerJson();

        $errores = $this->validarProducto($datos);

        if (!empty($errores)) {
            $this->responder(400, [
                "success" => false,
                "message" => "Datos inválidos.",
                "errors" => $errores
            ]);
        }

        $codigo = trim($datos["codigo"]);
        $producto = trim($datos["producto"]);
        $precio = (float)$datos["precio"];
        $cantidad = (int)$datos["cantidad"];

        $existe = $this->db->selectOne(
            "SELECT id FROM productos WHERE codigo = ?",
            [$codigo]
        );

        if ($existe) {
            $this->responder(409, [
                "success" => false,
                "message" => "Ya existe un producto con ese código."
            ]);
        }

        $guardado = $this->db->ejecutar(
            "INSERT INTO productos (codigo, producto, precio, cantidad) 
             VALUES (?, ?, ?, ?)",
            [$codigo, $producto, $precio, $cantidad]
        );

        if (!$guardado) {
            $this->responder(500, [
                "success" => false,
                "message" => "No se pudo guardar el producto."
            ]);
        }

        $this->responder(201, [
            "success" => true,
            "message" => "Producto creado correctamente.",
            "id" => $this->db->lastInsertId()
        ]);
    }

    public function actualizar(int $id): void
    {
        if ($id <= 0) {
            $this->responder(400, [
                "success" => false,
                "message" => "ID inválido."
            ]);
        }

        $productoActual = $this->db->selectOne(
            "SELECT id FROM productos WHERE id = ?",
            [$id]
        );

        if (!$productoActual) {
            $this->responder(404, [
                "success" => false,
                "message" => "Producto no encontrado."
            ]);
        }

        $datos = $this->obtenerJson();

        $errores = $this->validarProducto($datos);

        if (!empty($errores)) {
            $this->responder(400, [
                "success" => false,
                "message" => "Datos inválidos.",
                "errors" => $errores
            ]);
        }

        $codigo = trim($datos["codigo"]);
        $producto = trim($datos["producto"]);
        $precio = (float)$datos["precio"];
        $cantidad = (int)$datos["cantidad"];

        $codigoUsado = $this->db->selectOne(
            "SELECT id FROM productos WHERE codigo = ? AND id <> ?",
            [$codigo, $id]
        );

        if ($codigoUsado) {
            $this->responder(409, [
                "success" => false,
                "message" => "Ese código ya está asignado a otro producto."
            ]);
        }

        $actualizado = $this->db->ejecutar(
            "UPDATE productos 
             SET codigo = ?, producto = ?, precio = ?, cantidad = ? 
             WHERE id = ?",
            [$codigo, $producto, $precio, $cantidad, $id]
        );

        if (!$actualizado) {
            $this->responder(500, [
                "success" => false,
                "message" => "No se pudo actualizar el producto."
            ]);
        }

        $this->responder(200, [
            "success" => true,
            "message" => "Producto actualizado correctamente."
        ]);
    }

    public function eliminar(int $id): void
    {
        if ($id <= 0) {
            $this->responder(400, [
                "success" => false,
                "message" => "ID inválido."
            ]);
        }

        $producto = $this->db->selectOne(
            "SELECT id FROM productos WHERE id = ?",
            [$id]
        );

        if (!$producto) {
            $this->responder(404, [
                "success" => false,
                "message" => "Producto no encontrado."
            ]);
        }

        $eliminado = $this->db->ejecutar(
            "DELETE FROM productos WHERE id = ?",
            [$id]
        );

        if (!$eliminado) {
            $this->responder(500, [
                "success" => false,
                "message" => "No se pudo eliminar el producto."
            ]);
        }

        $this->responder(200, [
            "success" => true,
            "message" => "Producto eliminado correctamente."
        ]);
    }
}

?>