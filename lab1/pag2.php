<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ffffff, #e0eafc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .resultado {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s ease;
        }

        .resultado:hover {
            transform: translateY(-5px);
        }

        .resultado h2 {
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .mensaje {
            font-weight: 500;
            color: #ff6f91; /* rosado */
            margin: 10px 0;
        }

        .mensaje strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="resultado">
        <h2>Resultado del formulario</h2>
        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trimming y sanitización
    $Nombre = trim($_POST['nombre']);
    $Edad   = trim($_POST['edad']);

    // Sanitizar
    $Nombre = filter_var($Nombre, FILTER_SANITIZE_STRING);
    $Edad   = filter_var($Edad, FILTER_SANITIZE_NUMBER_INT);

    // Normalizar nombre (primera letra mayúscula en cada palabra)
    $Nombre = ucwords(strtolower($Nombre));

    // Validación del nombre
    if (empty($Nombre)) {
        echo "<p class='mensaje'>El nombre no puede estar vacío.</p>";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $Nombre)) {
        echo "<p class='mensaje'>El nombre solo puede contener letras y espacios.</p>";
    } else {
        echo "<p class='mensaje'>El nombre es: <strong>" . htmlspecialchars($Nombre) . "</strong></p>";
    }

    // Validación de la edad
    if (empty($Edad)) {
        echo "<p class='mensaje'>La edad no puede estar vacía.</p>";
    } elseif (!filter_var($Edad, FILTER_VALIDATE_INT)) {
        echo "<p class='mensaje'>La edad debe ser un número entero.</p>";
    } elseif ($Edad < 0 || $Edad > 120) {
        echo "<p class='mensaje'>La edad debe estar entre 0 y 120.</p>";
    } else {
        if ($Edad >= 18) {
            echo "<p class='mensaje'>Usted puede votar en las próximas elecciones 2028</p>";
        } else {
            echo "<p class='mensaje'>Usted no es mayor de edad</p>";
        }
    }
}
?>
    </div>
</body>
</html>
