<?php

require_once __DIR__ . "/conexion.php";

class Producto
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    private function validar($codigo, $producto, $precio, $cantidad, $validarId = false, $id = null)
    {
        $errors = [];

        if ($validarId && (empty($id) || !is_numeric($id))) {
            $errors[] = "El ID del producto no es válido.";
        }

        if (empty(trim($codigo))) {
            $errors[] = "El código es obligatorio.";
        }

        if (empty(trim($producto))) {
            $errors[] = "El nombre del producto es obligatorio.";
        }

        if ($precio === "" || !is_numeric($precio) || $precio < 0) {
            $errors[] = "El precio debe ser un número válido mayor o igual a 0.";
        }

        if ($cantidad === "" || !is_numeric($cantidad) || $cantidad < 0) {
            $errors[] = "La cantidad debe ser un número válido mayor o igual a 0.";
        }

        return $errors;
    }

    private function existeCodigo($codigo, $idIgnorar = null)
    {
        if ($idIgnorar == null) {
            $sql = "SELECT * FROM productos WHERE codigo = ?";
            $datos = [$codigo];
        } else {
            $sql = "SELECT * FROM productos WHERE codigo = ? AND id != ?";
            $datos = [$codigo, $idIgnorar];
        }

        $resultado = $this->db->query($sql, $datos);

        return count($resultado) > 0;
    }

    public function guardar($codigo, $producto, $precio, $cantidad)
    {
        $errors = $this->validar($codigo, $producto, $precio, $cantidad);

        if (!empty($errors)) {
            return [
                "success" => false,
                "message" => "Hay errores en el formulario.",
                "accion" => "Guardar",
                "errors" => $errors
            ];
        }

        if ($this->existeCodigo($codigo)) {
            return [
                "success" => false,
                "message" => "Ya existe un producto con ese código.",
                "accion" => "Guardar",
                "errors" => ["El código ingresado ya está registrado."]
            ];
        }

        $sql = "INSERT INTO productos (codigo, producto, precio, cantidad) 
                VALUES (?, ?, ?, ?)";

        $datos = [
            trim($codigo),
            trim($producto),
            $precio,
            $cantidad
        ];

        $resultado = $this->db->insertSeguro($sql, $datos);

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Producto guardado correctamente.",
                "accion" => "Guardar",
                "errors" => []
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo guardar el producto.",
            "accion" => "Guardar",
            "errors" => ["Error al insertar en la base de datos."]
        ];
    }

    public function editar($id, $codigo, $producto, $precio, $cantidad)
    {
        $errors = $this->validar($codigo, $producto, $precio, $cantidad, true, $id);

        if (!empty($errors)) {
            return [
                "success" => false,
                "message" => "Hay errores en el formulario.",
                "accion" => "Modificar",
                "errors" => $errors
            ];
        }

        if ($this->existeCodigo($codigo, $id)) {
            return [
                "success" => false,
                "message" => "Ya existe otro producto con ese código.",
                "accion" => "Modificar",
                "errors" => ["El código ingresado ya pertenece a otro producto."]
            ];
        }

        $sql = "UPDATE productos 
                SET codigo = ?, producto = ?, precio = ?, cantidad = ?
                WHERE id = ?";

        $datos = [
            trim($codigo),
            trim($producto),
            $precio,
            $cantidad,
            $id
        ];

        $resultado = $this->db->updateSeguro($sql, $datos);

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Producto actualizado correctamente.",
                "accion" => "Modificar",
                "errors" => []
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo actualizar el producto.",
            "accion" => "Modificar",
            "errors" => ["Error al actualizar en la base de datos."]
        ];
    }

    public function buscar($texto)
    {
        $texto = trim($texto);

        if ($texto == "") {
            return [
                "success" => false,
                "message" => "Debe escribir algo para buscar.",
                "accion" => "Buscar",
                "errors" => ["Campo de búsqueda vacío."],
                "data" => []
            ];
        }

        $sql = "SELECT * FROM productos 
                WHERE codigo LIKE ? OR producto LIKE ?
                ORDER BY id DESC";

        $datoBuscar = "%" . $texto . "%";

        $productos = $this->db->query($sql, [$datoBuscar, $datoBuscar]);

        return [
            "success" => true,
            "message" => "Búsqueda realizada correctamente.",
            "accion" => "Buscar",
            "errors" => [],
            "data" => $productos
        ];
    }

    public function listar()
    {
        $sql = "SELECT * FROM productos ORDER BY id DESC";

        $productos = $this->db->query($sql);

        return [
            "success" => true,
            "message" => "Productos listados correctamente.",
            "accion" => "Listar",
            "errors" => [],
            "data" => $productos
        ];
    }
}

?>