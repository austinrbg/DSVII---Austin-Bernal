<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conversión de Pulgadas a Centímetros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 25px 35px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
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
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
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
        <h2>Conversión de Pulgadas a Centímetros</h2>
        <form method="post">
            <label for="pulgadas">Ingrese la cantidad de pulgadas:</label><br>
            <input type="number" step="0.01" name="pulgadas" id="pulgadas" required><br>
            <button type="submit">Convertir</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pulgadas = floatval($_POST["pulgadas"]);
            $centimetros = $pulgadas * 2.54;
            echo "<div class='resultado'>{$pulgadas} pulgadas = " . number_format($centimetros, 2) . " cm</div>";
        }
        ?>
    </div>
</body>
</html>
