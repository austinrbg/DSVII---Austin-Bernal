<?php

require_once __DIR__ . "/../Models/PerfilLaboral.php";

class ReporteController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new PerfilLaboral();
    }

    private function cargarVista($vista, $datos = [])
    {
        extract($datos);

        require_once __DIR__ . "/../Views/layout/header.php";
        require_once __DIR__ . "/../Views/" . $vista . ".php";
        require_once __DIR__ . "/../Views/layout/footer.php";
    }

    public function index()
    {
        $tituloPagina = "Reporte general";
        $registros = $this->modelo->reporteGeneral();

        $integridades = [];

        foreach ($registros as $fila) {
            if (!empty($fila["perfil_id"])) {
                $integridades[$fila["perfil_id"]] = $this->modelo->verificarIntegridad($fila["perfil_id"]);
            }
        }

        $this->cargarVista("reportes/index", [
            "tituloPagina" => $tituloPagina,
            "registros" => $registros,
            "integridades" => $integridades
        ]);
    }
}

?>