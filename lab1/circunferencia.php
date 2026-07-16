<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cálculo de Área y Perímetro de un Círculo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        input[type="number"] {
            padding: 8px;
            width: 200px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .resultado {
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Área y Perímetro de un Círculo</h2>
        <form method="post">
            <label for="radio">Ingrese el radio:</label><br>
            <input type="number" step="0.01" name="radio" id="radio" required><br>
            <button type="submit">Calcular</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $radio = floatval($_POST["radio"]);
            $area = M_PI * $radio * $radio;
            $perimetro = 2 * M_PI * $radio;

            echo "<div class='resultado'>El área del círculo con radio {$radio} es: " . number_format($area, 2) . "</div>";
            echo "<div class='resultado'>El perímetro del círculo con radio {$radio} es: " . number_format($perimetro, 2) . "</div>";
        }
        ?>
    </div>
</body>
</html>
