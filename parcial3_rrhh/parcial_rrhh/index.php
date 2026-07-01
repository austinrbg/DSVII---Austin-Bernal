<?php

require_once __DIR__ . "/app/Controllers/ReporteController.php";
require_once __DIR__ . "/app/Controllers/ColaboradorController.php";
require_once __DIR__ . "/app/Controllers/PerfilLaboralController.php";

$accion = $_GET["accion"] ?? "inicio";

switch ($accion) {

    case "inicio":
        $tituloPagina = "Inicio";

        require_once __DIR__ . "/app/Views/layout/header.php";
        ?>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="dashboard-card bg-card-blue">
                    <h3>RRHH</h3>
                    <p>Gestión de colaboradores</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card bg-card-green">
                    <h3>MVC</h3>
                    <p>Proyecto en PHP puro</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card bg-card-orange">
                    <h3>2026</h3>
                    <p>iTECH Contrataciones</p>
                </div>
            </div>
        </div>

        <div class="card card-custom">
            <div class="card-header">
                <h4>Panel principal</h4>
            </div>

            <div class="card-body">
                <p>
                    Bienvenido al sistema de Recursos Humanos. Desde este panel se pueden registrar colaboradores,
                    crear perfiles laborales, consultar historiales y exportar reportes.
                </p>

                <a href="index.php?accion=crear_colaborador" class="btn btn-primary">Registrar colaborador</a>
                <a href="index.php?accion=listar_colaboradores" class="btn btn-success">Ver colaboradores</a>
                <a href="index.php?accion=crear_perfil" class="btn btn-info text-white">Perfil laboral</a>
                <a href="index.php?accion=reporte" class="btn btn-warning">Reportes</a>
            </div>
        </div>

        <?php
        require_once __DIR__ . "/app/Views/layout/footer.php";
        break;

    case "crear_colaborador":
        $controller = new ColaboradorController();
        $controller->crear();
        break;

    case "guardar_colaborador":
        $controller = new ColaboradorController();
        $controller->guardar();
        break;

    case "listar_colaboradores":
        $controller = new ColaboradorController();
        $controller->listar();
        break;

    case "editar_colaborador":
        $controller = new ColaboradorController();
        $controller->editar();
        break;

    case "actualizar_colaborador":
        $controller = new ColaboradorController();
        $controller->actualizar();
        break;

    case "dar_baja":
        $controller = new ColaboradorController();
        $controller->darBaja();
        break;

    case "reactivar_colaborador":
        $controller = new ColaboradorController();
        $controller->reactivar();
        break;

    case "crear_perfil":
        $controller = new PerfilLaboralController();
        $controller->crear();
        break;

    case "guardar_perfil":
        $controller = new PerfilLaboralController();
        $controller->guardar();
        break;

    case "editar_perfil":
    $controller = new PerfilLaboralController();
    $controller->editar();
    break;

    case "actualizar_perfil":
    $controller = new PerfilLaboralController();
    $controller->actualizar();
    break;

    case "reporte":
    $controller = new ReporteController();
    $controller->index();
    break;
    
        ?>

        <div class="card card-custom">
            <div class="card-header">
                <h4>Reportes</h4>
            </div>

            <div class="card-body">
                <p>
                    Módulo de reportes en construcción. Aquí conectaremos el reporte general
                    y la exportación a Excel.
                </p>

                <a href="index.php" class="btn btn-primary">Volver al inicio</a>
                <a href="index.php?accion=listar_colaboradores" class="btn btn-success">Ver colaboradores</a>
            </div>
        </div>

        <?php
        require_once __DIR__ . "/app/Views/layout/footer.php";
        break;

    default:
        $tituloPagina = "Página no encontrada";

        require_once __DIR__ . "/app/Views/layout/header.php";
        ?>

        <div class="alert alert-danger alert-custom">
            La acción solicitada no existe.
        </div>

        <a href="index.php" class="btn btn-primary">Volver al inicio</a>

        <?php
        require_once __DIR__ . "/app/Views/layout/footer.php";
        break;
}

?>