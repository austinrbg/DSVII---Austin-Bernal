<?php

require_once __DIR__ . "/../Models/Colaborador.php";
require_once __DIR__ . "/../Models/Catalogo.php";

class ColaboradorController
{
    private $modelo;
    private $catalogo;

    public function __construct()
    {
        $this->modelo = new Colaborador();
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
        $tituloPagina = "Registrar colaborador";
        $catalogos = $this->catalogo->obtenerTodos();
        $datosFormulario = [];
        $errores = [];
        $mensajeError = "";

        $this->cargarVista("colaboradores/crear", compact("tituloPagina", "catalogos", "datosFormulario", "errores", "mensajeError"));
    }

    public function guardar()
    {
        $respuesta = $this->modelo->guardar($_POST);

        if ($respuesta["success"]) {
            header("Location: index.php?accion=listar_colaboradores&mensaje=guardado");
            exit;
        }

        $tituloPagina = "Registrar colaborador";
        $catalogos = $this->catalogo->obtenerTodos();
        $datosFormulario = $_POST;
        $errores = $respuesta["errors"];
        $mensajeError = $respuesta["message"];

        $this->cargarVista("colaboradores/crear", compact("tituloPagina", "catalogos", "datosFormulario", "errores", "mensajeError"));
    }

    public function listar()
    {
        $tituloPagina = "Listado de colaboradores";
        $colaboradores = $this->modelo->listar();
        $mensaje = $_GET["mensaje"] ?? "";

        $this->cargarVista("colaboradores/listar", compact("tituloPagina", "colaboradores", "mensaje"));
    }

    public function editar()
    {
        $id = $_GET["id"] ?? 0;
        $colaborador = $this->modelo->obtenerPorId($id);

        if (!$colaborador) {
            header("Location: index.php?accion=listar_colaboradores&mensaje=no_encontrado");
            exit;
        }

        $tituloPagina = "Editar colaborador";
        $catalogos = $this->catalogo->obtenerTodos();
        $datosFormulario = $colaborador;
        $errores = [];
        $mensajeError = "";

        $this->cargarVista("colaboradores/editar", compact("tituloPagina", "catalogos", "datosFormulario", "errores", "mensajeError"));
    }

    public function actualizar()
    {
        $id = $_POST["id"] ?? 0;

        $respuesta = $this->modelo->actualizar($id, $_POST);

        if ($respuesta["success"]) {
            header("Location: index.php?accion=listar_colaboradores&mensaje=actualizado");
            exit;
        }

        $tituloPagina = "Editar colaborador";
        $catalogos = $this->catalogo->obtenerTodos();
        $datosFormulario = $_POST;
        $errores = $respuesta["errors"];
        $mensajeError = $respuesta["message"];

        $this->cargarVista("colaboradores/editar", compact("tituloPagina", "catalogos", "datosFormulario", "errores", "mensajeError"));
    }

    public function darBaja()
    {
        $id = $_GET["id"] ?? 0;
        $motivo = $_GET["motivo"] ?? "";

        $this->modelo->darBaja($id, $motivo);

        header("Location: index.php?accion=listar_colaboradores&mensaje=baja");
        exit;
    }

    public function reactivar()
    {
        $id = $_GET["id"] ?? 0;

        $this->modelo->reactivar($id);

        header("Location: index.php?accion=listar_colaboradores&mensaje=reactivado");
        exit;
    }
}

?>