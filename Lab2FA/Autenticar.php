<?php
// Autenticar.php
session_start();

// Validar que el usuario haya pasado el primer filtro
if (!isset($_SESSION['2fa_pendiente']) || $_SESSION['2fa_pendiente'] !== "SI") {
    header("Location: login.php");
    exit();
}

require 'vendor/autoload.php';
include("config/mysql.inc.php");

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- VALIDACIÓN ANTI-CSRF ---
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("<div style='color:red; text-align:center; padding:20px; font-family:Arial; background: white; border-radius: 10px; margin: 50px auto; max-width: 500px;'>
                <h3>Error de Seguridad (CSRF)</h3>
                <p>La petición no es válida o el token ha expirado.</p>
                <a href='login.php' style='color: #00b894; text-decoration: none;'>Volver al inicio</a>
             </div>");
    }
    // ----------------------------

    $codigo_usuario = htmlspecialchars(trim($_POST['codigo_2fa']), ENT_QUOTES);

    $db = new mod_db();

    $usuario = $_SESSION['Usuario'];

    try {

        $sql = "SELECT secret_2fa FROM usuarios WHERE Usuario = :usuario";

        $conn = $db->getConexion();
        $stmt = $conn->prepare($sql);

        $stmt->execute([':usuario' => $usuario]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && !empty($resultado['secret_2fa'])) {

            $secret = $resultado['secret_2fa'];

            $g = new GoogleAuthenticator();

            if ($g->checkCode($secret, $codigo_usuario)) {

                $_SESSION['autenticado'] = "SI";

                unset($_SESSION['2fa_pendiente']);

                header("Location: formularios/PanelControl.php");
                exit();

            } else {

                $error = "Código incorrecto o expirado. Recuerda que cambia cada 30 segundos.";

            }

        } else {

            $error = "No se encontró la configuración 2FA para este usuario.";

        }

    } catch (PDOException $e) {

        $error = "Error de base de datos: " . $e->getMessage();

    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación 2FA - UTP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body{
            min-height:100vh;
            background: radial-gradient(circle at center, #1e3a5f 0%, #10213d 45%, #09111f 100%);
            display:flex; justify-content:center; align-items:center; padding:20px;
        }
        .contenedor{ width:100%; max-width:900px; text-align:center; }
        .logos{ display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .logos img{ object-fit:contain; }
        .logo-fisc{ width:120px; }
        .logo-2fa{ width:140px; }
        .logo-utp{ width:120px; }
        .auth-container{
            background:#ffffff; max-width:650px; margin:auto; padding:40px 50px;
            border-radius:15px; box-shadow: 0 10px 30px rgba(0,0,0,.35);
        }
        h2{ color:#10213d; font-size:2rem; font-weight:700; margin-bottom:10px; }
        .linea{ width:60px; height:4px; background:#00b894; margin:0 auto 20px auto; border-radius:50px; }
        p{ color:#4f5d75; font-size:1.1rem; line-height:1.4; margin-bottom:25px; }
        .error{ max-width:100%; margin:0 auto 20px; background:#ffe5e5; color:#c62828; padding:12px; border-radius:8px; font-size:14px; }
        input[type="text"]{
            width:100%; max-width:400px; height:70px; border:2px solid #cfd6df; border-radius:10px;
            font-size:2.5rem; text-align:center; letter-spacing:12px; color:#6b7280; transition:.3s; margin-bottom:25px;
        }
        input[type="text"]:focus{ outline:none; border-color:#00b894; box-shadow:0 0 10px rgba(0,184,148,.25); }
        button{
            width:100%; max-width:400px; background:#00b894; color:white; border:none; border-radius:10px;
            padding:16px; font-size:1.3rem; font-weight:600; cursor:pointer; transition:.3s; box-shadow:0 5px 15px rgba(0,184,148,.25);
        }
        button:hover{ background:#009c7d; transform:translateY(-2px); }
        button:active{ transform:translateY(0px); }
        @media(max-width:768px){
            .logos{ flex-direction:column; gap:15px; margin-bottom: 25px; }
            .auth-container{ padding:30px 20px; }
            h2{ font-size:1.6rem; }
            p{ font-size:1rem; }
            input[type="text"]{ height:60px; font-size:2rem; letter-spacing:8px; }
            button{ font-size:1.1rem; padding:14px; }
        }
    </style>
</head>
<body>

<div class="contenedor">
    <div class="logos">
        <img src="public/assets/img/fisc.png" alt="FISC" class="logo-fisc">
        <img src="public/assets/img/2fa.png" alt="2FA" class="logo-2fa">
        <img src="public/assets/img/utp.png" alt="UTP" class="logo-utp">
    </div>

    <div class="auth-container">
        <h2>Autenticación de Dos Factores</h2>
        <div class="linea"></div>
        <p>
            Ingresa el código de 6 dígitos generado por tu
            aplicación Google Authenticator.
        </p>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="Autenticar.php">
            
            <?php
            // Generar Token CSRF si no existe
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            ?>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <input
                type="text"
                name="codigo_2fa"
                maxlength="6"
                placeholder="000000"
                autocomplete="off"
                required
                autofocus
            >
            <br>
            <button type="submit">
                🔒 Verificar Código
            </button>
        </form>
    </div>
</div>

</body>
</html>