<?php
$tituloPagina = $tituloPagina ?? "Sistema RRHH";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $tituloPagina; ?> - iTECH Contrataciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/estilos.css" rel="stylesheet">
</head>

<body>

<header class="main-header">
    <div class="container">
        <div class="header-content">
            <div>
                <h1>iTECH Contrataciones</h1>
                <p>Sistema de gestión de colaboradores y perfiles laborales</p>
            </div>

            <div class="header-badge">
                RRHH 2026
            </div>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-dark nav-custom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Panel RRHH</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?accion=crear_colaborador">Registrar colaborador</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?accion=listar_colaboradores">Colaboradores</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?accion=crear_perfil">Perfil laboral</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?accion=reporte">Reportes</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container main-container">