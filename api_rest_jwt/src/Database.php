<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private PDO $conexion;

    public function __construct()
    {
        $config = require __DIR__ . "/../config/config.php";

        $host = $config["db_host"];
        $dbname = $config["db_name"];
        $user = $config["db_user"];
        $password = $config["db_pass"];

        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            $this->conexion = new PDO($dsn, $user, $password);

            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => "Error de conexión a la base de datos.",
                "errors" => [$e->getMessage()]
            ], JSON_UNESCAPED_UNICODE);

            exit;
        }
    }

    public function getConexion(): PDO
    {
        return $this->conexion;
    }

    public function select(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            return [];
        }
    }

    public function selectOne(string $sql, array $params = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function ejecutar(string $sql, array $params = []): bool
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute($params);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function lastInsertId(): string
    {
        return $this->conexion->lastInsertId();
    }
}

?>