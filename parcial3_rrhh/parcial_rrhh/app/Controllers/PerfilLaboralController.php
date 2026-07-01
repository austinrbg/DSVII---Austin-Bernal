<?php

require_once __DIR__ . "/../Models/PerfilLaboral.php";
require_once __DIR__ . "/../Models/Colaborador.php";
require_once __DIR__ . "/../Models/Catalogo.php";

class PerfilLaboralController
{
    private $modelo;
    private $colaboradorModelo;
    private $catalogo;

    public function __construct()
    {
        $this->modelo = new PerfilLaboral();
        $this->colaboradorModelo = new Colaborador();
        $this->catalogo = new Catalogo();
    }

    private function cargarVista($vista, $datos = [])
    {
        extract($datos);

        require_once __DIR__ . "/../Views/layout/header.php";
        require_once __DIR__ . "/../Views/" . $vista . ".php";
        require_once __DIR__ . "/../Views/layout/footer.php";
    }

    public function crear()
    {
        $tituloPagina = "Perfil laboral";
        $catalogos = $this->catalogo->obtenerTodos();
        $colaboradores = $this->colaboradorModelo->listar();
        $perfiles = $this->modelo->listar();

        $datosFormulario = [
            "colaborador_id" => $_GET["colaborador_id"] ?? "",
            "ocupacion_id" => "",
            "tipo_empleado_id" => "",
            "planilla_id" => "",
            "salario" => "",
            "fecha_inicio" => "",
            "fecha_fin" => "",
            "cargo_activo" => "1"
        ];

        $errores = [];
        $mensaje = $_GET["mensaje"] ?? "";
        $mensajeError = "";

        $integridades = [];

        foreach ($perfiles as $perfil) {
            $integridades[$perfil["id"]] = $this->modelo->verificarIntegridad($perfil["id"]);
        }

        $this->cargarVista("perfiles/crear", [
            "tituloPagina" => $tituloPagina,
            "catalogos" => $catalogos,
            "colaboradores" => $colaboradores,
            "perfiles" => $perfiles,
            "datosFormulario" => $datosFormulario,
            "errores" => $errores,
            "mensaje" => $mensaje,
            "mensajeError" => $mensajeError,
            "integridades" => $integridades
        ]);
    }

    public function guardar()
    {
        $respuesta = $this->modelo->guardar($_POST);

        if ($respuesta["success"]) {
            header("Location: index.php?accion=crear_perfil&mensaje=perfil_guardado");
            exit;
        }

        $tituloPagina = "Perfil laboral";
        $catalogos = $this->catalogo->obtenerTodos();
        $colaboradores = $this->colaboradorModelo->listar();
        $perfiles = $this->modelo->listar();
        $datosFormulario = $_POST;
        $errores = $respuesta["errors"];
        $mensajeError = $respuesta["message"];
        $mensaje = "";

        $integridades = [];

        foreach ($perfiles as $perfil) {
            $integridades[$perfil["id"]] = $this->modelo->verificarIntegridad($perfil["id"]);
        }

        $this->cargarVista("perfiles/crear", [
            "tituloPagina" => $tituloPagina,
            "catalogos" => $catalogos,
            "colaboradores" => $colaboradores,
            "perfiles" => $perfiles,
            "datosFormulario" => $datosFormulario,
            "errores" => $errores,
            "mensajeError" => $mensajeError,
            "mensaje" => $mensaje,
            "integridades" => $integridades
        ]);
    }

    public function editar()
    {
        $id = $_GET["id"] ?? 0;

        $perfil = $this->modelo->obtenerPorId($id);

        if (!$perfil) {
            header("Location: index.php?accion=crear_perfil&mensaje=perfil_no_encontrado");
            exit;
        }

        $tituloPagina = "Editar perfil laboral";
        $catalogos = $this->catalogo->obtenerTodos();
        $colaboradores = $this->colaboradorModelo->listar();
        $datosFormulario = $perfil;
        $errores = [];
        $mensajeError = "";

        $this->cargarVista("perfiles/editar", [
            "tituloPagina" => $tituloPagina,
            "catalogos" => $catalogos,
            "colaboradores" => $colaboradores,
            "datosFormulario" => $datosFormulario,
            "errores" => $errores,
            "mensajeError" => $mensajeError
        ]);
    }

    public function actualizar()
    {
        $id = $_POST["id"] ?? 0;

        $respuesta = $this->modelo->actualizar($id, $_POST);

        if ($respuesta["success"]) {
            header("Location: index.php?accion=crear_perfil&mensaje=perfil_actualizado");
            exit;
        }

        $tituloPagina = "Editar perfil laboral";
        $catalogos = $this->catalogo->obtenerTodos();
        $colaboradores = $this->colaboradorModelo->listar();
        $datosFormulario = $_POST;
        $errores = $respuesta["errors"];
        $mensajeError = $respuesta["message"];

        $this->cargarVista("perfiles/editar", [
            "tituloPagina" => $tituloPagina,
            "catalogos" => $catalogos,
            "colaboradores" => $colaboradores,
            "datosFormulario" => $datosFormulario,
            "errores" => $errores,
            "mensajeError" => $mensajeError
        ]);
    }
}

?>