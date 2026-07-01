<?php

class Database
{
    private $conexion;

    public function __construct()
    {
        $host = "localhost";
        $dbname = "parcial_3";
        $user = "root";
        $password = "";

        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            $this->conexion = new PDO($dsn, $user, $password);

            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    private function bindValueAuto($stmt, $parametro, $valor)
    {
        if ($valor === null) {
            $stmt->bindValue($parametro, null, PDO::PARAM_NULL);
        } elseif (is_int($valor)) {
            $stmt->bindValue($parametro, $valor, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($parametro, $valor);
        }
    }

    public function insertSeguro($tabla, $data)
    {
        $columnas = implode(", ", array_keys($data));
        $parametros = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $tabla ($columnas) VALUES ($parametros)";

        try {
            $stmt = $this->conexion->prepare($sql);

            foreach ($data as $key => $value) {
                $this->bindValueAuto($stmt, ":$key", $value);
            }

            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateSeguro($tabla, $data, $condiciones)
    {
        $set = [];

        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }

        $setSQL = implode(", ", $set);

        $where = [];

        foreach ($condiciones as $key => $value) {
            $where[] = "$key = :cond_$key";
        }

        $whereSQL = implode(" AND ", $where);

        $sql = "UPDATE $tabla SET $setSQL WHERE $whereSQL";

        try {
            $stmt = $this->conexion->prepare($sql);

            foreach ($data as $key => $value) {
                $this->bindValueAuto($stmt, ":$key", $value);
            }

            foreach ($condiciones as $key => $value) {
                $this->bindValueAuto($stmt, ":cond_$key", $value);
            }

            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteSeguro($tabla, $condiciones)
    {
        $where = [];

        foreach ($condiciones as $key => $value) {
            $where[] = "$key = :$key";
        }

        $whereSQL = implode(" AND ", $where);

        $sql = "DELETE FROM $tabla WHERE $whereSQL";

        try {
            $stmt = $this->conexion->prepare($sql);

            foreach ($condiciones as $key => $value) {
                $this->bindValueAuto($stmt, ":$key", $value);
            }

            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function select($sql, $params = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll();

        } catch (PDOException $e) {
            return [];
        }
    }

    public function selectOne($sql, $params = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetch();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function ejecutar($sql, $params = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute($params);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function lastInsertId()
    {
        return $this->conexion->lastInsertId();
    }

    public function disconnect()
    {
        $this->conexion = null;
    }
}

?>