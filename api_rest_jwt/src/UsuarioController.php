<?php

namespace App;

class UsuarioController
{
    private Database $db;
    private AuthService $auth;

    public function __construct()
    {
        $this->db = new Database();
        $this->auth = new AuthService();
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

    public function registrarAdmin(): void
    {
        $datos = $this->obtenerJson();

        $usuario = trim($datos["usuario"] ?? "");
        $password = trim($datos["password"] ?? "");

        if ($usuario == "" || $password == "") {
            $this->responder(400, [
                "success" => false,
                "message" => "Usuario y contraseña son obligatorios."
            ]);
        }

        if (strlen($password) < 6) {
            $this->responder(400, [
                "success" => false,
                "message" => "La contraseña debe tener mínimo 6 caracteres."
            ]);
        }

        $usuarioExistente = $this->db->selectOne(
            "SELECT id FROM usuarios WHERE usuario = ?",
            [$usuario]
        );

        if ($usuarioExistente) {
            $this->responder(409, [
                "success" => false,
                "message" => "El usuario ya existe."
            ]);
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $guardado = $this->db->ejecutar(
            "INSERT INTO usuarios (usuario, password) VALUES (?, ?)",
            [$usuario, $passwordHash]
        );

        if (!$guardado) {
            $this->responder(500, [
                "success" => false,
                "message" => "No se pudo registrar el usuario."
            ]);
        }

        $this->responder(201, [
            "success" => true,
            "message" => "Usuario admin registrado correctamente con password_hash()."
        ]);
    }

    public function login(): void
    {
        $datos = $this->obtenerJson();

        $usuario = trim($datos["usuario"] ?? "");
        $password = trim($datos["password"] ?? "");

        if ($usuario == "" || $password == "") {
            $this->responder(400, [
                "success" => false,
                "message" => "Usuario y contraseña son obligatorios."
            ]);
        }

        $usuarioEncontrado = $this->db->selectOne(
            "SELECT id, usuario, password FROM usuarios WHERE usuario = ?",
            [$usuario]
        );

        if (!$usuarioEncontrado) {
            $this->responder(401, [
                "success" => false,
                "message" => "Credenciales incorrectas."
            ]);
        }

        if (!password_verify($password, $usuarioEncontrado["password"])) {
            $this->responder(401, [
                "success" => false,
                "message" => "Credenciales incorrectas."
            ]);
        }

        $token = $this->auth->generarToken([
            "id" => $usuarioEncontrado["id"],
            "usuario" => $usuarioEncontrado["usuario"]
        ]);

        $this->responder(200, [
            "success" => true,
            "message" => "Login correcto. Token generado.",
            "token_type" => "Bearer",
            "token" => $token
        ]);
    }
}

?>