<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar librerías y clases
require 'vendor/autoload.php';
include("config/mysql.inc.php");
include("app/Helpers/SanitizarEntrada.php");
include("app/Models/RegistroUsuario.php"); // Requisito: Importar la clase del modelo

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

// Requisito: Generar Token Anti-CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$mensaje = "";
$qr_html = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Requisito: Validar el Token Anti-CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("<div style='color:red; padding:20px;'>Error de seguridad: Token CSRF inválido.</div>");
    }

    // 2. Requisito: Sanitizar los datos de entrada
    $nombre = SanitizarEntrada::sanitizarTexto($_POST['nombre']);
    $apellido = SanitizarEntrada::sanitizarTexto($_POST['apellido']);
    $usuario = SanitizarEntrada::sanitizarTexto($_POST['usuario']);
    $correo = SanitizarEntrada::sanitizarEmail($_POST['email']);
    
    $clave = $_POST['clave'];
    $clave_again = $_POST['clave_again'];

    // 3. Requisito: Validaciones básicas
    if (!SanitizarEntrada::validarEmail($correo)) {
        $mensaje = "<div style='color: red;'>El formato del correo electrónico no es válido.</div>";
    } elseif ($clave !== $clave_again) {
        $mensaje = "<div style='color: red;'>Las contraseñas no coinciden. Inténtalo de nuevo.</div>";
    } else {
        
        try {
            // Usar la conexión segura
            $db = new mod_db();
            $pdo = $db->getConexion();
            
            // Instanciar la nueva clase de registro pasándole el objeto PDO
            $registroClase = new RegistroUsuario($pdo);

            // 4. Requisito: Validación de duplicados usando la clase
            if ($registroClase->existeUsuario($usuario, $correo)) {
                $mensaje = "<div style='color: red;'>Error: El Usuario o el Correo ya están registrados en el sistema.</div>";
            } else {
                
                // Generar el secreto 2FA
                $g = new GoogleAuthenticator();
                $secret_2fa = $g->generateSecret();

                // 5. Requisito: Guardar usando la clase (Enviando los 6 parámetros correspondientes)
                $guardado = $registroClase->guardarUsuario($nombre, $apellido, $usuario, $correo, $clave, $secret_2fa);

                if ($guardado) {
                    $mensaje = "<div style='color: green; padding: 10px; border: 1px solid green; margin-bottom: 15px;'>
                                    ¡Usuario <b>$usuario</b> registrado exitosamente!
                                </div>";

                    // Generar el Código QR
                    $app = 'Lab2FA_UTP';
                    $otpauth = "otpauth://totp/" . rawurlencode($app) . ":" . rawurlencode($correo) . "?secret=" . $secret_2fa . "&issuer=" . rawurlencode($app);
                    $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($otpauth);

                    $qr_html = "
                        <div style='text-align: center; margin-top: 20px; padding: 20px; background: #f9f9f9; border: 1px dashed #ccc;'>
                            <h3 style='color: #0056b3;'>¡Paso Final! Vincula tu cuenta</h3>
                            <p>Escanea este código con tu aplicación <strong>Google Authenticator</strong>:</p>
                            <img src='$qr_url' alt='Código QR 2FA' style='border: 5px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                            <br><br>
                            <a href='login.php' style='padding: 10px 20px; background:#0078FF; color:white; text-decoration:none; border-radius:5px;'>
                                Ir al Login para probar
                            </a>
                        </div>
                    ";
                } else {
                    $mensaje = "<div style='color: red;'>Error interno al intentar guardar el usuario.</div>";
                }
            }

        } catch (PDOException $e) {
            $mensaje = "<div style='color: red;'>Error en la base de datos: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Seguro - Lab 2FA</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Registro de Nuevo Usuario</h2>
    
    <?php echo $mensaje; ?>

    <?php if(empty($qr_html)): ?>
        <form method="POST" action="registro.php">
            
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" required
                value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" required
                value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>"    >
            </div>
            <div class="form-group">
                <label>Usuario:</label>
                <input type="text" name="usuario" required minlength="4"
                value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Correo electrónico:</label>
                <input type="email" name="email" required
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="clave" required minlength="6">
            </div>
            <div class="form-group">
                <label>Repetir Contraseña:</label>
                <input type="password" name="clave_again" required minlength="6">
            </div>
            <button type="submit">Registrar y Generar 2FA</button>
        </form>
    <?php else: ?>
        <?php echo $qr_html; ?>
    <?php endif; ?>
</div>

</body>
</html>