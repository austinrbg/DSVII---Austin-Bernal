<?php

class DB
{
    private $host = "localhost";
    private $dbname = "productosdb";
    private $user = "root";
    private $password = "";
    private $conexion;

    public function __construct()
    {
        try {
            $this->conexion = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8",
                $this->user,
                $this->password
            );

            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            header("Content-Type: application/json");
            echo json_encode([
                "success" => false,
                "message" => "Error de conexión a la base de datos",
                "errors" => [$e->getMessage()]
            ]);
            exit;
        }
    }

    public function insertSeguro($sql, $datos)
    {
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute($datos);
    }

    public function updateSeguro($sql, $datos)
    {
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute($datos);
    }

    public function query($sql, $datos = [])
    {
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($datos);
        return $stmt->fetchAll();
    }

    public function obtenerConexion()
    {
        return $this->conexion;
    }
}

?>