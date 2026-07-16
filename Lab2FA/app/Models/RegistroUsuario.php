<?php
// app/Models/RegistroUsuario.php

class RegistroUsuario {
    
    private $conexion;

    // Constructor: Recibe directamente el objeto PDO ya conectado
    public function __construct($db) {
        $this->conexion = $db;
    }

    // Responsabilidad 1: Validar si el usuario o el correo ya existen
    public function existeUsuario($usuario, $correo) {
        $sql = "SELECT id FROM usuarios WHERE Usuario = :usuario OR Correo = :correo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':usuario' => $usuario, ':correo' => $correo]);
        
        return $stmt->rowCount() > 0; // Devuelve true si ya existe
    }

    // Responsabilidad 2: Encriptar la contraseña de forma segura
    public function hashearPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // Responsabilidad 3: Guardar el nuevo usuario en la base de datos
    public function guardarUsuario($nombre, $apellido, $usuario, $correo, $password, $secret_2fa) {
        $hash = $this->hashearPassword($password);
        
        // Se usan los nombres exactos de las columnas de tu tabla
        $sql = "INSERT INTO usuarios (Nombre, Apellido, Usuario, Correo, HashMagic, secret_2fa) 
                VALUES (:nombre, :apellido, :usuario, :correo, :hash, :secret)";
        
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            ':nombre'    => $nombre,
            ':apellido'  => $apellido,
            ':usuario'   => $usuario,
            ':correo'    => $correo,
            ':hash'      => $hash,
            ':secret'    => $secret_2fa
        ]);
    }
}
?>