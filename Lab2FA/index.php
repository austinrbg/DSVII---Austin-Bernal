<?php
session_start();

// No logueado → inicio
if (!isset($_SESSION['Usuario'])) {
    header("Location: /Lab2FA/inicio.php");
    exit;
}

// 2FA pendiente
if (isset($_SESSION['2fa_pendiente']) && $_SESSION['2fa_pendiente'] === "SI") {
    header("Location: /Lab2FA/Autenticar.php");
    exit;
}

// Logueado completo → panel
header("Location: /Lab2FA/formularios/PanelControl.php");
exit;