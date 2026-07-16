<?php
session_start();

$hash = "";
$resultado = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $clave = $_POST["clave"] ?? "";
    $hash = $_POST["hash"] ?? "";

    // GENERAR HASH
    if (isset($_POST["generar"])) {
        $hash = password_hash($clave, PASSWORD_BCRYPT);
    }

    // VALIDAR HASH
    if (isset($_POST["validar"])) {
        if (password_verify($clave, $hash)) {
            $resultado = "✔ Contraseña válida";
        } else {
            $resultado = "❌ Contraseña incorrecta";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Demo Hash</title>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #003366;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        text-align: center;
        max-width: 450px;
        width: 100%;
    }

    h2 {
        color: #333;
        margin-bottom: 15px;
    }

    label {
        display: block;
        text-align: left;
        font-weight: bold;
        margin-top: 10px;
        color: #444;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
    }

    textarea {
        resize: none;
    }

    .btn {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        font-weight: bold;
        color: white;
        cursor: pointer;
        margin-top: 5px;
    }

    .btn-generar {
        background-color: #0078FF;
    }

    .btn-generar:hover {
        background-color: #005bb5;
    }

    .btn-validar {
        background-color: #28a745;
    }

    .btn-validar:hover {
        background-color: #218838;
    }

    .resultado {
        margin-top: 15px;
        font-weight: bold;
        padding: 10px;
        border-radius: 6px;
    }

    .ok {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
</head>

<body>

<div class="container">
    <h2>Interfaz de Hash (Demo)</h2>

    <form method="POST">

        <label>Contraseña:</label>
        <input type="text" name="clave">

        <label>Hash generado:</label>
        <textarea name="hash"><?php echo htmlspecialchars($hash); ?></textarea>

        <button type="submit" class="btn btn-generar" name="generar">Generar Hash</button>
        <button type="submit" class="btn btn-validar" name="validar">Validar</button>

    </form>

    <?php if ($resultado): ?>
        <div class="resultado <?php echo strpos($resultado,'✔') !== false ? 'ok' : 'error'; ?>">
            <?php echo $resultado; ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>